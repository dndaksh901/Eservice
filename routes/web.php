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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Vendor\VendorController;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

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
Route::group(['middleware' => 'prevent-back-history'],function(){
// Route::get('/', function () {
//     return view('index');
// });
Route::get('/', [UserController::class, 'index']);
//Categories
Route::get('categories',[HomeController::class,'allCategories']);

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
Route::view('/contact-us', 'contact');
Route::get('/contact-us', [UserController::class, 'contactUs']);
Route::post('/contact-us', [UserController::class, 'ContactUsForm'])->name('contact.store');

Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm']);
Route::get('/vendor/login', [LoginController::class,'showVendorLoginForm']);
Route::get('/admin/register', [RegisterController::class,'showAdminRegisterForm']);
Route::get('/vendor/register', [RegisterController::class,'showVendorRegisterForm']);

Route::post('/admin/login', [LoginController::class,'adminLogin']);
Route::post('/vendor/login', [LoginController::class,'vendorLogin']);
Route::post('/admin/register', [RegisterController::class,'createAdmin']);
Route::post('/vendor/register', [RegisterController::class,'createVendor']);



//Search Skilled Workers
Route::get('search',[VendorController::class,'searchView']);
Route::get('search/{occupation_id?}/{city_id?}/{state_id?}',[VendorController::class,'search']);
Route::get('search-by-name/{occupation?}/{city_id?}/{state_id?}/{min_price?}/{max_price?}',[VendorController::class,'searchByName']);
Route::post('search',[VendorController::class,'ajaxSearch']);

Route::controller(VendorController::class)->prefix('vendor')->middleware(['middleware' => 'auth:vendor'])->group(function () {
// Route::view('/vendor', 'vendor.vendor');


     // Profile images show and delete
    Route::get('previewImage','PreveiwProfileImage');
    Route::get('deleteProfileImage/{id}','DeletePreveiwProfileImage');

       // Vendor dashboard
      Route::get('dashboard','dashboard')->name('vendor.dashboard');
      // Vendor Logout
      Route::get('logout','logout');
      // Vendor update Password
      Route::match(['get','post'],'update-vendor-password','updateVendorPassword');
      // Vendor update Detail
      Route::match(['get','post'],'profession','updateProfession');
      // Vendor update Detail
      Route::match(['get','post'],'update-personal_detail','updatePersonalDetail');
      //check Vendor current Password
      // Vendor update Detail
    //   Route::match(['get','post'],'enquiry','enquiryOfUser');
    //   Route::match(['get','post'],'listing','enquiryOfListing');
      //check Vendor current Password
      Route::post('check-current-password','vendorCurrentPassword');
      //update Vendor current Password
      Route::post('update-current-password','updateVendorCurrentPassword');

      Route::get('message','messageList');
      Route::get('read-status-update/{id}','notificationStatusUpdate');
      Route::view('profile', 'vendor.profile');
});

Route::controller(App\Http\Controllers\Admin\AdminController::class)->prefix('admin')->middleware(['middleware' => 'auth:admin'])->group(function () {

    Route::view('/admin', 'admin.admin');
       //Admin dashboard
      Route::get('dashboard','dashboard')->name('admin.dashboard');
      // Admin Logout
      Route::get('logout','logout');
      // Admin update Password
      Route::match(['get','post'],'update-admin-password','updateAdminPassword');
      // Admin update Detail
      Route::match(['get','post'],'update-admin-detail','updateAdminDetail');
      //check Admin current Password
      Route::post('check-current-password','adminCurrentPassword');
      //update Admin current Password
      Route::post('update-current-password','updateAdminCurrentPassword');
     // Admin check vendor Detail
     Route::get('vendors-detail','vendorList')->name('admin.vendorList');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('vendor-profile/{id}',[VendorController::class,'vendorDetail'])->name('vendor.detail');
    Route::post('reviews', [ReviewController::class,'index']);
    Route::post('create-review', [ReviewController::class,'CreateReview']);
});

Route::get('logout', [LoginController::class,'logout']);
Route::get('get-countries',[AddressController::class,'countryGet']);
Route::get('city-by-state/{id}',[AddressController::class,'cityGet']);
Route::get('city-by-state-by-name/{name}',[AddressController::class,'cityGetByStateName']);

//Current Location Detail
Route::get('ip-address',[UserController::class,'getIpDetail']);
Route::get('userdata',[UserController::class,'showUser']);
Route::get('country',[VendorController::class,'countrydata']);
Route::post('notification',[NotificationController::class,'store'])->name('notification.store');
Route::post('favorite',[VendorController::class,'favorite']);

});

