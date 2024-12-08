<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Item;
use App\Models\ItemCategory; 
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Menampilkan laporan yang sudah diverifikasi
        $verifiedReports = Report::where('is_verified', 1)
            ->with(['user', 'location'])
            ->get();

        // Mengambil semua kategori barang
        $categories = ItemCategory::all();

        // Filter berdasarkan kategori jika ada
        $query = Item::where('item_status_id', 2) // Status untuk Lost Goods
            ->with(['user', 'location', 'itemCategory']);
        
        // Jika ada kategori yang dipilih
        if ($request->has('category') && $request->category != '') {
            $query->where('item_category_id', $request->category);
        }

        // Menampilkan item Lost Goods setelah filter
        $lostGoodsItems = $query->get();

        // Menampilkan semua laporan
        $reports = Report::with(['user', 'item', 'location', 'reportStatus'])->get();

        return view('home', compact('verifiedReports', 'reports', 'lostGoodsItems', 'categories'));
    }

    // HomeController.php
    public function fetchVerifiedReports()
    {
        // Mengambil laporan yang diverifikasi
        $verifiedReports = Report::where('is_verified', 1)
            ->with(['user', 'location'])
            ->get();

        return response()->json($verifiedReports);
    }

    public function fetchLostGoods(Request $request)
    {
        $query = Item::where('item_status_id', 2) // Status Pending
            ->with(['user', 'location', 'itemCategory']);

        // Filter berdasarkan kategori jika ada
        if ($request->has('category') && $request->category != '') {
            $query->where('item_category_id', $request->category);
        }

        $lostGoodsItems = $query->get();

        return response()->json($lostGoodsItems);
    }

    

}
