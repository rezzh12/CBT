<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


// reute group for crud
Route::group(['prefix' => 'crud'], function () {
    Route::post('simpan-soal', [App\Http\Controllers\SoalController::class, 'simpanSoal'])->name('simpanSoal');
    Route::post('simpan-detail-soal', [App\Http\Controllers\SoalController::class, 'simpanDetailSoal'])->name('simpanDetailSoal');
    Route::post('simpan-detail-soal-via-excel', [App\Http\Controllers\SoalController::class, 'simpanDetailSoalExcel'])->name('simpanDetailSoalExcel');
    Route::post('update-profil', [App\Http\Controllers\CrudController::class, 'updateProfil'])->name('UpdateProfile');
    Route::post('simpan-materi', [App\Http\Controllers\CrudController::class, 'simpanMateri'])->name('simpanMateri');
    Route::post('terbit-soal', [App\Http\Controllers\CrudController::class, 'terbitSoal'])->name('terbitSoal');
    Route::post('simpan-gambar-materi', [App\Http\Controllers\CrudController::class, 'simpanGambarMateri'])->name('simpanGambarMateri');
    Route::post('hapus-gambar-materi', [App\Http\Controllers\CrudController::class, 'hapusGambarMateri'])->name('hapusGambarMateri');
    Route::post('simpan-gambar-user', [App\Http\Controllers\CrudController::class, 'simpanGambarUser'])->name('simpanGambarUser');
    Route::post('update-profile-sekolah', [App\Http\Controllers\CrudController::class, 'updateProfileSekolah'])->name('updateProfileSekolah');
    Route::post('simpan-siswa', [App\Http\Controllers\CrudController::class, 'simpanSiswa'])->name('simpanSiswa');
    Route::post('simpan-siswa-via-excel', [App\Http\Controllers\CrudController::class, 'simpanSiswaViaExcel'])->name('simpanSiswaViaExcel');
    Route::post('update-siswa', [App\Http\Controllers\CrudController::class, 'updateSiswa'])->name('updateSiswa');
    Route::post('delete-siswa', [App\Http\Controllers\CrudController::class, 'deleteSiswa'])->name('deleteSiswa');
    Route::post('update-img-siswa', [App\Http\Controllers\CrudController::class, 'updateImgSiswa'])->name('updateImgSiswa');
    Route::post('simpan-guru', [App\Http\Controllers\CrudController::class, 'simpanGuru'])->name('simpanGuru');
    Route::post('update-guru', [App\Http\Controllers\CrudController::class, 'updateGuru'])->name('updateGuru');
    Route::post('delete-guru', [App\Http\Controllers\CrudController::class, 'deleteGuru'])->name('deleteGuru');
    Route::post('simpan-kelas', [App\Http\Controllers\CrudController::class, 'simpanKelas'])->name('simpanKelas');
    Route::post('delete-kelas', [App\Http\Controllers\CrudController::class, 'deleteKelas'])->name('deleteKelas');
    Route::post('reset-ujian', [App\Http\Controllers\CrudController::class, 'resetUjian'])->name('resetUjian');
    Route::post('simpan-distribusi', [App\Http\Controllers\CrudController::class, 'simpanDistribusi'])->name('simpanDistribusi');


});

Route::group(['prefix' => 'pengaturan'], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'pengaturan'])->name('pengaturan');
});
Route::group(['prefix' => 'distribusi'], function () {
    Route::get('/', [App\Http\Controllers\DistribusiController::class, 'index'])->name('distribusi');
    Route::get('data-distribusi', [App\Http\Controllers\DistribusiController::class, 'dataDistribusi'])->name('distribusi.data_distribusi');
    Route::get('/ubah/{id}', [App\Http\Controllers\DistribusiController::class, 'ubahDistribusi'])->name('master.ubah_distribusi');
    Route::get('/hapus/{id}', [App\Http\Controllers\CrudController::class, 'deleteDistribusi'])->name('hapusDistribusi');


});

