<?php

namespace App\Http\Controllers;

use App\Models\NewsAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NewsAttachmentsControllers extends Controller
{
    //
    public function actionCreate(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!request()->hasValidSignature()) {
                abort(401);
            }

            $model = new NewsAttachment();

            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            ]);

            $attributeNames = [
                'image' => 'Gambar',
            ];

            $validator->setAttributeNames($attributeNames);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 422);
            }
            $model->processUpload($request);

            $model->image = $request->image;
            $model->save();

            $model->getFile();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Gambar Berhasil Diupload',
                'data' => $model,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ], 500);
        }
    }
}
