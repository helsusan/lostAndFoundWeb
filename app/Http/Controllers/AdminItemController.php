<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class AdminItemController extends Controller
{
    public function showAdminItem()
    {
        $items = Item::with(['location', 'itemStatus', 'user', 'itemCategory'])->get();
        return view('adminItem', compact('items'));
    }

    public function editAdminItem(Item $item)
    {
        return view('adminItemEdit', compact('item'));
    }

    public function updateAdminItem(Request $request, Item $item)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'location_found' => 'nullable|string|max:255',
            'time_found' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $item->update([
            'description' => $request->description,
            'location_found' => $request->location_found,
            'time_found' => $request->time_found ? \Illuminate\Support\Carbon::parse($request->time_found) : null,
            'image' => $this->uploadImage($request, $item),
        ]);

        return redirect()->route('admin.showAdminItem')
                        ->with('success', 'Item updated successfully.');
    }

    public function deleteAdminItem(Item $item)
    {
        if ($item->image && file_exists(public_path($item->image))) {
            unlink(public_path($item->image));
        }

        $item->delete();

        return redirect()->route('admin.showAdminItem')
                        ->with('success', 'Item deleted successfully.');
    }

    private function uploadImage(Request $request, Item $item)
    {
        if ($request->hasFile('image')) {
            if ($item->image && file_exists(public_path($item->image))) {
                unlink(public_path($item->image));
            }

            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->move(public_path('images'), $fileName);
            return 'images/' . $fileName;
        }

        return $item->image;
    }

public function updateStatus(Request $request, $id)
    {
        // Find the item by ID
        $item = Item::find($id);
        
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item not found.']);
        }

        // Validate the request to ensure a valid status
        $validated = $request->validate([
            'status' => 'required|in:Found,Not Found',  // Ensure only valid statuses are accepted
        ]);

        // Update the item's status
        $item->status = $validated['status'];
        $item->save();

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Item status updated successfully.']);
    }

}
