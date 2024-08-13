<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class NewsControllers extends Controller
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
            $news = News::where(function ($query) use ($request, $sort_by, $sort, $limit, $page) {
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

            $news->getCollection()->each(function ($item) {
                $item->getFile();
            });

            // dd($news);

            return view('Admin.News.Index', ['news' => $news]);
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
            return view('Admin.News.Create.Index', ['upload_url' => $upload_url]);
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
            $model = new News();
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                'slug' => 'required|string|unique:news,slug',
                'content' => 'required|string',
            ]);

            $attributeNames = [
                'title' => 'Judul',
                'thumbnail' => 'Thumbnail',
                'slug' => 'Slug',
                'content' => 'Konten',
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
            $model->thumbnail = $request->thumbnail;
            $model->slug = $request->slug;
            $model->content = $request->content;
            $model->save();

            // get konten DOM
            $dom = new \DOMDocument();
            $dom->loadHTML($request->content);
            $images = $dom->getElementsByTagName('img');
            foreach ($images as $k => $img) {
                $src = $img->getAttribute('src');
                // get full url image
                $url = '/api/file/';
                $img_src = str_replace($url, '', $src);
                // dd($img_src, $url, $src);
                // change %20 to space
                $img_src = str_replace('%20', ' ', $img_src);
                // // find to news_attachments table
                $news_attachment = NewsAttachment::where('image', $img_src)->first();
                if ($news_attachment) {
                    $news_attachment_data = [
                        'news_id' => $model->id,
                        'image' => $img_src,
                    ];
                    DB::table('news_attachments')->where('id', $news_attachment->id)->update($news_attachment_data);
                }
            }
            DB::commit();
            $notification = [
                'type' => 'success',
                'message' => 'Berita berhasil ditambahkan',
            ];
            // redirect to list
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

    public function viewEdit($id)
    {
        try {
            $news = News::find($id)->getFile();
            $upload_url = URL::temporarySignedRoute('news-attachments.create', now()->addMinutes(15));
            return view('Admin.News.Edit.Index', ['news' => $news, 'upload_url' => $upload_url]);
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
            $model = News::find($request->id);
            $validator = Validator::make($request->all(), [
                'id' => 'required|numeric',
                'title' => 'required|string',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
                'slug' => 'required|string|unique:news,slug,' . $request->id . ',id',
                'content' => 'required|string',
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
                'thumbnail' => isset($request->thumbnail) ? $request->thumbnail : $model->thumbnail,
                'slug' => $request->slug,
                'content' => $request->content,
            ];
            $model->update($data);

            // update news_attachment where news_id = id
            NewsAttachment::where('news_id', $model->id)->update(['news_id' => null]);
            // get konten DOM
            $dom = new \DOMDocument();
            $dom->loadHTML($request->content);
            $images = $dom->getElementsByTagName('img');
            foreach ($images as $k => $img) {
                $src = $img->getAttribute('src');
                // get full url image
                $url = '/api/file/';
                $img_src = str_replace($url, '', $src);
                // dd($img_src, $url, $src);
                // change %20 to space
                $img_src = str_replace('%20', ' ', $img_src);
                // // find to news_attachments table
                $news_attachment = NewsAttachment::where('image', $img_src)->first();
                if ($news_attachment) {
                    $news_attachment_data = [
                        'news_id' => $model->id,
                        'image' => $img_src,
                    ];
                    DB::table('news_attachments')->where('id', $news_attachment->id)->update($news_attachment_data);
                }
            }
            DB::commit();
            $notification = [
                'type' => 'success',
                'message' => 'Berita berhasil diubah',
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
            $model = News::find($id);
            if (!$model) {
                $notification = [
                    'type' => 'error',
                    'message' => 'Berita tidak ditemukan',
                ];
                return redirect()->back()->with(['notification' => $notification]);
            }

            $news_attachments = NewsAttachment::where('news_id', $model->id)->get();
            foreach ($news_attachments as $news_attachment) {
                $news_attachment->deleteFile();
                $news_attachment->delete();
            }
            $model->delete();
            $notification = [
                'type' => 'success',
                'message' => 'Berita berhasil dihapus',
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

    public function actionPublish(Request $request)
    {
        try {
            $model = News::find($request->id);
            $model->status_code = 'published';
            $model->published_at = now();
            $model->save();
            $notification = [
                'type' => 'success',
                'message' => 'Berita berhasil dipublish',
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
    public function actionArchive(Request $request)
    {
        DB::beginTransaction();
        try {
            $model = News::find($request->id);
            $model->status_code = 'archived';
            $model->archived_at = now();
            $model->save();
            DB::commit();
            $notification = [
                'type' => 'success',
                'message' => 'Berita berhasil diarsipkan',
            ];
            return redirect()->back()->with(['notification' => $notification]);
        } catch (\Exception $e) {
            DB::rollBack();
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
            $news = News::find($id)->getFile();
            return view('Admin.News.Detail.Index', ['news' => $news]);
        } catch (\Exception $e) {
            $notification = [
                'type' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }
}
