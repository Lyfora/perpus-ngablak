<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class UsersControllers extends Controller
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
            $users = User::where(function ($query) use ($request, $sort_by, $sort, $limit, $page) {
                if ($request->search) {
                    $query->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                }
            })
                ->orderBy($sort_by, $sort)
                ->paginate($limit);

            // dd($news);

            return view('Admin.Users.Index', ['users' => $users]);
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
            $upload_url = URL::temporarySignedRoute('news-attachments.create', now()->addMinutes(15));
            return view('Admin.Users.Create.Index', ['upload_url' => $upload_url]);
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
            $model = new User();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            ]);

            $attributeNames = [
                'name' => 'Nama',
                'email' => 'Email',
                'password' => 'Password',
            ];

            $validator->setAttributeNames($attributeNames);

            if ($validator->fails()) {
                $notification = [
                    'type' => 'error',
                    'message' => $validator->errors()->first(),
                ];
                return redirect()->back()->with(['notification' => $notification])->withInput();
            }

            $model->name = $request->name;
            $model->email = $request->email;
            $model->password = bcrypt($request->password);
            $model->save();

            DB::commit();
            $notification = [
                'type' => 'success',
                'message' => 'Pengguna berhasil ditambahkan',
            ];
            // redirect to list
            return redirect()->route('users.list')->with(['notification' => $notification]);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
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
            $users = User::find($id);
            return view('Admin.Users.Edit.Index', ['users' => $users]);
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
            $model = User::find($request->id);
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:users,id',
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $request->id,
                'password' => 'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            ]);

            $attributeNames = [
                'name' => 'Nama',
                'email' => 'Email',
                'password' => 'Password',
            ];

            $validator->setAttributeNames($attributeNames);

            if ($validator->fails()) {
                $notification = [
                    'type' => 'error',
                    'message' => $validator->errors()->first(),
                ];
                return redirect()->back()->with(['notification' => $notification])->withInput();
            }


            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ];

            $model->update($data);
            DB::commit();
            $notification = [
                'type' => 'success',
                'message' => 'Pengguna berhasil diubah',
            ];
            return redirect()->route('news.list')->with(['notification' => $notification]);
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
            $model = User::find($id);
            if (!$model) {
                $notification = [
                    'type' => 'error',
                    'message' => 'Pengguna tidak ditemukan',
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }

            $model->delete();
            $notification = [
                'type' => 'success',
                'message' => 'Pengguna berhasil dihapus',
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
            $user = User::find($id);
            return view('Admin.Users.Detail.Index', ['user' => $user]);
        } catch (\Exception $e) {
            $notification = [
                'type' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }
}
