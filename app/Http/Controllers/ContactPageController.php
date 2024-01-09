<?php

namespace App\Http\Controllers;

use App\Models\ContactPage;
use Illuminate\Http\Request;

class ContactPageController extends Controller
{
    public function show()
    {
        $contactPage = ContactPage::latest()->first(); // Get the latest contact page content
        return view('admin.contact.setting', compact('contactPage'));
    }
    public function update(Request $request)
    {
        // $contactPage = ContactPage::latest()->firstOrNew();
        // $contactPage->update([
        //     'address' => $request->input('address'),
        //     'availability' => $request->input('availability')
        // ]);

        ContactPage::updateOrCreate(
            [],
            [
                'address' => $request->input('address'),
                'availability' => $request->input('availability')
            ]
        );

        return redirect()->to('admin/contact-setting')->with('success', 'Contact page content updated successfully.');
    }
}
