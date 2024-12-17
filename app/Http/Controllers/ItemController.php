<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Location;
use Exception;
use Illuminate\Http\Request;
use Session;

class ItemController extends Controller
{
    public function showAdminItem()
    {
        $items = Item::with(['location', 'itemStatus', 'user', 'itemCategory'])->get();

        $items = $items->map(function ($item) {
            $item->time_found = \Carbon\Carbon::parse($item->time_found)->format('d-m-y H:i:s');
            return $item;
        });

        return view('adminItem', compact('items'));
    }

    public function createAdminItem(){
        $categories = ItemCategory::all();
        $locations = Location::orderBy('building')->get();

        return view('admin.form', ['categories' => $categories, 'locations' => $locations]);
    }

    public function insertAdminItem(Request $request)
    {
        try {
            $request->validate([
                'item' => 'required|string|max:255',
                'category' => 'required|exists:item_categories,id',
                'description' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'location' => 'required|exists:locations,id',
                'detail_location' => 'required|string|max:255',
                'time_found' => 'required|date',
            ],[
                'item.required' => 'Nama item harus diisi.',
                'item.string' => 'Nama item harus berupa teks.',
                'category.required' => 'Kategori harus dipilih.',
                'category.exists' => 'Kategori tidak valid.',
                'description.required' => 'Deskripsi harus diisi.',
                'image.required' => 'Gambar harus diunggah.',
                'image.image' => 'File yang diunggah harus berupa gambar.',
                'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.',
                'image.max' => 'Ukuran gambar maksimal 2MB.',
                'location.required' => 'Lokasi harus dipilih.',
                'location.exists' => 'Lokasi tidak valid.',
                'detail_location.required' => 'Detail lokasi harus diisi.',
                'time_found.required' => 'Waktu ditemukan harus diisi.',
                'time_found.date' => 'Waktu ditemukan harus berupa tanggal yang valid.',
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
        } catch (Exception $e) {
            Session::flash('title', 'Error!');
            Session::flash('message', 'Terjadi kesalahan saat menyimpan data.');
            Session::flash('icon', 'error');
        
            return redirect()->back()->withInput();
        }
    }    

    public function editAdminItem(Item $item)
    {
        $locations = Location::orderBy('building')->get();
        
        return view('adminItemEdit', compact('item', 'locations'));
    }    
    
    public function updateAdminItem(Request $request, Item $item)
    {
        // validasi data input
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'location_found' => 'required|exists:locations,id',
            'location_detail' => 'nullable|string|max:255',
            'time_found' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a valid string.',
            'description.max' => 'The description cannot exceed 255 characters.',
            'location_found.required' => 'Please select a valid location.',
            'location_found.exists' => 'The selected location does not exist.',
            'location_detail.string' => 'The location detail must be a valid string.',
            'location_detail.max' => 'The location detail cannot exceed 255 characters.',
            'time_found.date' => 'The time found must be a valid date.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be in jpeg, png, jpg, or gif format.',
            'image.max' => 'The image size cannot exceed 2MB.',
        ]);
    
        // update image
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request, $item);
            $item->image = $imagePath;
        }
    
        // memperbarui data item
        $item->update([
            'description' => $validatedData['description'],
            'location_id' => $validatedData['location_found'],
            'location_found' => $validatedData['location_detail'],
            'time_found' => $validatedData['time_found'] ? \Illuminate\Support\Carbon::parse($validatedData['time_found']) : null,
            'image' => $item->image ?? null,
        ]);
    
        // pesan sukses
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

        Session::flash('title', 'Item Deleted Successfully!');
        Session::flash('message', '');
        Session::flash('icon', 'success');

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

    public function showAssignItemPage($id)
    {
        $item = Item::findOrFail($id);
        
        return view('adminItemAssign', compact('item'));
    }
    
    public function assignItem(Request $request, $id)
    {
        $request->validate([
            'owner_name' => 'required|string|max:255',
        ], [
            'owner_name.required' => 'The owner name field is required.',
            'owner_name.string' => 'The owner name must be a valid string.',
            'owner_name.max' => 'The owner name cannot exceed 255 characters.',
        ]);
    
        $item = Item::findOrFail($id);
    
        $item->owner_name = $request->input('owner_name');
        $item->save();
    
        return redirect()->route('admin.showAdminItem')->with('success', 'Item successfully assigned!');
    }
}
