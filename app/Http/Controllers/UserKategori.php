<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Pengarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserKategori extends Controller
{
    public function viewKategori(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'page' => 'nullable|numeric',
                'limit' => 'nullable|integer',
            ]);
            $kategoriName = $request->route('kategori');
            $page = $request->page ? $request->page : 1;
            $limit = $request->limit ? $request->limit : 16;
            $sort_by = $request->sort_by ? $request->sort_by : 'created_at';
            $sort = $request->sort ? $request->sort : 'desc';
            $kategori = Kategori::where('name', $kategoriName)->first();
            $buku = Buku::where('kategori', $kategori->id)->orderBy($sort_by, $sort)
                ->paginate($limit);
            $buku->getCollection()->each(function ($item) {
                $item->getFile();
                $item->pengarang = Pengarang::find($item->pengarang)->name;
            });
            return view('User.Kategori', ['buku' => $buku, 'kategori' => $kategoriName]);
        } catch (\Exception $e) {
            $notification = [
                'type' => 'error',
                'message' => 'Terjadi Gangguan Server'
            ];
            return redirect()->back()->with(['notification' => $notification]);
        }
    }
}
