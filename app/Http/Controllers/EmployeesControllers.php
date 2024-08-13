<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class EmployeesControllers extends Controller
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
            $employees = Employee::where(function ($query) use ($request, $sort_by, $sort, $limit, $page) {
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

            // dd($employee);

            return view('Admin.Employees.Index', ['employees' => $employees]);
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
            return view('Admin.Employees.Create.Index');
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
            $model = new Employee();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
            ]);

            $attributeNames = [
                'name' => 'Nama',
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
            $model->save();

            DB::commit();
            $notification = [
                'type' => 'success',
                'message' => 'PIC berhasil ditambahkan',
            ];
            // redirect to list
            return redirect()->route('employees.list')->with(['notification' => $notification]);
        } catch (\Exception $e) {
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
            $employee = Employee::find($id);
            return view('Admin.Employees.Edit.Index', ['employee' => $employee]);
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
            $model = Employee::find($request->id);
            $validator = Validator::make($request->all(), [
                'id' => 'required|numeric',
                'name' => 'required|string',
            ]);

            $attributeNames = [
                'name' => 'Nama',
            ];

            $validator->setAttributeNames($attributeNames);

            if ($validator->fails()) {
                $notification = [
                    'type' => 'error',
                    'message' => $validator->errors()->first(),
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }

            $data = [
                'name' => $request->name,
            ];
            $model->update($data);

            DB::commit();
            $notification = [
                'type' => 'success',
                'message' => 'PIC berhasil diubah',
            ];
            return redirect()->route('employees.list')->with(['notification' => $notification]);
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
            $model = Employee::find($id);
            if (!$model) {
                $notification = [
                    'type' => 'error',
                    'message' => 'PIC tidak ditemukan',
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }

            $model->delete();
            $notification = [
                'type' => 'success',
                'message' => 'PIC berhasil dihapus',
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
            $employee = Employee::find($id);
            return view('Admin.Employees.Detail.Index', ['employee' => $employee]);
        } catch (\Exception $e) {
            $notification = [
                'type' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }
}
