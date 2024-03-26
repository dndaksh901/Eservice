<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\Occupation;
use App\Models\Profile;
use App\Models\ProfileImage;
use App\Models\State;
use App\Models\City;
use App\Models\EnquiryUser;
use App\Models\Favorite;
use App\Models\Review;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;

class VendorController extends Controller
{
    /**
     * Vendor Dashboard
     */
    public function dashboard()
    {

        $userReview = '';
        $reviews = Review::with('user', 'profile')
            ->where('vendor_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(10);
        $totalreviews = Review::where('vendor_id', Auth::id())->count();
        $totalmessage = EnquiryUser::where('vendor_id', Auth::id())->count();


        if ($reviews) {
            return view('vendor.dashboard', compact('reviews', 'totalreviews', 'totalmessage'));
        } else {


            return view('vendor.dashboard');
        }
    }
    /**
     * Vendor Login
     */
    public function login(Request $request)
    {

        if ($request->isMethod('post')) {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $remember_me = $request->has('remember_me') ? true : false;
            $credentials = $request->only('email', 'password', $remember_me);
            if (Auth::guard('vendor')->attempt($credentials)) {
                return redirect('vendor/dashboard');
            } else {
                return redirect()->back()->with('error_message', 'Invalid Email and Password');
            }
        }
        return view('vendor.login');
    }

    /**
     * Vendor Logout
     */
    public function logout()
    {
        Session::flush();
        Auth::guard('vendor')->logout();
        return redirect('vendor/login');
    }

    /**
     * Register Form
     */
    public function register()
    {
        return view('vendor.register');
    }
    /**
     * Create New Vendor
     */
    public function createVendor(Request $request)
    {

        $request->validate([
            'username' => 'required|min:3',
            'name' => 'required|min:3',
            'email' => 'required|email|unique:vendors',
            'password' => 'required|confirmed|min:6'
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect("vendor/login")->with('message', 'You have signed-in');
    }

    public function create(array $data)
    {
        return Vendor::create([
            'username' => $data['username'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    /**
     * View update Vendor Password Page
     */
    public function updateVendorPassword(Request $request)
    {
        return view('vendor.update_password');
    }

    /**
     * View update Vendor Detail Page
     */
    public function updatePersonalDetail(Request $request)
    {
        $profile = Profile::with('vendor', 'occupation')->where('vendor_id', Auth::guard('vendor')->id())->first();

        if ($request->isMethod('post')) {

            $rules = [
                'name'     => 'required|regex:/^[\pL\s\-]+$/u',
                'mobile'   => 'required|numeric|digits:10',
                'avatar'    => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ];

            $this->validate($request, $rules);

            // Get current profile Image
            $image = Vendor::where('id', Auth()->guard('vendor')->user()->id)->value('avatar');

            // Get Update profile Image
            if ($files = $request->file('avatar')) {
                $destinationPath = 'vendor/vendor_image'; // upload path
                $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage);
                if (file_exists($destinationPath . '/' . $image)) {
                    unlink($destinationPath . '/' . $image);
                }
                $image = "$profileImage";
            }

            //Update Vendor Detail

            Vendor::where('id', Auth()->guard('vendor')->user()->id)
                ->update([
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'dob' => $request->dob,
                    'gender' => $request->gender,
                    'introduction' => $request->introduction,
                    'facebook' => $request->facebook,
                    'twitter' => $request->twitter,
                    'youtube' => $request->youtube,
                    'instagram' => $request->instagram,
                    'avatar' => $image
                ]);

            return redirect()->back()->with('success', 'Update Details Successfully');
        }

        return view('vendor.update_detail', compact('profile'));
    }

    /**
     * Check Vendor Current Password
     */
    public function vendorCurrentPassword(Request $request)
    {

        $user = Auth::guard('vendor')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => "Current password does not match.", 'status' => 400]);
        } else {
            return response()->json(['message' => "Current password does not match.", 'status' => 200]);
        }
    }

    /**
     * Update Vendor Current Password
     */
    public function updateVendorCurrentPassword(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = Auth::guard('vendor')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password does not match!');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password successfully changed!');
    }

    /**
     * View update Vendor Detail Page
     */
    public function updateProfession(Request $request)
    {

        $expired_date = date('Y-m-d 00:00:00', strtotime('+3 months'));
        /* Fetch all active states*/
        $states = State::where(['country_id' => 101, 'status' => 1])
            ->orderBy('name', 'ASC')
            ->get();

        /* Fetch Vendor address state*/
        if (isset(Auth::guard('vendor')->user()->state_id)) {
            $state_id = Auth::guard('vendor')->user()->state_id;
        } else {
            $state_id =  $states[0]->id;
        }
        $cities = City::where('state_id', $state_id)
            ->where('status', 1)
            ->orderBy('name', 'ASC')
            ->get();

        if ($request->isMethod('post')) {

            $request->validate([
                'avatar.*' => 'mimes:jpg,png,jpeg|max:1024',
            ]);

            $rules = [
                'occupation_id' => 'required',
                'address' => 'required|max:255',
                'state_id' => 'required',
                'city_id' => 'required',
                'pincode' => 'required',

            ];
            $tags = explode(",", $request->tags);
            $validator = Validator::make(request()->all(), $rules);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return redirect()->back()->withErrors($errors);
            }
            //Delete Previous Profile Image From Folder
            $profile_images = ProfileImage::where('vendor_id', Auth::guard('vendor')
                ->user()->id)
                ->get();
            if (count($profile_images) > 0) {
                foreach ($profile_images as $profile_image) {
                    $image_path = "vendor/profile_image/$profile_image->profile_image";  // Value is not URL but directory file path
                    //   if(File::exists(public_path($image_path))) {
                    //       File::delete(public_path($image_path));
                    //    }else{
                    //     dd('File does not exists.');
                    //    }
                }
            }
            // Get Update profile Image

            $preview_image_count = 0;
            if ($request->hasFile('avatar')) {
                //ProfileImage::where('vendor_id',Auth::guard('vendor')->user()->id)->delete();
                $preview_image_count = ProfileImage::where('vendor_id', Auth::guard('vendor')->user()->id)->count();
                if ($preview_image_count == '') {
                    $preview_image_count = 0;
                }

                $avatar = $request->file('avatar');
                $avator_count = count($avatar);
                $total_images = $avator_count + $preview_image_count;
                if ($total_images < 6) {
                    foreach ($avatar as $files) {
                        $destinationPath = 'vendor/profile_image';
                        $file_name = time() . rand(1, 99) . "." . $files->getClientOriginalExtension();
                        $files->move($destinationPath, $file_name);
                        // $data[] = $file_name;

                        $profile_image = ProfileImage::updateorCreate([
                            'vendor_id' => Auth::guard('vendor')->user()->id,

                            'profile_image' => $file_name
                        ]);
                    }
                } else {
                    return redirect()->back()->with('error', 'Only 5 images are allowed');
                }
            }

            $check_expired_date = Profile::where(['vendor_id' => Auth::guard('vendor')->user()->id, 'profile_status' => 1])->value('expired_at');
            if (!is_null($check_expired_date)) {
                $expired_date = $check_expired_date;
            }
            /* Update Vendor Detail */

            $profile = Profile::updateOrCreate(['vendor_id' => Auth::guard('vendor')->user()->id], [
                'occupation_id' => $request->occupation_id,
                'experience_year' => $request->experience_year,
                'experience_month' => $request->experience_month,
                'profile_description' => $request->profile_description,
                'services' => $request->services,
                'price_per_hour' => $request->price_per_hour,
                'address' => $request->address,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'pincode' => $request->pincode,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'expired_at' => $expired_date
            ]);

            return redirect()->back()->with('success', 'Update Details Successfully');
        }

        $occupations = Occupation::where('status', 1)->orderBy('occupation_name', 'ASC')->get();
        $profile = Profile::with('vendor', 'occupation')->where('profile_status', 1)->where('vendor_id', Auth::guard('vendor')->id())->first();
        return view('vendor.profession', compact('profile', 'occupations', 'states', 'cities'));
    }

    /**
     *Preview image of profile Image
     **/

    public function PreveiwProfileImage($id = null)
    {
        $profileImages = ProfileImage::where('vendor_id', Auth::guard('vendor')->user()->id)->get();

        if (count($profileImages) > 0) {
            return response()->json(['status' => 200, 'message' => $profileImages]);
        } else {
            return response()->json(['status' => 300, 'message' => "No Image"]);
        }
    }

    /**
     *Delete Preview image of profile Image
     **/

    public function DeletePreveiwProfileImage($id)
    {
        $profileImages = ProfileImage::where('id', $id)->first();
        $image_path = "vendor/profile_image/$profileImages->profile_image";  // Value is not URL but directory file path
        if (File::exists(public_path($image_path))) {
            File::delete(public_path($image_path));
        } else {
            dd('File does not exists.');
        }

        $profileImages = ProfileImage::where('id', $id)->delete();

        if ($profileImages) {
            return response()->json(['status' => 200, 'message' => 'Delete Successfully']);
        } else {
            return response()->json(['status' => 300, 'message' => "No Image Delete"]);
        }
    }

    /**
     * Fetch all Enquiry of users
     */

    public function enquiryOfUser()
    {
        $enquiries = EnquiryUser::with('clientStatus', 'user')->where('vendor_id', Auth::id())->get();
        return view('vendor.enquiry', compact('enquiries'));
    }
    public function enquiryOfListing()
    {
        $enquiries = EnquiryUser::with('clientStatus', 'user')->where('vendor_id', Auth::id())->get();
        return view('vendor.listing', compact('enquiries'));
    }

    /**
     * Search Workers
     */
    public function searchView($id = 1)
    {
        return view('search');
    }
    public function search($occupation_slug = null, $city_id = null, $state_id = null)
    {
        $ipDetails = Session::get('ip_details');
        if ($occupation_slug == null) {
            return redirect('/');
        }
        if ($city_id == null || $state_id == null) {
           $city_id= $ipDetails->cityName;
           $state_id= $ipDetails->regionName;
        }

        $min_price = 1;
        $max_price = 1000;
        $occupation_id = Occupation::where('slug', 'LIKE', '%' . $occupation_slug . '%')->orderBy('occupation_name', 'ASC')->value('id');
        $profiles = Profile::with('favorite')->where('occupation_id', $occupation_id)
            ->where('profile_status', 1)
            ->where('state_id', State::where('name', $state_id)->where('status', 1)->value('id'))
            ->where('city_id', City::where('name', $city_id)->where('status', 1)->value('id'))
            ->orderBy('price_per_hour', 'desc')
            ->paginate('10');

        $state = $state_id;
        $city = $city_id;
        $search_occupation = Occupation::find($occupation_id);
        $occupations = Occupation::orderBy('occupation_name', 'ASC')->take(25)->get();

        return view('search', compact('profiles', 'search_occupation', 'occupations', 'state', 'city', 'min_price', 'max_price'));
    }
    public function searchByName($occupation = null, $city_id = null, $state_id = null, $min_price = null, $max_price = null)
    {

        if ($occupation == null) {
            return redirect('/');
        }
        if ($min_price == null) {
            $min_price = 1;
        }
        if ($max_price == null) {
            $max_price = 1000;
        }
        $occupation_id = Occupation::where('slug', 'LIKE', '%' . $occupation . '%')->orderBy('occupation_name', 'ASC')->value('id');

        $profiles = Profile::where('occupation_id', $occupation_id)
            ->where('profile_status', 1)
            ->where('state_id', State::where('name', $state_id)->where('status', 1)->value('id'))
            ->where('city_id', City::where('name', $city_id)->where('status', 1)->value('id'))
            ->whereBetween('price_per_hour', [$min_price, $max_price])
            ->paginate('10');

        $state = $state_id;
        $city = $city_id;
        $search_occupation = Occupation::find($occupation_id);
        $occupations = Occupation::orderBy('occupation_name', 'ASC')->take(25)->get();

        return view('search', compact('profiles', 'search_occupation', 'occupations', 'state', 'city', 'min_price', 'max_price'));
    }


    public function ajaxSearch(Request $request)
    {

        $occupation = $request->occupation;
        $state = $request->state;
        $city = $request->city;
        $min_price = $request->min_price;
        $max_price = $request->max_price;

        if ($occupation == null) {
            return redirect('/');
        }

        $occupation_id = Occupation::where('occupation_name', 'LIKE', '%' . $occupation . '%')->orderBy('occupation_name', 'ASC')->value('id');

        $profiles = Profile::where('occupation_id', $occupation_id)
            ->where('state_id', State::where('name', $state)->where('status', 1)->value('id'))
            ->where('city_id', City::where('name', $city)->where('status', 1)->value('id'))
            ->whereBetween('price_per_hour', [$min_price, $max_price])
            ->paginate('10');

        return $profiles;
    }

    public function countrydata()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://referential.p.rapidapi.com/v1/country?fields=currency%2Ccurrency_num_code%2Ccurrency_code%2Ccontinent_code%2Ccurrency%2Ciso_a3%2Cdial_code&limit=250",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: referential.p.rapidapi.com",
                "X-RapidAPI-Key: af6b2b7d8amsh1faa58492f171bcp1aab95jsn9731526f6e9b"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    /**
     * Vendor detail page view
     */

    public function vendorDetail($id)
    {
        $userReview = '';
        $reviews = Review::with('user', 'profile')
            ->where('profile_id', $id)
            ->orderBy('id', 'desc')
            ->paginate(2);

        $userReview = Review::with('user', 'profile')
            ->where('profile_id', $id)
            ->where('user_id', Auth::id())
            ->select('review', 'rating')
            ->first();
        $profile = Profile::where(['id' => $id, 'profile_status' => 1])->first();

        if ($profile) {
            return view('detail', compact('profile', 'reviews', 'userReview'));
        } else {
            return response()->back();
        }
    }


    public function messageList(Request $request)
    {
        $messages = Notification::with('user', 'vendor')->where('vendor_id', Auth::id())->orderBy('id', 'DESC')->paginate(10);
        //  $data = '';
        //     if($request->ajax()){
        //         foreach($messages as $key=>$message){
        //           $url =  asset('vendor/profile_image/avatar.jpg');
        //           if($message->is_read == 0){
        //             $bg_color='bg-color';
        //             $readfunction="readMessage($message->is_read,$message->id)";
        //             $text='text-white';
        //           }else{
        //             $bg_color='';
        //             $readfunction='';
        //             $text='';
        //           }

        //             $data .= '<div class="card-header collapsed '. $bg_color.'"
        //             data-toggle="collapse" href="#collapse'.$key.'"
        //             id="main-message-'.$message->id.'" onclick="'.$readfunction.'">
        //             <a class="card-title'.$text.'"
        //                 id="message-title-'.$message->id.'">
        //                 <img src="'.$url.'"
        //                     alt="profile-image" class="user-image">
        //                 '.$message->name ?? $message->user->name.'
        //             </a>
        //             <span class="message-time">('.convertMdyToTimeAgo($message->created_at).')</span>
        //         </div>
        //       <div id="collapse'.$key.'" class="card-body collapse" data-parent="#accordion">
        //             <div class="card">
        //                 <div class="card-body">
        //                     <p><strong>Name: </strong> '. $message->name ?? $message->user->name .'</p>
        //                     <p><strong>Contact Number: </strong> '. $message->phone ?? '' .'</p>
        //                     <p><strong>Email: </strong>'. $message->user->email ?? '' .'</p>
        //                     <p><strong>Budget: </strong>Rs '. $message->budget ?? '' .'</p>
        //                     <p><strong>Message: </strong>'. $message->message .'</p>
        //                 </div>
        //             </div>
        //         </div>';
        //         }
        //         return $data;
        //     }
        return view('vendor.listing', compact('messages'));
    }
    public function reviewList()
    {
        return $reviews = Review::with('user')->where('vendor_id', Auth::id())->orderBy('id', 'DESC')->limit(20)->get();
        return view('vendor.review', compact('reviews'));
    }
    public function notificationStatusUpdate($id)
    {
        $statusUpdate = Notification::where('id', $id)->update(['is_read' => 1]);
        return 1;
    }

    public function favorite(Request $request)
    {

        if ($request->status == 'fav') {

            $fav = Favorite::create([
                'profile_id' => $request->profile_id,
                'vendor_id' => $request->vendor_id,
                'user_id' => $request->user_id
            ]);

            if (isset($fav)) {
                return 1;
            }
            return 'failed';
        } else {
            $fav = Favorite::where([
                'profile_id' => $request->profile_id,
                'vendor_id' => $request->vendor_id,
                'user_id' => $request->user_id
            ])->delete();
            return 1;
        }
    }

     /**
     * View update Vendor Detail Page
     */
    public function updatePersonalDetailByAdmin(Request $request)
    {
        // $profile = Profile::with('vendor', 'occupation')->where('vendor_id', Auth::guard('vendor')->id())->first();

        if ($request->isMethod('post')) {

            $rules = [
                'name'     => 'required|regex:/^[\pL\s\-]+$/u',
                'mobile'   => 'required|numeric|digits:10',
                'avatar'    => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ];

            $this->validate($request, $rules);

            // Get current profile Image
            $image = Vendor::where('id', Auth()->guard('vendor')->user()->id)->value('avatar');

            // Get Update profile Image
            if ($files = $request->file('avatar')) {
                $destinationPath = 'vendor/vendor_image'; // upload path
                $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage);
                if (file_exists($destinationPath . '/' . $image)) {
                    unlink($destinationPath . '/' . $image);
                }
                $image = "$profileImage";
            }

            //Update Vendor Detail

            Vendor::where('id', Auth()->guard('vendor')->user()->id)
                ->update([
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'dob' => $request->dob,
                    'gender' => $request->gender,
                    'introduction' => $request->introduction,
                    'facebook' => $request->facebook,
                    'twitter' => $request->twitter,
                    'youtube' => $request->youtube,
                    'instagram' => $request->instagram,
                    'avatar' => $image
                ]);

            return redirect()->back()->with('success', 'Update Details Successfully');
        }

        return view('vendor.update_detail', compact('profile'));
    }

}
