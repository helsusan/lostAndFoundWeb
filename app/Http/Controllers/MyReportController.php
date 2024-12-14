<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Location; 
use DB;
use Exception;
use Illuminate\Http\Request;
use Log;
use Session;

class MyReportController extends Controller
{
    public function showMyReports()
    {
        $reports = Report::where('user_id', auth()->id())->get();

        $reports = $reports->map(function (Report $report): Report {
            $report->time_lost = \Carbon\Carbon::parse($report->time_lost)->format('d-m-y H:i:s');
            return $report;
        });

        return view('myReports', compact('reports'));
    }

    public function createMyReport() {
        $locations = Location::orderBy('building')->get();
        return view('user.form', ['locations' => $locations]);
    }

    public function insertMyReport(Request $request){
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


    public function editMyReport(Report $report)
    {
        // ambil data lokasi yang diurutkan berdasarkan abjad building
        $locations = Location::orderBy('building')->get();
        return view('myReportEdit', compact('report', 'locations'));
    }

    // update report
    public function updateMyReport($report, Request $request)
    {
    // dd($report,$request->all());
    // Log::info("tes");
            $data = Report::where('id', $report);
            $report2 = $data->first();
            // Log::info($report2);

            if ($report2 == null) {
                DB::rollBack();
                Log::error(message: "Data not found");
                return redirect()->route('myreport.showReports')->with('error', "Data not found");
            }

            // dd($report2, $request->all());
            if ($report2->user_id !== auth()->id() || $report2->is_verified) {
                abort(403, 'Unauthorized action.');
            }

            // request dari name di blade dengan custom error messages
            $validatedData = $request->validate([
                'description' => 'required|string|max:255',
                'location_lost' => 'required|exists:locations,id',
                'location_detail' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'description.required' => 'The description field is required.',
                'description.string' => 'The description must be a valid string.',
                'description.max' => 'The description cannot exceed 255 characters.',
                'location_lost.required' => 'Please select a valid location.',
                'location_lost.exists' => 'The selected location does not exist.',
                'location_detail.string' => 'The location detail must be a valid string.',
                'location_detail.max' => 'The location detail cannot exceed 255 characters.',
            ]);

            // update image jika ada
            if ($request->hasFile('image')) {
                $imagePath = $this->uploadImage($request, $report2);
            }

            // dd($request->description,$request->location_lost, $request->location_detail, $request->time_lost);
            // dari database
            $data->update([
                'description' => $validatedData['description'],
                'location_id' => $validatedData['location_lost'],
                'location_lost' => $validatedData['location_detail'],
                'image' => $imagePath ?? $report2->image,
            ]);

            Session::flash('title', 'Changes Saved Successfully!');
            Session::flash('message', '');
            Session::flash('icon', 'success');
            return redirect()->route('myreport.showReports');
    }

    // untuk update report status sudah ketemu/belum
    public function foundReport($id){
        try{
            DB::beginTransaction();
            // dd($id);
            $report = Report::where("id",$id)->update([
                "report_status_id"=>1,
            ]);
            DB::commit();
            Session::flash('title', 'Status Changed Successfully!');
            Session::flash('message', '');
            Session::flash('icon', 'success');

            return redirect()->route('myreport.showReports');
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
        try {
            DB::beginTransaction();

            $report->delete();

            DB::commit();

            Session::flash('title', 'Report Deleted Successfully!');
            Session::flash('message', '');
            Session::flash('icon', 'success');

            return redirect()->route('myreport.showReports');
        } catch(Exception $e) {
            DB::rollBack();
            Log::error($e->getTraceAsString());
            return redirect()->route('myreport.showReports')->with('error', $e->getMessage());
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage(), $th->getTrace());
            return redirect()->route('myreport.showReports')->with('error', $th->getMessage());
        }
    }

    // upload gambar
    private function uploadImage(Request $request, Report $report = null)
    {
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                if ($report && $report->image && file_exists(public_path($report->image))) {
                    unlink(public_path($report->image));
                }

                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('images'), $fileName);

                DB::commit();

                return 'images/' . $fileName;
            }

            DB::commit();
            return $report ? $report->image : null;
        } catch(Exception $e) {
            DB::rollBack();
            Log::error($e->getTraceAsString());
            throw $e;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage(), $th->getTrace());
            throw $th;
        }
    }
}