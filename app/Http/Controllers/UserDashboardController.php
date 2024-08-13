<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\News;
use App\Models\Pengarang;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function viewDashboard()
    {
        $kategori = Kategori::orderBy('name', 'asc')->get();
        $kategori->each(function ($item) {
            $item->getfile();
        });
        $news = News::where('status_code', 'published')->orderBy('published_at', 'desc')->take(3)->get();
        $news->each(function ($item) {
            $item->getFile();
        });
        $buku = Buku::orderBy('created_at', 'desc')->take(8)->get();
        $buku->each(function ($item) {
            $item->getFile();
            $item->pengarang = Pengarang::find($item->pengarang)->name;
        });
        return view('User.Dashboard', ['news' => $news, 'buku' => $buku, 'kategori' => $kategori]);
    }
}
