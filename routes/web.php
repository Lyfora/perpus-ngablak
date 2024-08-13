<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentDocumentationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\NewsControllers;
use App\Http\Controllers\DashboardControllers;
use App\Http\Controllers\NewsAttachmentsControllers;
use App\Http\Controllers\UsersControllers;
use App\Http\Controllers\EmployeesControllers;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengarangController;
use App\Http\Controllers\UserAppointmentController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserDocumentantionsController;
use App\Http\Controllers\UserKategori;
use App\Http\Controllers\UserNewsController;
use App\Http\Controllers\UserReviewController;
use App\Http\Controllers\UserSearch;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [UserDashboardController::class, 'viewDashboard']);

Route::get('/test', function () {
    return view('Admin.Dashboard.Index');
});
Route::get('/berita', [UserNewsController::class, 'listNews'])->name('listNews');
Route::get('/berita/{id}', [UserNewsController::class, 'viewNews']);

Route::get('/caribuku', [UserSearch::class, 'searchBuku'])->name('user.search');
Route::get('/detailbuku/{slug}', [UserSearch::class, 'viewBuku'])->name('user.searchbuku');

Route::get('/kategori/{kategori}', [UserKategori::class, 'viewKategori'])->name('user.kategori');

Route::group(['prefix' => "admin", "middleware" => "auth"], function () {
    Route::get('/dashboard', [DashboardControllers::class, 'viewDashboard'])->name('dashboard');
    Route::group(['prefix' => "news"], function () {
        Route::get('/', [NewsControllers::class, 'viewList'])->name('news.list');
        Route::get('/create', [NewsControllers::class, 'viewCreate'])->name('news.create');
        Route::post('/create', [NewsControllers::class, 'actionCreate'])->name('news.action-create');
        Route::get('/edit/{id}', [NewsControllers::class, 'viewEdit'])->name('news.edit');
        Route::put('/edit', [NewsControllers::class, 'actionEdit'])->name('news.action-edit');
        Route::delete('/delete/{id}', [NewsControllers::class, 'actionDelete'])->name('news.delete');
        Route::put('/publish', [NewsControllers::class, 'actionPublish'])->name('news.publish');
        Route::put('/archive', [NewsControllers::class, 'actionArchive'])->name('news.archive');
        Route::get('/detail/{id}', [NewsControllers::class, 'viewDetail'])->name('news.detail');
    });
    Route::group(['prefix' => "users"], function () {
        Route::get('/', [UsersControllers::class, 'viewList'])->name('users.list');
        Route::get('/create', [UsersControllers::class, 'viewCreate'])->name('users.create');
        Route::post('/create', [UsersControllers::class, 'actionCreate'])->name('users.action-create');
        Route::get('/edit/{id}', [UsersControllers::class, 'viewEdit'])->name('users.edit');
        Route::put('/edit', [UsersControllers::class, 'actionEdit'])->name('users.action-edit');
        Route::delete('/delete/{id}', [UsersControllers::class, 'actionDelete'])->name('users.delete');
        Route::get('/detail/{id}', [UsersControllers::class, 'viewDetail'])->name('users.detail');
    });
    Route::group(['prefix' => "pengarang"], function () {
        Route::get('/', [PengarangController::class, 'viewList'])->name('pengarang.list');
        Route::get('/create', [PengarangController::class, 'viewCreate'])->name('pengarang.create');
        Route::post('/create', [PengarangController::class, 'actionCreate'])->name('pengarang.action-create');
        Route::get('/edit/{id}', [PengarangController::class, 'viewEdit'])->name('pengarang.edit');
        Route::put('/edit', [PengarangController::class, 'actionEdit'])->name('pengarang.action-edit');
        Route::delete('/delete/{id}', [PengarangController::class, 'actionDelete'])->name('pengarang.delete');
        Route::get('/detail/{id}', [PengarangController::class, 'viewDetail'])->name('pengarang.detail');
    });
    Route::group(['prefix' => "kategori"], function () {
        Route::get('/', [KategoriController::class, 'viewList'])->name('kategori.list');
        Route::get('/create', [KategoriController::class, 'viewCreate'])->name('kategori.create');
        Route::post('/create', [KategoriController::class, 'actionCreate'])->name('kategori.action-create');
        Route::get('/edit/{id}', [KategoriController::class, 'viewEdit'])->name('kategori.edit');
        Route::put('/edit', [KategoriController::class, 'actionEdit'])->name('kategori.action-edit');
        Route::delete('/delete/{id}', [KategoriController::class, 'actionDelete'])->name('kategori.delete');
        Route::get('/detail/{id}', [KategoriController::class, 'viewDetail'])->name('kategori.detail');
    });
    Route::group(['prefix' => "buku"], function () {
        Route::get('/', [BukuController::class, 'viewList'])->name('buku.list');
        Route::get('/create', [BukuController::class, 'viewCreate'])->name('buku.create');
        Route::post('/create', [BukuController::class, 'actionCreate'])->name('buku.action-create');
        Route::get('/edit/{id}', [BukuController::class, 'viewEdit'])->name('buku.edit');
        Route::put('/edit', [BukuController::class, 'actionEdit'])->name('buku.action-edit');
        Route::delete('/delete/{id}', [BukuController::class, 'actionDelete'])->name('buku.delete');
        Route::get('/detail/{id}', [BukuController::class, 'viewDetail'])->name('buku.detail');
    });
    Route::group(['prefix' => "pinjam"], function () {
        Route::get('/', [BukuController::class, 'viewListPinjam'])->name('pinjam.list');
        Route::get('/pinjam/{id}', [BukuController::class, 'viewPinjam'])->name('buku.pinjam');
        Route::put('/aksiPinjam', [BukuController::class, 'actionPinjam'])->name('buku.action-pinjam');
        Route::put('/aksiKembali/{id}', [BukuController::class, 'actionKembali'])->name('buku.selesai');
    });
});

Route::get('admin/signin', [AuthController::class, 'viewSignIn'])->name('admin.signin');
Route::get('admin/forgot-password', [AuthController::class, 'viewForgotPassword'])->name('forgot-password');
Route::get('admin/reset-password/{token}', [AuthController::class, 'viewResetPassword'])->name('reset-password');
Route::post('admin/reset-password', [AuthController::class, 'actionResetPassword'])->name('action-reset-password');
Route::post('admin/forgot-password', [AuthController::class, 'actionForgotPassword'])->name('action-forgot-password');
Route::post('admin/change-password', [AuthController::class, 'actionChangePassword'])->name('action-change-password');
Route::post('signin', [AuthController::class, 'actionLogin'])->name('signin');
Route::get('signout', [AuthController::class, 'actionLogout'])->name('signout');


Route::post('/appointment-documentation/create', [AppointmentDocumentationController::class, 'actionCreate'])->name('appointment-documentation.create');
Route::post('/appointment/create', [AppointmentController::class, 'actionCreate']);
