<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $inquiries = Inquiry::with('product')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhereHas('product', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%")
                          ->orWhere('model_no', 'LIKE', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('admin.inquiries.index', compact('inquiries', 'search'));
    }

    public function edit($id)
    {
        $inquiry = Inquiry::with('product')->findOrFail($id);

        return view('admin.inquiries.add-edit', compact('inquiry'));
    }

    public function update(Request $request, $id)
    {
        $inquiry = Inquiry::findOrFail($id);

        $request->validate([
            'status' => 'required|in:new,contacted,quoted,closed,spam',
        ]);

        $inquiry->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Inquiry status updated successfully.');
    }

    public function destroy($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Inquiry deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        if (!$request->ids) {
            return response()->json([
                'status' => false,
                'message' => 'Please select records.',
            ]);
        }

        Inquiry::whereIn('id', $request->ids)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Selected inquiries deleted successfully.',
        ]);
    }
}