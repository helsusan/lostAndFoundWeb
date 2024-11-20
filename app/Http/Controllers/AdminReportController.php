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
    
}
