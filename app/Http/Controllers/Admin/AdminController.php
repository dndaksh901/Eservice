<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use App\Models\Profile;
use App\Models\Vendor;
use Mockery\Expectation;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{

    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }


    /**
     * Admin Login
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
            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect('admin/dashboard');
            } else {
                return redirect()->back()->with('error_message', 'Invalid Email and Password');
            }
        }
        return view('admin.login');
    }
    /**
     * Admin Register
     */
    public function Register(Request $request)
    {

        if ($request->isMethod('post')) {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        }
        return $request->all();
    }

    /**
     * Admin Logout
     */
    public function logout()
    {
        Session::flush();
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    /**
     * View update Admin Password Page
     */
    public function updateAdminPassword(Request $request)
    {
        return view('admin.update_password');
    }

    /**
     * View update Admin Detail Page
     */
    public function updateAdminDetail(Request $request)
    {

        if ($request->isMethod('post')) {

            $rules = [
                'name'     => 'required|regex:/^[\pL\s\-]+$/u',
                'mobile'   => 'required|numeric|digits:10',
                'image'    => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ];

            $this->validate($request, $rules);

            // Get current profile Image
            $image = Admin::where('id', Auth()->guard('admin')->user()->id)->value('image');

            // Get Update profile Image
            if ($files = $request->file('image')) {
                $destinationPath = 'admin/profile_image'; // upload path
                $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage);
                $image = "$profileImage";
            }

            //Update Admin Detail

            Admin::where('id', Auth()->guard('admin')->user()->id)
                ->update([
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'image' => $image
                ]);

            return redirect()->back()->with('success', 'Update Details Successfully');
        }
        return view('admin.update_detail');
    }

    /**
     * Check Admin Current Password
     */
    public function adminCurrentPassword(Request $request)
    {

        $user = Auth::guard('admin')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => "Current password does not match.", 'status' => 400]);
        } else {
            return response()->json(['message' => "Current password does not match.", 'status' => 200]);
        }
    }

    /**
     * Update Admin Current Password
     */
    public function updateAdminCurrentPassword(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = Auth::guard('admin')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password does not match!');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password successfully changed!');
    }


    /**
     * Check vendors list
     */
    public function vendorList(Request $request)
    {
        $vendors = Vendor::with('profile')->get();
        return view('admin.vendor_list', compact('vendors'));
    }
    /**
     * Check vendors list
     */
    public function VendorStatus($id)
    {
        // return    $vendor = Profile::where('vendor_id', $id)->first();
        $vendor = Vendor::with('profile')->where('id', $id)->first();
        return view('admin.vendor_edit', compact('vendor'));
    }
    /**
     * Check vendors image update
     */
    public function vendorImageUpdate(Request $request, $id)
    {
        try {
            $rules = [
                'avatar' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ];

            $this->validate($request, $rules);

            // Get current profile Image
            $image = Vendor::where('id', $id)->value('avatar');

            // Get Update profile Image
            if ($files = $request->file('avatar')) {
                $destinationPath = 'vendor/vendor_image'; // upload path
                $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage);

                // Delete the old image if it exists
                if (isset($image) && file_exists($destinationPath . '/' . $image)) {
                    unlink($destinationPath . '/' . $image);
                }

                $image = $profileImage;
            }

            // Update Vendor Detail
            Vendor::where('id', $id)
                ->update([
                    'avatar' => $image
                ]);

            return response()->json(['success' => 'Image updated successfully', 'avatar' => $image]);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteProfileImage($id)
    {
        try {
            // Get the current profile image file name
            $image = Vendor::where('id', $id)->value('avatar');

            // Delete the image file
            $destinationPath = 'vendor/vendor_image';
            if (file_exists($destinationPath . '/' . $image)) {
                unlink($destinationPath . '/' . $image);
            }

            // Update the database record to set the avatar to null (assuming 'avatar' is the column in your database)
            Vendor::where('id', $id)->update(['avatar' => null]);

            return response()->json(['success' => 'Profile image deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function changeStatus($userId, $status)
    {
        $user = Vendor::findOrFail($userId);
        $user->update(['status' => $status]);

        return redirect()->back()->with('success', 'User status updated successfully');
    }
}
