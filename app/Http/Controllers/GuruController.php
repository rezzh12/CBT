<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;

use App\Models\User;
use App\Models\Aktifitas;
use Yajra\Datatables\Datatables;


class GuruController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
  
    public function index()
    {
      if (auth()->user()->status == 'G' || auth()->user()->status == 'A') {
        $user = User::where('id', auth()->user()->id)->first();
        return view('guru.index', compact('user'));
      } else {
        return redirect()->route('home.index');
      }
    }
  
    public function dataGuru()
    {
      $gurus = User::where('status', 'G');
      return Datatables::of($gurus)
        ->addColumn('empty_str', function () {
          return '';
        })
        ->editColumn('jk', function ($gurus) {
          if ($gurus->jk == 'L') {
            return "Laki-laki";
          } else {
            return "Perempuan";
          }
        })
        ->addColumn('action', function ($gurus) {
          if (auth()->user()->status == 'G') {
            return '<div style="text-align:center"><a href="guru/detail/' . $gurus->id . '" class="btn btn-xs btn-success">Detail</a></div>';
          } else {
            return '<div style="text-align:center">
                                <a href="guru/ubah/' . $gurus->id . '" class="btn btn-xs btn-primary">Ubah</a>
                                <button type="button" class="btn btn-xs btn-danger del-guru" id=' . $gurus->id . '>Hapus</button>
                                <a href="guru/detail/' . $gurus->id . '" class="btn btn-xs btn-success">Detail</a></div>';
          }
        })
        ->make(true);
    }
  
    public function detailGuru(Request $request)
    {
      $tanggal = date('d-m-Y');
      if (auth()->user()->status == 'G' or auth()->user()->status == 'A') {
        $user = User::where('id', auth()->user()->id)->first();
        $guru = User::where('id', $request->id)->first();
        $grup_aktifitas = Aktifitas::where('id_user', $request->id)->whereDate('created_at', DB::raw('CURDATE()'))->paginate(5);
        return view('guru.detail', compact('user', 'guru', 'grup_aktifitas', 'tanggal'));
      } else {
        return redirect()->route('home.index');
      }
    }
  
    public function simpanGuru(Request $request)
    {
      $save = new User;
      return $save->simpanGuru($request);
    }
  
    public function ubahGuru(Request $request)
    {
      if (auth()->user()->status == 'G' or auth()->user()->status == 'A') {
        $user = User::where('id', auth()->user()->id)->first();
        $guru = User::where('id', $request->id)->first();
        return view('guru.form.ubah', compact('user', 'guru'));
      } else {
        return redirect()->route('home.index');
      }
    }
  }
  
