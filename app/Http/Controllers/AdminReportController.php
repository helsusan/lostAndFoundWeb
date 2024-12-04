<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function showAdminReport()
    {
        // Ambil data dari tabel reports dengan relasi
        $reports = Report::with(['user', 'item', 'location', 'reportStatus'])->get();

        // Kirim data ke view
        return view('adminReport', compact('reports'));
    }

    public function isVerified(Report $report)
    {
        // Memastikan laporan yang sesuai diperbarui
        $report->update(['is_verified' => 1]);
    
        return redirect()->route('admin.showAdminReport')
                         ->with('success', 'Verified berhasil');
    }

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
        ]);

        // Perbarui laporan
        $report->update([
            'description' => $request->description,
            'location_lost' => $request->location_lost,
            'time_lost' => $request->time_lost ? \Illuminate\Support\Carbon::parse($request->time_lost) : null,
        ]);

        return redirect()->route('admin.showAdminReport')
                        ->with('success', 'Laporan berhasil diperbarui');
    }

    public function deleteAdminReport(Report $report)
    {
        $report->delete();
        return redirect()->route('admin.showAdminReport')->with('success', 'Report deleted successfully.');
    }

    
}
