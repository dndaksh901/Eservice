<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Occupation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class OccupationController extends Controller
{
    public function index()
    {
        $occupations = Occupation::paginate(10); // You can adjust the number per page as needed
        return view('occupations.index', compact('occupations'));
    }

    public function create()
    {
        return view('occupations.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'occupation_name' => 'required|unique:occupations',
            // 'status' => 'boolean',
            // Add other validation rules for additional fields as needed
        ]);

        if ($validator->fails()) {
            return redirect()->route('occupations.create')
                ->withErrors($validator)
                ->withInput();
        }

        $occupation = new Occupation();
        $occupation->occupation_name = $request->input('occupation_name');
        $occupation->slug = Str::slug($request->input('occupation_name')); // Generate slug
        $occupation->status = $request->input('status', false);
        $occupation->save();

        return redirect()->route('occupations.index')->with('success', 'Occupation created successfully.');
    }

    public function edit(Occupation $occupation)
    {
        return view('occupations.edit', compact('occupation'));
    }

    public function update(Request $request, Occupation $occupation)
    {
        $request->validate([
            'occupation_name' => 'required|unique:occupations,occupation_name,' . $occupation->id,
            // 'status' => 'boolean',
        ]);

        if ($request->input('status') == "on") {
            $status = 1;
        } else {
            $status = 0;
        }

        $occupation->occupation_name = $request->input('occupation_name');
        $occupation->slug = Str::slug($request->input('occupation_name')); // Update slug
        $occupation->status = $status;
        $occupation->save();

        // return $status;
        return redirect()->route('occupations.index')->with('success', 'Occupation updated successfully.');
    }

    public function destroy(Occupation $occupation)
    {
        $occupation->delete();
        return redirect()->route('occupations.index')->with('success', 'Occupation deleted successfully.');
    }

    private function createOrUpdateOccupation(Request $request, Occupation $occupation = null)
    {
        if (!$occupation) {
            $occupation = new Occupation();
        }

        $occupation->occupation_name = $request->input('occupation');
        $occupation->slug = Str::slug($request->input('occupation'));
        $occupation->save();
    }
}
