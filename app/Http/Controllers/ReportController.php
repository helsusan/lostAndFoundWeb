<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Location;
use App\Models\Report;
use Illuminate\Http\Request;
use Session;

class ReportController extends Controller
{

    //show admin Reprot
    public function showAdminReport()
    {
        // Ambil data dari tabel reports dengan relasi
        $reports = Report::with(['user', 'item', 'location', 'reportStatus'])->get();

        // Format time_lost 
        $reports = $reports->map(function ($report) {
            $report->time_lost = \Carbon\Carbon::parse($report->time_lost)->format('d-m-y H:i:s');
            return $report;
        });


        // Kirim data ke adminReport
        return view('adminReport', compact('reports'));
    }

    // Memperbaruhi status is__verified
    public function isVerified(Report $report)
    {
        $report->update(['is_verified' => 1]);

        Session::flash('title', 'Verification Successful!');
        Session::flash('message', '');
        Session::flash('icon', 'success');
    
        return redirect()->route('admin.showAdminReport');
    }

    // Edit admin report
    public function editAdminReport(Report $report)
    {
        $locations = Location::orderBy('building')->get();
        return view('adminReportEdit', compact('report', 'locations'));
    }

    public function updateAdminReport(Request $request, Report $report)
    {
        // Validasi data input
        $request->validate([
            'description' => 'required|string|max:255',
            'location_lost' => 'required|exists:locations,id',
            'location_detail' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Perbarui gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request, $report);
            $report->image = $imagePath;
        }
    
        // Perbarui laporan
        $report->update([
            'description' => $request->description,
            'location_id' => $request->location_lost,
            'location_lost' => $request->location_detail,
        ]);

        Session::flash('title', 'Item successfully added!');
        Session::flash('message', '');
        Session::flash('icon', 'success');
    
        return redirect()->route('admin.showAdminReport');
    }
    

    private function uploadImage(Request $request, Report $report = null)
    {
        if ($request->hasFile('image')) {
            if ($report && $report->image && file_exists(public_path($report->image))) {
                unlink(public_path($report->image));
            }

            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $fileName);
            return 'images/' . $fileName;
        }

        return $report ? $report->image : null;
    }

    // Delete admin report
    public function deleteAdminReport(Report $report)
    {
        $report->delete();

        Session::flash('title', 'Report deleted successfully!');
        Session::flash('message', '');
        Session::flash('icon', 'success');

        return redirect()->route('admin.showAdminReport');
    }

    // Mengatur item status
    // Memperbaruhi data sesuai item yang dipilih
    public function assignItemToReport(Request $request, Report $report)
    {
        // Validasi input
        $request->validate([
            'item_id' => 'required|exists:items,id',
        ]);

        // Tetapkan item ke laporan
        $report->update(['item_id' => $request->item_id]);

        Session::flash('title', 'Item successfully assigned to report!');
        Session::flash('message', '');
        Session::flash('icon', 'success');

        return redirect()->route('admin.showAdminReport');
    }

    // Menampilkan detail item yang sudah ter assign
    public function detailItem(Item $item)
    {
        return view('adminItemDetail', compact('item'));
    }

    // Menampilkan list item yang belum terassign
    public function showAssignPage($reportId)
    {
        $report = Report::findOrFail($reportId);
    
        // Ambil items yang tidak ada di reports.item_id
        $items = Item::whereNotIn('id', Report::pluck('item_id')->filter())->get();
    
        return view('assignItem', compact('report', 'items'));
    }
    
}
