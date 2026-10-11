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
        $validator = Validator::make($request->all(), [
            'profile_id' => 'required|integer|exists:profiles,id',
            'vendor_id'  => 'required|integer|exists:vendors,id',
            'review'     => 'required|string|min:5|max:500',
            'rating'     => 'required|numeric|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 422);
        }

        $userId = Auth::id();

        Review::updateOrCreate(
            [
                'user_id'    => $userId,
                'profile_id' => $request->profile_id,
                'vendor_id'  => $request->vendor_id
            ],
            [
                'review' => strip_tags($request->review),
                'rating' => (float) $request->rating,
            ]
        );

        // Recalculate and sync aggregate rating in Profile
        $avgRating = Review::where('profile_id', $request->profile_id)->avg('rating');
        Profile::where('id', $request->profile_id)->update(['rating' => round($avgRating, 1)]);

        return response()->json(['success' => 'Review submitted successfully.']);
    }
}