Route::group(['prefix' => 'master'], function () {
	// route master guru
	Route::group(['prefix' => 'guru'], function () {
        Route::get('/', [App\Http\Controllers\GuruController::class, 'index'])->name('master.guru');
        Route::get('data-guru', [App\Http\Controllers\GuruController::class, 'dataGuru'])->name('master.data_guru');
        Route::get('detail/{id}', [App\Http\Controllers\GuruController::class, 'detailGuru'])->name('master.detailGuru');
        Route::get('ubah/{id}', [App\Http\Controllers\GuruController::class, 'ubahGuru'])->name('master.ubahGuru');

	});
	Route::group(['prefix' => 'kelas'], function () {
        Route::get('/', [App\Http\Controllers\KelasController::class, 'index'])->name('master.kelas');
        Route::get('data-kelas', [App\Http\Controllers\KelasController::class, 'dataKelas'])->name('master.data_kelas');
        Route::get('/detail/{id}', [App\Http\Controllers\KelasController::class, 'detailKelas'])->name('master.detail_kelas');
        Route::get('detail-kelas/', [App\Http\Controllers\KelasController::class, 'detailKelasSiswa'])->name('master.detail_kelas_siswa');
        Route::get('/ubah/{id}', [App\Http\Controllers\KelasController::class, 'ubahKelas'])->name('master.ubah_kelas');

	});
	// route master kelas
	// route master siswa
	Route::group(['prefix' => 'siswa'], function () {
        Route::get('/', [App\Http\Controllers\SiswaController::class, 'index'])->name('master.siswa');
        Route::get('data-siswa', [App\Http\Controllers\SiswaController::class, 'dataSiswa'])->name('master.data_siswa');
        Route::get('detail/{id}', [App\Http\Controllers\SiswaController::class, 'detailSiswa'])->name('master.detail_siswa');
        Route::get('delete-all', [App\Http\Controllers\SiswaController::class, 'deleteAll'])->name('master.deleteAll');
        Route::get('delete', [App\Http\Controllers\SiswaController::class, 'delete'])->name('master.editSiswa');
        Route::get('edit/{id}', [App\Http\Controllers\SiswaController::class, 'editSiswa'])->name('master.delete');
        Route::get('get-btn-delete/{password}', [App\Http\Controllers\SiswaController::class, 'getBtnDelete'])->name('master.getBtnDelete');

	});
});

Route::group(['prefix' => 'elearning'], function () {
	Route::group(['prefix' => 'materi'], function () {
        Route::get('/', [App\Http\Controllers\MateriController::class, 'index'])->name('elearning.materi');
        Route::get('/get-materi-guru', [App\Http\Controllers\MateriController::class, 'dataMateriGuru'])->name('elearning.dataMateriGuru');
        Route::get('/detail/{id}', [App\Http\Controllers\MateriController::class, 'detail'])->name('elearning.detailMateri');
        Route::get('/ubah/{id}', [App\Http\Controllers\MateriController::class, 'ubah'])->name('elearning.detailMateri');
	});
	Route::group(['prefix' => 'laporan'], function () {
        Route::get('/', [App\Http\Controllers\LaporanController::class, 'index'])->name('elearning.laporan');
        Route::get('/detail-kelas/{id}', [App\Http\Controllers\LaporanController::class, 'detailKelas'])->name('elearning.detailKelas');
        Route::get('/detail-paket-soal', [App\Http\Controllers\LaporanController::class, 'data_paket_soal'])->name('elearning.laporan.data_paket_soal');
        Route::get('detail-kelas/{id_kelas}/paket-soal/{id_soal}', [App\Http\Controllers\LaporanController::class, 'detailPaketSoalPerkelas'])->name('elearning.laporan.detailPaketSoalPerkelas');
        Route::get('data-kelas-paket-soal', [App\Http\Controllers\LaporanController::class, 'dataKelasPaketSoal'])->name('elearning.laporan.data_kelas_paket_soal');
        Route::get('{id_soal}/{id_user}', [App\Http\Controllers\LaporanController::class, 'detailLaporanSiswa'])->name('elearning.laporan.detailLaporanSiswa');
        Route::get('hasil-siswa', [App\Http\Controllers\LaporanController::class, 'hasilSiswa'])->name('elearning.laporan.hasilSiswa');
	});
	Route::group(['prefix' => 'soal'], function () {
        Route::get('/', [App\Http\Controllers\SoalController::class, 'index'])->name('soal');
        Route::get('/ubah/{id}', [App\Http\Controllers\SoalController::class, 'ubahSoal'])->name('soal.ubah');
        Route::get('/detail/{id}', [App\Http\Controllers\SoalController::class, 'detail'])->name('elearning.detail-soal');
        Route::get('/get-soal', [App\Http\Controllers\SoalController::class, 'dataSoal'])->name('elearning.get-soal');
        Route::get('/get-soal-home', [App\Http\Controllers\SoalController::class, 'dataSoalHome'])->name('elearning.get-soal-home');
        Route::get('/get-detail-soal', [App\Http\Controllers\SoalController::class, 'dataDetailSoal'])->name('elearning.get-detail-soal');
        Route::get('/detail/ubah/{id}', [App\Http\Controllers\SoalController::class, 'ubahDetailSoal'])->name('elearning.ubah-detail-soal');
        Route::get('/detail/hapus/{id}', [App\Http\Controllers\SoalController::class, 'hapusDetailSoal'])->name('elearning.hapus-detail-soal');
        Route::get('/detail/data-soal/{id}', [App\Http\Controllers\SoalController::class, 'detailDataSoal'])->name('elearning.detail-data-soal');
        Route::get('/essay/data', [App\Http\Controllers\DetailSoalEssayController::class, 'data'])->name('elearning.soalessay.data');
        Route::get('/essay/simpan-score', [App\Http\Controllers\DetailSoalEssayController::class, 'simpanScore'])->name('simpanScore');
        Route::get('/essay', [App\Http\Controllers\DetailSoalEssayController::class, 'essay'])->name('essay');


	});
});
Route::get('/download-file-format', [App\Http\Controllers\CrudController::class, 'download'])->name('siswa.export');
Route::post('/soal-import', [App\Http\Controllers\CrudController::class, 'import_soal'])->name('siswa.import_soal');
Route::get('/soal-export', [App\Http\Controllers\CrudController::class, 'export_soal'])->name('siswa.export');
Route::get('/download-file-format/{filename}', [App\Http\Controllers\CrudController::class, 'download'])->name('download');


