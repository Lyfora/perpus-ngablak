<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserNewsController extends Controller
{
    public function viewNews($id)
    {
        try {
            $news = News::where('id', $id)->first();
            $news->getFile();
            if (!$news) {
                return redirect('/')->with('failed', 'Berita Tidak Ada');
            } else {
                return view('User.News', ['news' => $news]);
            }
        } catch (\Exception $e) {
            return redirect('/')->with('failed', 'Berita Tidak Ada');
        }
    }

    public function listNews(Request $request)
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
            $limit = $request->limit ? $request->limit : 3;
            $sort_by = $request->sort_by ? $request->sort_by : 'created_at';
            $sort = $request->sort ? $request->sort : 'desc';
            $status_code = "published";
            $news = News::where(function ($query) use ($request, $sort_by, $sort, $limit, $page, $status_code) {
                if ($request->search) {
                    $query->where('slug', 'like', '%' . $request->search . '%')
                        ->orWhere('title', 'like', '%' . $request->search . '%');
                }
                if ($request->start_created_at && $request->end_created_at) {
                    $start_created_at = date('Y-m-d', strtotime($request->end_created_at));
                    $end_created_at = date('Y-m-d', strtotime($request->end_created_at));
                    $query->whereBetween('created_at', [$start_created_at, $end_created_at]);
                }
            })->where('status_code', $status_code)
                ->orderBy($sort_by, $sort)
                ->paginate($limit);

            $news->getCollection()->each(function ($item) {
                $item->getFile();
            });
            return view('User.Berita', ['news' => $news]);
        } catch (\Exception $e) {
            return redirect('/')->with('failed', 'Berita Tidak Ada');
        }
    }
}
