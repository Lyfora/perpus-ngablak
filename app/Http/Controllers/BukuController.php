<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Pengarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    public function viewList(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'search' => 'nullable|string',
                'end_date' => 'nullable|required_with:start_date|date',
                'page' => 'nullable|numeric',
                'limit' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                $notification = [
                    'type' => 'error',
                    'message' => $validator->errors()->first(),
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }
            $page = $request->page ? $request->page : 1;
            $limit = $request->limit ? $request->limit : 10;
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
            })
                ->orderBy($sort_by, $sort)
                ->paginate($limit);

            $buku->getCollection()->each(function ($item) {
                $item->getFile();
            });
            // dd($buku);
            return view('Admin.Buku.Index', ['buku' => $buku]);
        } catch (\Exception $e) {
            $notification = [
                'type' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }
    public function viewCreate(Request $request)
    {
        try {
            $kategori = Kategori::all();
            $pengarang = Pengarang::all();
            return view('Admin.Buku.Create.Index', ['kategori' => $kategori, 'pengarang' => $pengarang]);
        } catch (\Exception $e) {
            $notification = [
                'type' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }
    public function actionCreate(Request $request)
    {
        DB::beginTransaction();
        try {
            $model = new Buku();
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'slug' => 'required|string|unique:bukus,slug',
                'penerbit' => 'required',
                'kategori' => 'required',
                'pengarang' => 'required',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                'tahun_buku' => 'required'
            ]);

            $attributeNames = [
                'title' => 'Judul',
                'penerbit' => 'Penerbit',
                'slug' => 'Slug',
                'kategori' => 'Kategori',
                'pengarang' => 'Pengarang',
                'thumbnail' => 'Thumbnail',
                'tahun_buku' => 'Tahun Buku'
            ];
            $validator->setAttributeNames($attributeNames);

            if ($validator->fails()) {
                $notification = [
                    'type' => 'error',
                    'message' => $validator->errors()->first(),
                ];
                return redirect()->back()->with(['notification' => $notification])->withInput();
            }
            $model->processUpload($request);

            $model->title = $request->title;
            $model->slug = $request->slug;
            $model->volume = $request->volume;
            $model->penerbit = $request->penerbit;
            $model->kategori = $request->kategori;
            $model->pengarang = $request->pengarang;
            $model->thumbnail = $request->thumbnail;
            $model->tahun_buku = $request->tahun_buku;
            $model->lokasi = $request->lokasi;
            $model->save();
            DB::commit();
            $notification = [
                'type' => 'success',
                'message' => 'Buku berhasil ditambahkan',
            ];
            // redirect to list
            return redirect()->route('buku.list')->with(['notification' => $notification]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $notification = [
                'type' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }

    public function viewEdit($id)
    {
        try {
            $kategori = Kategori::all();
            $pengarang = Pengarang::all();
            $buku = Buku::find($id)->getFile();
            return view('Admin.Buku.Edit.Index', ['buku' => $buku, 'kategori' => $kategori, 'pengarang' => $pengarang, 'id' => $id]);
        } catch (\Exception $e) {
            $notification = [
                'type' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }
    public function actionEdit(Request $request)
    {
        $notification = [
            'type' => 'error',
            'message' => 'Tidak ada data Diubah'
        ];
        DB::beginTransaction();
        try {
            $model = Buku::find($request->id);
            $fieldsToCompare = ['title', 'volume', 'penerbit', 'kategori', 'pengarang', 'lokasi', 'tahun_buku'];

            // Check if any field has changed
            $dataChanged = false;

            foreach ($fieldsToCompare as $field) {
                if ($request->input($field) != $model->$field) {
                    $dataChanged = true;
                    break;
                }
            }
            if ($dataChanged) {
                $validator = Validator::make($request->all(), [
                    'title' => 'required|string',
                    'penerbit' => 'required',
                    'kategori' => 'required',
                    'pengarang' => 'required',
                    'tahun_buku' => 'required'
                ]);
                if ($validator->fails()) {
                    $notification = [
                        'type' => 'error',
                        'message' => $validator->errors()->first(),
                    ];
                    return redirect()->back()->with(['notification' => $notification]);
                }
                $model->processUpload($request);
                $data = [
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'volume' => $request->volume,
                    'penerbit' => $request->penerbit,
                    'kategori' => $request->kategori,
                    'pengarang' => $request->pengarang,
                    'tahun_buku' => $request->tahun_buku,
                    'lokasi' => $request->lokasi,
                    'thumbnail' => isset($request->thumbnail) ? $request->thumbnail : $model->thumbnail,
                ];
                $model->update($data);
                DB::commit();
                $notification = [
                    'type' => 'success',
                    'message' => 'Buku berhasil diubah',
                ];
            }
            return redirect()->route('buku.list')->with(['notification' => $notification]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $notification = [
                'type' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }
    public function actionDelete($id)
    {
        try {
            $model = Buku::find($id);
            if (!$model) {
                $notification = [
                    'type' => 'error',
                    'message' => 'Buku tidak ditemukan',
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }

            $model->delete();
            $notification = [
                'type' => 'success',
                'message' => 'Buku berhasil dihapus',
            ];
            return redirect()->back()->with(['notification' => $notification]);
        } catch (\Exception $e) {
            $notification = [
                'type' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }

    public function viewListPinjam(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'search' => 'nullable|string',
                'end_date' => 'nullable|required_with:start_date|date',
                'page' => 'nullable|numeric',
                'limit' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                $notification = [
                    'type' => 'error',
                    'message' => $validator->errors()->first(),
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }
            $page = $request->page ? $request->page : 1;
            $limit = $request->limit ? $request->limit : 10;
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
            })
                ->orderBy($sort_by, $sort)
                ->paginate($limit);

            $buku->getCollection()->each(function ($item) {
                $item->getFile();
            });
            // dd($buku);
            return view('Admin.Buku.IndexPinjam', ['buku' => $buku]);
        } catch (\Exception $e) {
            $notification = [
                'type' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }
    public function viewPinjam($id)
    {
        try {
            $buku = Buku::find($id)->getFile();
            $kategori = Kategori::find($buku->kategori);
            $pengarang = Pengarang::find($buku->pengarang);
            return view('Admin.Buku.Pinjam.Index', ['buku' => $buku, 'kategori' => $kategori, 'pengarang' => $pengarang, 'id' => $id]);
        } catch (\Exception $e) {
            $notification = [
                'type' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }
    public function actionPinjam(Request $request)
    {
        DB::beginTransaction();
        try {
            $model = Buku::find($request->id);
            $validator = Validator::make($request->all(), [
                'nama_peminjam' => 'required|string',
            ]);
            if ($validator->fails()) {
                $notification = [
                    'type' => 'error',
                    'message' => $validator->errors()->first(),
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }
            $data = [
                'nama_peminjam' => $request->nama_peminjam,
                'status_code' => 'dipinjam'
            ];
            $model->update($data);
            DB::commit();
            $notification = [
                'type' => 'success',
                'message' => 'Buku berhasil dipinjam',
            ];
            return redirect()->route('pinjam.list')->with(['notification' => $notification]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $notification = [
                'type' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }
    public function actionKembali($id)
    {
        DB::beginTransaction();
        try {
            $model = Buku::find($id);
            $data = [
                'nama_peminjam' => '',
                'status_code' => 'tersedia'
            ];
            $model->update($data);
            DB::commit();
            $notification = [
                'type' => 'success',
                'message' => 'Buku berhasil dikembalikan',
            ];
            return redirect()->route('pinjam.list')->with(['notification' => $notification]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $notification = [
                'type' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }
}
