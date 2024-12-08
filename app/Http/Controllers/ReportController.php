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

        // Kirim data ke view
        return view('adminReport', compact('reports'));
    }

    public function createUserReport() {
        $locations = Location::all();
        return view('user.form', ['locations' => $locations]);
    }

    public function insertUserReport(Request $request){
        $request->validate([
            'description' => 'required|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'location' => 'required|exists:locations,id',
            'location_lost' => 'required|string|max:255',
            'time_lost' => 'required|date',
        ]);

        $timeFoundTimestamp = strtotime($request->time_lost);

        $report = new Report;
        $report->user_id = auth()->user()->id;
        $report->report_status_id = 2;
        $report->description = $request->description;
        $report->image = $this->uploadImage($request);
        $report->location_id = $request->location;
        $report->location_lost = $request->location_lost;
        $report->time_lost = date('Y-m-d H:i:s', $timeFoundTimestamp);
        $report->save();

        Session::flash('title', 'Report Berhasil Diinput!');
        Session::flash('message', '');
        Session::flash('icon', 'success');

        return redirect()->route('home')->with('success', 'Report has been successfully submitted.');
    }
    

    // Memperbaruhi status is__verified
    public function isVerified(Report $report)
    {
        $report->update(['is_verified' => 1]);
    
        return redirect()->route('admin.showAdminReport')
                         ->with('success', 'Verified berhasil');
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
    
        return redirect()->route('admin.showAdminReport')
                        ->with('success', 'Laporan berhasil diperbarui');
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
        return redirect()->route('admin.showAdminReport')->with('success', 'Report deleted successfully.');
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

        return redirect()->route('admin.showAdminReport')
                         ->with('success', 'Item successfully assigned to report.');
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
