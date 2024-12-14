<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ReportStatus;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // menampilkan halaman home dengan data lengkap
    public function index(Request $request)
{
    // Menampilkan laporan yang sudah diverifikasi, kecuali yang report_status_id = 1
    $verifiedReports = Report::where('is_verified', 1)
        ->where('report_status_id', '!=', 1) // Exclude reports with report_status_id = 1
        ->with(['user', 'location'])
        ->get();

    $categories = ItemCategory::all();

    // Filter berdasarkan kategori jika ada
    $query = Item::where('item_status_id', 2) // Status pending
        ->with(['user', 'location', 'itemCategory']);
    
    if ($request->has('category') && $request->category != '') {
        $query->where('item_category_id', $request->category);
    }

    // Menampilkan item Lost Goods setelah filter
    $lostGoodsItems = $query->get();

    // Menampilkan semua laporan yang tidak memiliki report_status_id = 1
    $reports = Report::where('report_status_id', '!=', 1) // Exclude reports with report_status_id = 1
        ->with(['user', 'item', 'location', 'reportStatus'])
        ->get();

    return view('home', compact('verifiedReports', 'reports', 'lostGoodsItems', 'categories'));
}

    

    // fetch laporan yang sudah diverifikasi
    public function fetchVerifiedReports()
    {
        $verifiedReports = Report::where('is_verified', 1)
            ->with(['user', 'location'])
            ->get();

        return response()->json($verifiedReports);
    }

    // fetch Lost Goods
    public function fetchLostGoods(Request $request)
    {
        $query = Item::where('item_status_id', 2) // status pending
            ->with(['user', 'location', 'itemCategory']);

        // filter berdasarkan kategori jika ada
        if ($request->has('category') && $request->category != '') {
            $query->where('item_category_id', $request->category);
        }

        // mengambil data Lost Goods
        $lostGoodsItems = $query->get();

        return response()->json($lostGoodsItems);
    }

    // Fetch reports excluding those with report_status_id = 1
public function fetchReports(Request $request)
{
    $reports = Report::where('report_status_id', '!=', 1)
        ->with(['user', 'item', 'location', 'reportStatus'])
        ->get();

    return response()->json($reports);
}

}