Route::group(['prefix' => 'cetak'], function () {
    Route::get('/kartu-ujian', [App\Http\Controllers\ErrorHandleController::class, 'e404'])->name('kartu_ujian');
    Route::get('/berita-acara', [App\Http\Controllers\ErrorHandleController::class, 'e404'])->name('berita_acara');
    Route::get('/excel/hasil-ujian-perkelas/{soal}/{kelas}', [App\Http\Controllers\LaporanController::class, 'excelHasilUjianPerkelas'])->name('excelHasilUjianPerkelas');
    Route::get('/pdf/hasil-ujian-persiswa/{siswa}/{soal}', [App\Http\Controllers\LaporanController::class, 'pdfHasilUjianPersiswa'])->name('pdfHasilUjianPersiswa');
});
Route::get('/activity', 'HomeController@activity');

Route::group(['prefix' => 'siswa'], function () {
    Route::get('data-materi', [App\Http\Controllers\SiswaController::class, 'dataMateri'])->name('siswa.materi');
    Route::get('materi/detail/{id}', [App\Http\Controllers\SiswaController::class, 'detailMateri'])->name('siswa.detailMateri');
    Route::get('materi', [App\Http\Controllers\SiswaController::class, 'materi'])->name('siswa.Materi');
    Route::get('ujian', [App\Http\Controllers\SiswaController::class, 'ujian'])->name('siswa.ujian');
    Route::get('ujian/get-detail-essay', [App\Http\Controllers\SiswaController::class, 'getDetailEssay'])->name('siswa.getDetailEssay');
    Route::get('ujian/simpan-jawaban-essay', [App\Http\Controllers\SiswaController::class, 'simpanJawabanEssay'])->name('siswa.simpanJawabanEssay');
    Route::get('ujian/detail/{id}', [App\Http\Controllers\SiswaController::class, 'detailUjian'])->name('siswa.detailUjian');
    Route::get('ujian/finish/{id}', [App\Http\Controllers\SiswaController::class, 'finishUjian'])->name('siswa.finishUjian');
    Route::get('ujian/get-soal/{id}', [App\Http\Controllers\SiswaController::class, 'getSoal'])->name('siswa.getSoal');
    Route::get('ujian/jawab', [App\Http\Controllers\SiswaController::class, 'jawab'])->name('siswa.jawab');
    Route::get('ujian/kirim-jawaban', [App\Http\Controllers\SiswaController::class, 'kirimJawaban'])->name('siswa.kirimJawaban');

});