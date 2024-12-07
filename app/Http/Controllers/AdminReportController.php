<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{

    //show admin Reprot
    public function showAdminReport()
    {
        // Ambil data dari tabel reports dengan relasi
        $reports = Report::with(['user', 'item', 'location', 'reportStatus'])->get();

        // Kirim data ke view
        return view('adminReport', compact('reports'));
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
        return view('adminReportEdit', compact('report'));
    }

    public function updateAdminReport(Request $request, Report $report)
    {
        // Validasi data input
        $request->validate([
            'description' => 'required|string|max:255',
            'location_lost' => 'nullable|string|max:255',
            'time_lost' => 'nullable|date',
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
            'location_lost' => $request->location_lost,
            'time_lost' => $request->time_lost ? \Illuminate\Support\Carbon::parse($request->time_lost) : null,
        ]);

        return redirect()->route('admin.showAdminReport')
                        ->with('success', 'Laporan berhasil diperbarui');
    }

    private function uploadImage(Request $request, $report)
    {
        if ($request->hasFile('image')) {
            if ($report->image && file_exists(public_path($report->image))) {
                unlink(public_path($report->image));
            }
    
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->move(public_path('images'), $fileName);
            return 'images/' . $fileName;
        }
    
        return $report->image;
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
