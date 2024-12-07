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

    public function updateItemStatus(Request $request, $id)
    {
        try {
            // Temukan item berdasarkan ID
            $item = Item::find($id);
    
            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found.'
                ], 404);
            }
    
            // Validasi input request
            $validated = $request->validate([
                'item_status' => 'required|in:Returned,Pending,Disposed', // Validasi hanya menerima status tertentu
            ]);
    
            // Cek jika itemStatus baru sama dengan yang sudah ada
            if ($item->item_status === $validated['item_status']) {
                return response()->json([
                    'success' => false,
                    'message' => 'The item status is already set to the selected value.'
                ], 400);
            }
    
            // Update item status
            $item->item_status = $validated['item_status'];
            $item->save();
    
            // Respon sukses
            return response()->json([
                'success' => true,
                'message' => 'Item status updated successfully.',
                'updated_item_status' => $item->item_status // Kembalikan status terbaru
            ], 200);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Tangani error lainnya
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the item status.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
