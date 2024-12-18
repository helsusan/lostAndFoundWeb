<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Session;

class LocationController extends Controller
{

    //Menampilkan list location
    public function showListLocation()
    {
        $locations = Location::all();
        return view('location', compact('locations'));
    }


    //menampilkan form edit location
    public function editLocation($id)
    {
        $location = Location::findOrFail($id);
        return view('locationForm', compact('location'));
    }

    //update form location
    public function updateLocation(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'building' => 'required|string|max:255',
        ]);

        $location = Location::findOrFail($id);
        $location->update($request->only('name', 'building'));
   
        Session::flash('title', 'Changes Saved Successfully!');
        Session::flash('message', '');
        Session::flash('icon', 'success');

        return redirect()->route('locations.showLocationList')->with('success', 'Location updated successfully!');
    }


    //menghapus locations
    public function deleteLocation($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        Session::flash('title', 'Locations Deleted Successfully!');
        Session::flash('message', '');
        Session::flash('icon', 'success');

        return redirect()->route('locations.showLocationList')->with('success', 'Location deleted successfully!');
    }

    //menampilkan form untui add new location
    public function createLocation()
    {
        return view('locationForm');
    }


    // menyimpan new location di database
    public function insertLocation(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'building' => 'required|string|max:255',
        ]);

        Location::create($request->only('name', 'building'));

        Session::flash('title', 'Locations Created Successfully!');
        Session::flash('message', '');
        Session::flash('icon', 'success');

        return redirect()->route('locations.showLocationList')->with('success', 'Location added successfully!');
    }
}
