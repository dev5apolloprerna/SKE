<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::active()->with('subcategories')->get();
        return view('front.pages.contact', compact('categories'));
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:120',
            'company_name' => 'nullable|string|max:160',
            'email'        => 'nullable|email|max:160',
            'phone'        => 'required|string|max:40',
            'message'      => 'nullable|string|max:2000',
        ]);
        $data['status'] = 'new';
        Inquiry::create($data);
        return back()->with('success', 'Thank you! We will contact you shortly.');
    }

    public function inquiry(Request $request)
    {
        $data = $request->validate([
            'product_id'   => 'nullable|exists:products,id',
            'name'         => 'required|string|max:120',
            'company_name' => 'nullable|string|max:160',
            'email'        => 'nullable|email|max:160',
            'phone'        => 'required|string|max:40',
            'quantity'     => 'nullable|string|max:80',
            'message'      => 'nullable|string|max:2000',
        ]);
        $data['status'] = 'new';
        Inquiry::create($data);
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Inquiry submitted successfully!']);
        }
        return back()->with('success', 'Inquiry submitted! We will get back to you soon.');
    }
}
