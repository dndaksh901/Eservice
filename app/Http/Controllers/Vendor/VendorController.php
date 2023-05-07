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
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;

class VendorController extends Controller
{
   /**
     * Vendor Dashboard
     */
    public function dashboard() {
        return view('vendor.dashboard');
       }

    /**
     * Vendor Login
     */
    public function login(Request $request){

        if($request->isMethod('post')){

           $request->validate([
               'email' => 'required|email',
               'password' => 'required',
           ]);

           $remember_me = $request->has('remember_me') ? true : false;
           $credentials = $request->only('email', 'password',$remember_me);
           if(Auth::guard('vendor')->attempt($credentials)){
               return redirect('vendor/dashboard');
           }
           else{
               return redirect()->back()->with('error_message','Invalid Email and Password');
           }
        }
               return view('vendor.login');
       }

       /**
        * Vendor Logout
        */
       public function logout(){
         Session::flush();
         Auth::guard('vendor')->logout();
         return redirect('vendor/login');
       }

        /**
        * Register Form
        */
        public function register(){
           return view('vendor.register');
        }
        /**
        * Create New Vendor
        */
        public function createVendor(Request $request){

           $request->validate([
            'username' => 'required|min:3',
            'name' => 'required|min:3',
            'email' => 'required|email|unique:vendors',
            'password' => 'required|confirmed|min:6'
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect("vendor/login")->with('message','You have signed-in');
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
       public function updateVendorPassword(Request $request){
          return view('vendor.update_password');
       }

       /**
        * View update Vendor Detail Page
        */
       public function updatePersonalDetail(Request $request) {
        $profile = Profile::with('vendor','occupation')->where('vendor_id',Auth::guard('vendor')->id())->first();

           if($request->isMethod('post')){

               $rules=[
                   'name'     => 'required|regex:/^[\pL\s\-]+$/u',
                   'mobile'   => 'required|numeric|digits:10',
                   'avatar'    => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
               ];

               $this->validate($request,$rules);

                // Get current profile Image
               $image=Vendor::where('id',Auth()->guard('vendor')->user()->id)->value('avatar');

               // Get Update profile Image
               if ($files = $request->file('avatar')) {
                   $destinationPath = 'vendor/vendor_image'; // upload path
                   $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                   $files->move($destinationPath, $profileImage);
                   $image = "$profileImage";
               }

               //Update Vendor Detail

               Vendor::where('id',Auth()->guard('vendor')->user()->id)
               ->update([
                   'name'=>$request->name,
                   'mobile'=>$request->mobile,
                   'dob'=>$request->dob,
                   'gender'=>$request->gender,
                   'avatar'=>$image
               ]);

               return redirect()->back()->with('success','Update Details Successfully');

           }


          return view('vendor.update_detail',compact('profile'));
       }

       /**
        * Check Vendor Current Password
        */
       public function vendorCurrentPassword(Request $request) {

           $user = Auth::guard('vendor')->user();

           if (!Hash::check($request->current_password, $user->password)) {
               return response()->json(['message'=>"Current password does not match.",'status' => 400]);
           }
           else{
               return response()->json(['message'=>"Current password does not match.",'status' => 200]);
           }
       }

       /**
        * Update Vendor Current Password
        */
       public function updateVendorCurrentPassword(Request $request) {

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
        public function updateprofileDetail(Request $request) {


           /* Fetch all active states*/
           $states = State::where('status',1)->orderBy('name','ASC')->get();

           /* Fetch Vendor address state*/
               if(isset(Auth::guard('vendor')->user()->state_id)){
                  $state_id= Auth::guard('vendor')->user()->state_id;
               }else{
                   $state_id =  $states[0]->id;
               }
               $cities = City::where('state_id',$state_id)->where('status',1)->orderBy('name','ASC')->get();

               if($request->isMethod('post')){

                $request->validate([
                    'avatar.*' => 'mimes:jpg,png,jpeg|max:1024',
                    ]);

                   $rules=[
                       'occupation_id' => 'required',
                       'address' => 'required',
                       'state_id' => 'required',
                       'city_id' => 'required',
                       'pincode' => 'required',
                   ];

                   $this->validate($request,$rules);

                   //Delete Previous Profile Image From Folder
                  $profile_images = ProfileImage::where('vendor_id',Auth::guard('vendor')->user()->id)->get();
                  if(count($profile_images) > 0){
                  foreach($profile_images as $profile_image){
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
                      $preview_image_count = ProfileImage::where('vendor_id',Auth::guard('vendor')->user()->id)->count();
                       if($preview_image_count == ''){
                        $preview_image_count = 0;
                       }

                       $avatar = $request->file('avatar');
                       $avator_count = count($avatar);
                        $total_images= $avator_count + $preview_image_count;
                    if($total_images < 6){
                       foreach ($avatar as $files) {
                           $destinationPath = 'vendor/profile_image';
                           $file_name = time().rand(1,99). "." . $files->getClientOriginalExtension();
                           $files->move($destinationPath, $file_name);
                           // $data[] = $file_name;

                           ProfileImage::create([
                               'vendor_id' =>Auth::guard('vendor')->user()->id,
                               'profile_image' => $file_name
                           ]);

                       }
                    }else{
                        return redirect()->back()->with('error','Only 5 images are allowed');
                    }
                   }
                   //Update Vendor Detail

                   Profile::updateOrCreate(['vendor_id' => Auth::guard('vendor')->user()->id],[
                       'occupation_id'=>$request->occupation_id,
                       'experience_year'=>$request->experience_year,
                       'experience_month'=>$request->experience_month,
                       'profile_description'=>$request->profile_description,
                       'price_per_hour'=>$request->price_per_hour,
                       'address'=>$request->address,
                       'state_id'=>$request->state_id,
                       'city_id'=>$request->city_id,
                       'pincode'=>$request->pincode,
                       'latitude'=>$request->latitude,
                       'longitude'=>$request->longitude,
                   ]);

                   return redirect()->back()->with('success','Update Details Successfully');

               }

              $occupations = Occupation::where('status',1)->orderBy('occupation_name','ASC')->get();
              $profile = Profile::with('vendor','occupation')->where('vendor_id',Auth::guard('vendor')->id())->first();
              return view('vendor.update_profile_detail',compact('profile','occupations','states','cities'));
            }

            /**
            *Preview image of profile Image
            **/

            public function PreveiwProfileImage(){
                $profileImages = ProfileImage::where('vendor_id',Auth::guard('vendor')->user()->id)->get();

                if(count($profileImages) > 0){
                    return response()->json(['status'=>200,'message'=>$profileImages]);
                }else{
                    return response()->json(['status'=>300,'message'=>"No Image"]);
                }
            }

             /**
            *Delete Preview image of profile Image
            **/

            public function DeletePreveiwProfileImage($id){
                $profileImages = ProfileImage::where('id',$id)->first();
                $image_path = "vendor/profile_image/$profileImages->profile_image";  // Value is not URL but directory file path
                      if(File::exists(public_path($image_path))) {
                          File::delete(public_path($image_path));
                       }else{
                        dd('File does not exists.');
                       }

                $profileImages = ProfileImage::where('id',$id)->delete();

                if($profileImages){
                    return response()->json(['status'=>200,'message'=>'Delete Successfully']);
                }else{
                    return response()->json(['status'=>300,'message'=>"No Image Delete"]);
                }
            }

            /**
             * Fetch all Enquiry of users
             */

            public function enquiryOfUser(){
                $enquiries = EnquiryUser::with('clientStatus','user')->where('vendor_id',Auth::id())->get();
                return view('vendor.enquiry',compact('enquiries'));
            }

            /**
             * Search Workers
             */
            public function searchView($id=1){
              return view('search');
            }
            public function search($occupation_id=null,$state_id=null,$city_id=null){

                if($occupation_id == null){
                   return redirect('/');
                }

                 $profiles = Profile::where('occupation_id',$occupation_id)
                 ->where('state_id',State::where('name',$state_id)->where('status',1)->value('id'))
                 ->where('city_id',City::where('name',$city_id)->where('status',1)->value('id'))
                 ->paginate('10');

                $state = $state_id;
                $city = $city_id;
                $search_occupation = Occupation::find($occupation_id);
                $occupations = Occupation::orderBy('occupation_name','ASC')->take(25)->get();

              return view('search',compact('profiles','search_occupation','occupations','state','city'));
            }
            public function searchByName($occupation=null,$state_id=null,$city_id=null){

                if($occupation == null){
                   return redirect('/');
                }
                 $occupation_id = Occupation::where('occupation_name','LIKE','%'.$occupation.'%')->orderBy('occupation_name','ASC')->value('id');
                 $profiles = Profile::where('occupation_id',$occupation_id)
                 ->where('state_id',State::where('name',$state_id)->where('status',1)->value('id'))
                 ->where('city_id',City::where('name',$city_id)->where('status',1)->value('id'))
                 ->paginate('10');

                $state = $state_id;
                $city = $city_id;
                $search_occupation = Occupation::find($occupation_id);
                $occupations = Occupation::orderBy('occupation_name','ASC')->take(25)->get();

              return view('search',compact('profiles','search_occupation','occupations','state','city'));
            }





}
