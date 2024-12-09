<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Location;
use Illuminate\Http\Request;
use Session;

class ItemController extends Controller
{
    public function showAdminItem()
    {
        $items = Item::with(['location', 'itemStatus', 'user', 'itemCategory'])->get();
        return view('adminItem', compact('items'));
    }

    public function createAdminItem(){
        $categories = ItemCategory::all();
        $locations = Location::orderBy('building')->get();

        return view('admin.form', ['categories' => $categories, 'locations' => $locations]);
    }

    public function insertAdminItem(Request $request)
    {
        $request->validate([
            'item' => 'required|string|max:255',
            'category' => 'required|exists:item_categories,id',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'location' => 'required|exists:locations,id',
            'detail_location' => 'required|string|max:255',
            'time_found' => 'required|date',
        ]);
    
        $timeFoundTimestamp = strtotime($request->time_found);
    
        $item = new Item();
        $item->name = $request->item;
        $item->item_category_id = $request->category;
        $item->item_status_id = 2;
        $item->description = $request->description;
        $item->image =  $this->uploadImage($request);
        $item->location_id = $request->location;
        $item->location_found = $request->detail_location;
        $item->time_found = date('Y-m-d H:i:s', $timeFoundTimestamp);
        $item->save();
    
        Session::flash('title', 'Item Berhasil Diinput!');
        Session::flash('message', '');
        Session::flash('icon', 'success');
    
        return redirect()->route('admin.showAdminItem')->with('success', 'Item Berhasil Diinput!');
    }    

    public function editAdminItem(Item $item)
    {
        $locations = Location::orderBy('building')->get();
        $categories = ItemCategory::all();
    
        return view('adminItemEdit', compact('item', 'locations', 'categories'));
    }
    
    

    public function updateAdminItem(Request $request, Item $item)
    {
        // Validasi data input
        $request->validate([
            'description' => 'required|string|max:255',
            'item_category_id' => 'required|exists:item_categories,id',
            'location_found' => 'required|string|max:255',
            'time_found' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Perbarui gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request, $item);
            $item->image = $imagePath;
        }
    
        // Perbarui item
        $item->update([
            'item_category_id' => $request->item_category_id,
            'location_found' => $request->location_found,
            'description' => $request->description,
            'time_found' => $request->time_found ? \Illuminate\Support\Carbon::parse($request->time_found) : null,
        ]);
    
        Session::flash('title', 'Item successfully updated!');
        Session::flash('message', '');
        Session::flash('icon', 'success');
    
        return redirect()->route('admin.showAdminItem');
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

    private function uploadImage(Request $request, Item $item = null)
    {
        if ($request->hasFile('image')) {
            if ($item && $item->image && file_exists(public_path($item->image))) {
                unlink(public_path($item->image));
            }

            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $fileName);
            return 'images/' . $fileName;
        }

        return $item ? $item->image : null;
    }
    public function updateItemStatus(Request $request, $id)
    {
        try {
            $item = Item::find($id);

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found.'
                ], 404);
            }

            $validated = $request->validate([
                'item_status' => 'required|exists:item_statuses,id', 
            ]);

            $item->item_status_id = $validated['item_status'];
            $item->save();

            return response()->json([
                'success' => true,
                'message' => 'Item status updated successfully.',
                'updated_item_status_id' => $item->item_status_id
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the item status.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
