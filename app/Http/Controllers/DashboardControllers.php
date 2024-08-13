<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DashboardControllers extends Controller
{
    //
    public function viewDashboard(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'year' => 'nullable|numeric',
                'start_month' => 'nullable|numeric',
                'end_month' => 'nullable|numeric',
            ]);

            $attributeNames = [
                'year' => 'Tahun',
                'start_month' => 'Bulan Awal',
                'end_month' => 'Bulan Akhir',
            ];

            $validator->setAttributeNames($attributeNames);
            if ($validator->fails()) {
                $notification = [
                    'type' => 'error',
                    'message' => $validator->errors()->first(),
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }

            if (!$request->year) {
                $year = (int)date('Y');
            } else {
                $year = $request->year;
            }
            if (!$request->start_month) {
                $start_month = 0;
            } else {
                $start_month = $request->start_month;
            }
            if (!$request->end_month) {
                $end_month = date('m') - 1;
            } else {
                $end_month = $request->end_month;
            }
            $dashboard = DB::selectOne("SELECT 
                                        COALESCE(SUM(CASE WHEN status_code IN ('tersedia','dipinjam') THEN 1 ELSE 0 END),0) as total_buku,
                                        COALESCE(SUM(CASE WHEN status_code = 'tersedia' THEN 1 ELSE 0 END),0) as total_tersedia,
                                        COALESCE(SUM(CASE WHEN status_code = 'dipinjam' THEN 1 ELSE 0 END),0) as total_dipinjam 
                                        FROM bukus
                                        WHERE EXTRACT(YEAR FROM created_at) = :year AND (EXTRACT(MONTH FROM created_at)-1 BETWEEN :start_month AND :end_month)", ['year' => $year, 'start_month' => $start_month, 'end_month' => $end_month]);
            return view('Admin.Dashboard.Index', ['dashboard' => $dashboard]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
