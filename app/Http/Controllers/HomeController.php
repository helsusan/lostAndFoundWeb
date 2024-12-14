<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // menampilkan halaman home dengan data lengkap
    public function index(Request $request)
    {
        // menampilkan laporan yang sudah diverifikasi
        $verifiedReports = Report::where('is_verified', 1)
            ->with(['user', 'location'])
            ->get();

        $categories = ItemCategory::all();

        // filter berdasarkan kategori jika ada
        $query = Item::where('item_status_id', 2) // status pending
            ->with(['user', 'location', 'itemCategory']);
        
        if ($request->has('category') && $request->category != '') {
            $query->where('item_category_id', $request->category);
        }

        // menampilkan item Lost Goods setelah filter
        $lostGoodsItems = $query->get();

        // menampilkan semua laporan
        $reports = Report::with(['user', 'item', 'location', 'reportStatus'])->get();

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
}
