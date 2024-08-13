<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Pengarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserSearch extends Controller
{
    public function viewBuku($slug)
    {
        try {
            $buku = Buku::where('slug', $slug)->first();
            $pengarang = Pengarang::where('id', $buku->pengarang)->first();
            $kategori = Kategori::where('id', $buku->kategori)->first();
            $buku->getFile();
            if (!$buku) {
                return redirect('/')->with('failed', 'Buku Tidak Ada');
            } else {
                return view('User.DetailBuku', ['buku' => $buku, 'pengarang' => $pengarang, 'kategori' => $kategori]);
            }
        } catch (\Exception $e) {
            return redirect('/')->with('failed', 'Terjadi Gangguan Server');
        }
    }
    public function searchBuku(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'search' => 'nullable|string',
                'page' => 'nullable|numeric',
                'limit' => 'nullable|integer',
            ]);
            if ($validator->fails()) {
                $notification = [
                    'type' => 'error',
                    'message' => 'Format Pencarian Salah',
                ];
                return redirect('/caribuku')->with('notification', $notification);
            }
            $page = $request->page ? $request->page : 1;
            $limit = $request->limit ? $request->limit : 8;
            $sort_by = $request->sort_by ? $request->sort_by : 'created_at';
            $sort = $request->sort ? $request->sort : 'desc';
            $buku = Buku::where(function ($query) use ($request, $sort_by, $sort, $limit, $page) {
                if ($request->search) {
                    $query->where('slug', 'like', '%' . $request->search . '%')
                        ->orWhere('title', 'like', '%' . $request->search . '%');
                }
                if ($request->status_code) {
                    $query->whereIn('status_code', $request->status_code);
                }
                if ($request->start_created_at && $request->end_created_at) {
                    $start_created_at = date('Y-m-d', strtotime($request->end_created_at));
                    $end_created_at = date('Y-m-d', strtotime($request->end_created_at));
                    $query->whereBetween('created_at', [$start_created_at, $end_created_at]);
                }
            })->orderBy($sort_by, $sort)
                ->paginate($limit);

            $buku->getCollection()->each(function ($item) {
                $item->getFile();
            });
            return view('User.CekKunjungan', ['buku' => $buku]);
        } catch (\Exception $e) {
            $notification = [
                'type' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }
    // public function detailAppointment($code)
    // {
    //     try {
    //         $validator = Validator::make(['code' => $code], [
    //             'code' => 'required|alpha_num|size:6'
    //         ]);
    //         if ($validator->fails()) {
    //             return redirect('/kunjungan')->with('invalid', 'Format kode salah');
    //         } else {
    //             $appointment = Appointment::where('code', $code)->first();
    //             $documentation = AppointmentDocumentation::where('appointment_id', $appointment->id)->get();
    //             $i = 0;
    //             $documentation->each(function ($item) use (&$i) {
    //                 if ($item->uploader == 'user') {
    //                     $i++;
    //                 }
    //                 $item->getFile();
    //             });
    //             $review = Review::where('appointment_id', $appointment->id)->first();
    //             if ($appointment) {
    //                 return view('User.ReviewKunjungan', [
    //                     'appointment' => $appointment,
    //                     'documentation' => $documentation,
    //                     'user_documentation' => $i,
    //                     'review' => $review
    //                 ]);
    //             } else {
    //                 return redirect('/kunjungan')->with('failed', 'Appointment Not found');
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'error'], 400);
    //     };
    // }
}
