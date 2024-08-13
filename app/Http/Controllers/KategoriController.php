<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class KategoriController extends Controller
{
    //
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
            $kategori = Kategori::where(function ($query) use ($request, $sort_by, $sort, $limit, $page) {
                if ($request->search) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                }
                if ($request->start_created_at && $request->end_created_at) {
                    $start_created_at = date('Y-m-d', strtotime($request->end_created_at));
                    $end_created_at = date('Y-m-d', strtotime($request->end_created_at));
                    $query->whereBetween('created_at', [$start_created_at, $end_created_at]);
                }
            })
                ->orderBy($sort_by, $sort)
                ->paginate($limit);

            $kategori->getCollection()->each(function ($item) {
                $item->getFile();
            });

            // dd($kategori);

            return view('Admin.Kategori.Index', ['kategori' => $kategori]);
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
            $upload_url = URL::temporarySignedRoute('kategori.create', now()->addMinutes(15));
            return view('Admin.Kategori.Create.Index', ['upload_url' => $upload_url]);
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
            $model = new Kategori();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            ]);

            $attributeNames = [
                'name' => 'Name',
                'image' => 'Image',
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

            $model->name = $request->name;
            $model->image = $request->image;
            $model->save();

            DB::commit();
            $notification = [
                'type' => 'success',
                'message' => 'Kategori berhasil ditambahkan',
            ];
            // redirect to list
            return redirect()->route('kategori.list')->with(['notification' => $notification]);
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
            $kategori = Kategori::find($id)->getFile();
            $upload_url = URL::temporarySignedRoute('kategori.create', now()->addMinutes(15));
            return view('Admin.Kategori.Edit.Index', ['kategori' => $kategori, 'upload_url' => $upload_url]);
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
        DB::beginTransaction();
        try {
            $model = Kategori::find($request->id);
            $validator = Validator::make($request->all(), [
                'id' => 'required|numeric',
                'name' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
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
                'name' => $request->name,
                'image' => isset($request->image) ? $request->image : $model->image,
            ];
            $model->update($data);
            DB::commit();
            $notification = [
                'type' => 'success',
                'message' => 'Kategori berhasil diubah',
            ];
            return redirect()->route('kategori.list')->with(['notification' => $notification]);
        } catch (\Exception $e) {
            DB::rollBack();
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
            $model = Kategori::find($id);
            if (!$model) {
                $notification = [
                    'type' => 'error',
                    'message' => 'Kategori tidak ditemukan',
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }
            $model->delete();
            $notification = [
                'type' => 'success',
                'message' => 'Kategori berhasil dihapus',
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
    public function viewDetail($id)
    {
        try {
            $kategori = Kategori::find($id)->getFile();
            return view('Admin.Kategori.Detail.Index', ['kategori' => $kategori]);
        } catch (\Exception $e) {
            $notification = [
                'type' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }
}
