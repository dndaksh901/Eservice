<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Occupation;
use App\Models\Profile;
use App\Models\ProfileImage;
use App\Models\State;
use App\Models\City;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with('user', 'profile')->where('profile_id', $request->profile_id)->orderBy('id', 'desc')->simplePaginate(2);
        return response()->json(['reviews' => $reviews, 'status' => 200]);
    }
    public function CreateReview(Request $request)
    {
        $request->validate([]);
        $validator = Validator::make($request->all(), [
            'review' => 'required|min:5|max:255',
            'rating' => 'min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        Review::updateOrCreate([
            'user_id' => Auth::id(),
            'profile_id' => $request->profile_id,
            'vendor_id' => $request->vendor_id
        ],
        [
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        return response()->json(['success' => 'Post created successfully.']);
    }
}
