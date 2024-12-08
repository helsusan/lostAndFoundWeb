<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Location; 
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Log;

class MyReportController extends Controller
{
    // List all report
    public function showMyReports()
    {
        // Ambil laporan milik pengguna yang sedang login
        $reports = Report::where('user_id', auth()->id())->get();

        return view('myReports', compact('reports'));
    }

    // Form edit
    public function editMyReport(Report $report)
    {
        // gabisa edit kalau udah di verified
        // if ($report->user_id !== auth()->id() || $report->is_verified) {
        //     abort(403, 'Unauthorized action.');
        // }

        // Ambil data lokasi yang diurutkan berdasarkan building
        $locations = Location::orderBy('building')->get();

        return view('myReportEdit', compact('report', 'locations'));
    }

    // update report
    public function updateMyReport($report, Request $request)
    {
        // dd($report,$request->all());
        Log::info("tes");
        try {
            DB::beginTransaction();
            $data=Report::where('id',$report);
            $report2=$data->first();
            Log::info($report2);
            if($report2==null){
                return DB::rollBack();
                Log::error("data not found");
                return redirect()->route('myreport.showReports')->with('error', "data not found");
            }
            // dd($report2, $request->all());
                if ($report2->user_id !== auth()->id() || $report2->is_verified) {
                    abort(403, 'Unauthorized action.');
                }
            
                // request dari name di blade
                $request->validate([
                    'description' => 'required|string|max:255',
                    'location_lost' => 'required|exists:locations,id',
                    'location_detail' => 'nullable|string|max:255',
                    'time_lost' => 'nullable|date',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
            
                // Update image
                if ($request->hasFile('image')) {
                    $imagePath = $this->uploadImage($request, $report2);
                }
            
                // dd($request->description,$request->location_lost, $request->location_detail, $request->time_lost);
                // dari database
                $data->update([
                    'description' => $request->description,
                    'location_id' => $request->location_lost,
                    'location_lost' => $request->location_detail,
                    'time_lost' => $request->time_lost,
                    'image' => $imagePath ?? $report2->image,
                ]);
            DB::commit();
            return redirect()->route('myreport.showReports')->with('success', 'Report updated successfully.');
        } catch(Exception $e){
            DB::rollBack();
            Log::error($e->getTraceAsString());
            return redirect()->route('myreport.showReports')->with('error', $e->getMessage());
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage(), $th->getTrace());
            return redirect()->route('myreport.showReports')->with('error', $th->getMessage());
        }
    }

    public function foundReport($id){
        try{
            DB::beginTransaction();
            // dd($id);
            $report = Report::where("id",$id)->update([
                "report_status_id"=>1,
            ]);
            DB::commit();
            return redirect()->route('myreport.showReports')->with('success', 'Report updated successfully.');
        } catch(Exception $e){
            DB::rollBack();
            Log::error($e->getTraceAsString());
            return redirect()->route('myreport.showReports')->with('error', $e->getMessage());
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage(), $th->getTrace());
            return redirect()->route('myreport.showReports')->with('error', $th->getMessage());
        }
    }

    // hapus report
    public function deleteMyReport(Report $report)
    {
        // if ($report->user_id !== auth()->id() || $report->is_verified) {
        //     return redirect()->route('myreport.showReports')->with('error', $report->is_verified ? "Report sudah diverifikasi":"Pengguna tidak terauntentikasi");
        //     // abort(403, 'Unauthorized action.');
        // }

        $report->delete();

        return redirect()->route('myreport.showReports')->with('success', 'Report deleted successfully.');
    }

    // Upload gambar
    private function uploadImage(Request $request, $report)
    {
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($report->image && file_exists(public_path($report->image))) {
                unlink(public_path($report->image));
            }

            // Simpan gambar baru
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->move(public_path('images'), $fileName);
            return 'images/' . $fileName;
        }

        return $report->image;
    }
}
