<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\OccupationController;
use App\Http\Controllers\ContactPageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Vendor\VendorForgotPasswordController;
use App\Http\Controllers\Vendor\VendorController;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('cache:clear');
    return 'Cache cleared successfully';
});

Route::group(['middleware' => 'prevent-back-history'], function () {
    // Route::get('/', function () {
    //     return view('index');
    // });
    Route::get('/', [UserController::class, 'index']);
    //Categories
    Route::get('categories', [HomeController::class, 'allCategories']);

    Route::get('lang/home', [LangController::class, 'index']);
    Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');

    // Route::get('call-helper', function(){

    //     $mdY = convertYmdToMdy('2022-02-12');
    //     var_dump("Converted into 'MDY': " . $mdY);

    //     $ymd = convertMdyToYmd('02-12-2022');
    //     var_dump("Converted into 'YMD': " . $ymd);
    // });
    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::view('/test', 'testpage');
    // Route::view('/contact-us', 'contact');
    Route::get('/contact-us', [UserController::class, 'contactUs']);
    Route::post('/contact-us', [UserController::class, 'ContactUsForm'])->name('contact.store');
    Route::view('/about-us', 'about-us');


    Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm']);
    Route::get('/vendor/login', [LoginController::class, 'showVendorLoginForm'])->name('vendor.login');
    Route::get('/admin/register', [RegisterController::class, 'showAdminRegisterForm']);
    Route::get('/vendor/register', [RegisterController::class, 'showVendorRegisterForm']);

    Route::post('/admin/login', [LoginController::class, 'adminLogin']);
    Route::post('/admin/register', [RegisterController::class, 'createAdmin']);
    Route::middleware(['middleware' => 'vendor.status'])->group(function () {
        Route::post('/vendor/login', [LoginController::class, 'vendorLogin']);
    });
    Route::post('/vendor/register', [RegisterController::class, 'createVendor']);



    //Search Skilled Workers
    Route::get('search', [VendorController::class, 'searchView']);
    Route::get('search/{occupation_slug?}/{city_id?}/{state_id?}', [VendorController::class, 'search']);
    Route::get('category/{occupation?}/{city_id?}/{state_id?}/{min_price?}/{max_price?}', [VendorController::class, 'searchByName']);
    Route::post('search', [VendorController::class, 'ajaxSearch']);

    Route::controller(VendorController::class)->prefix('vendor')->middleware(['middleware' => 'auth:vendor', 'vendor.status'])->group(function () {
        // Route::view('/vendor', 'vendor.vendor');


        // Profile images show and delete
        Route::get('previewImage', 'PreveiwProfileImage');
        Route::get('deleteProfileImage/{id}', 'DeletePreveiwProfileImage');

        // Vendor dashboard
        //   Route::get('dashboard','dashboard')->name('vendor.dashboard');

        // Vendor Logout
        Route::get('logout', 'logout');
        // Vendor update Password
        Route::match(['get', 'post'], 'update-vendor-password', 'updateVendorPassword');
        // Vendor update Detail
        Route::match(['get', 'post'], 'profession', 'updateProfession');
        // Vendor update Detail
        Route::match(['get', 'post'], 'update-personal_detail', 'updatePersonalDetail');
        //check Vendor current Password
        // Vendor update Detail
        //   Route::match(['get','post'],'enquiry','enquiryOfUser');
        //   Route::match(['get','post'],'listing','enquiryOfListing');
        //check Vendor current Password
        Route::post('check-current-password', 'vendorCurrentPassword');
        //update Vendor current Password
        Route::post('update-current-password', 'updateVendorCurrentPassword');

        Route::get('message/{page?}', 'messageList');
        Route::get('read-status-update/{id}', 'notificationStatusUpdate');

        Route::view('profile', 'vendor.profile');
        //   Route::get('reviews', 'reviewList');
    });

    Route::controller(App\Http\Controllers\Admin\AdminController::class)->prefix('admin')->middleware(['middleware' => 'auth:admin'])->group(function () {

        Route::view('/admin', 'admin.admin');
        //Admin dashboard
        Route::get('dashboard', 'dashboard')->name('admin.dashboard');
        // Admin Logout
        Route::get('logout', 'logout');
        // Admin update Password
        Route::match(['get', 'post'], 'update-admin-password', 'updateAdminPassword');
        // Admin update Detail
        Route::match(['get', 'post'], 'update-admin-detail', 'updateAdminDetail');
        //check Admin current Password
        Route::post('check-current-password', 'adminCurrentPassword');
        //update Admin current Password
        Route::post('update-current-password', 'updateAdminCurrentPassword');
        // Admin check vendor Detail
        Route::get('vendors-detail', 'vendorList')->name('admin.vendorList');
        Route::get('vendor-edit/{id}', 'VendorStatus')->name('admin.vendorstatus');
        Route::post('vendor-update/{id}', 'VendorDetailUpdate');
        Route::post('vendor-image-update/{id}', 'vendorImageUpdate')->name('admin.vendorImageUpdate');

        Route::get('delete-profile-image/{id}', 'deleteProfileImage');

        Route::post('/admin/user/{userId}/status/{status}', 'changeStatus')->name('admin.changeStatus');

        Route::get('/auto-login/{email}', 'autoLoginVendorByEmail')->name('auto-login-by-email');

        Route::put('/countries/{id}/enable-disable', 'enableDisableCountry')
            ->name('admin.countries.enableDisable');
        Route::get('/countries','countrylist')->name('admin.countries.index');
        Route::get('contact-setting', [ContactPageController::class, 'show'])->name('contact.show');
        Route::post('/contact-setting', [ContactPageController::class, 'update'])->name('contact.update');
        Route::get('/contact-list', [UserController::class, 'list'])->name('contact.list');
        Route::get('contact/{id}', [UserController::class, 'show'])->name('admin.contact-show');
        Route::get('contact/delete/{id}', [UserController::class, 'destroy'])->name('admin.destroy');
    });



    Route::prefix('admin')->middleware(['middleware' => 'auth:admin'])->group(function () {
        Route::get('/occupations', [OccupationController::class, 'index'])->name('occupations.index');
        Route::get('/occupations/create', [OccupationController::class, 'create'])->name('occupations.create');
        Route::post('/occupations', [OccupationController::class, 'store'])->name('occupations.store');
        Route::get('/occupations/{occupation}', [OccupationController::class, 'show'])->name('occupations.show');
        Route::get('/occupations/{occupation}/edit', [OccupationController::class, 'edit'])->name('occupations.edit');
        Route::post('/occupations/{occupation}', [OccupationController::class, 'update'])->name('occupations.update');
        Route::delete('/occupations/{occupation}', [OccupationController::class, 'destroy'])->name('occupations.destroy');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('vendor-profile/{id}', [VendorController::class, 'vendorDetail'])->name('vendor.detail');
        Route::post('reviews', [ReviewController::class, 'index']);
        Route::post('create-review', [ReviewController::class, 'CreateReview']);
    });

    Route::get('logout', [LoginController::class, 'logout']);
    Route::get('get-countries', [AddressController::class, 'countryGet']);
    Route::get('city-by-state/{id}', [AddressController::class, 'cityGet']);
    Route::get('city-by-state-by-name/{name}', [AddressController::class, 'cityGetByStateName']);

    //Current Location Detail
    Route::get('ip-address', [UserController::class, 'getIpDetail']);
    Route::get('userdata', [UserController::class, 'showUser']);
    Route::get('country', [VendorController::class, 'countrydata']);
    Route::post('notification', [NotificationController::class, 'store'])->name('notification.store');
    Route::post('favorite', [VendorController::class, 'favorite']);

    //razorpay
    Route::get('razorpay-payment', [RazorpayController::class, 'index']);
    Route::post('razorpay-payment', [RazorpayController::class, 'store'])->name('razorpay.payment.store');
});

// User Routes
// Route::prefix('user')->group(function () {
//     Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('user.password.request');
//     Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('user.password.email');
// });

// Vendor Routes
Route::prefix('vendor')->group(function () {
    Route::get('/forgot-password', [VendorForgotPasswordController::class, 'showLinkRequestForm'])->name('vendor.password.request');
    Route::post('/forgot-password', [VendorForgotPasswordController::class, 'sendResetLinkEmail'])->name('vendor.password.email');
});
