<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
// use Input;
use Spreadsheet_Excel_Reader;
use Excel;

use App\Models\User;
use App\Models\Soal;
use App\Models\Materi;
use App\Models\Detailsoal;
use App\Models\Kelas;
use App\Models\Aktifitas;
use App\Models\Distribusisoal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;

class DistribusiController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
  
    public function index()
    {
      if (Auth::user()->status == 'G' or Auth::user()->status == 'A') {
        $user = User::where('id', Auth::user()->id)->first();
        $distribusi = Distribusisoal::with('soal')->with('kelas')->get();
        $kelas = Kelas::all();
        $soal = Soal::all();
        return view('distribusi.index', compact('user', 'distribusi','kelas','soal'));
      } else {
        return redirect()->route('home.index');
      }
    }
    public function dataDistribusi()
    {
      $distribusi = Distribusisoal::with('soal')->with('kelas')->get();
      if (Auth::user()->status == 'G') {
        return Datatables::of($distribusi)
          ->addColumn('empty_str', function ($distribusi) {
            return '';
          })
          ->addColumn('action', function ($distribusi) {
            return '<div style="text-align:center"><a href="distribusi/ubah/' . $soals->id . '" class="btn btn-success btn-xs">Ubah</a> <a href="distribusi/hapus/' . $distribusi->id . '" class="btn btn-primary btn-xs">Hapus</a></div>';
        })
          
          ->addColumn('soal', function ($distribusi) {
            if ($distribusi->soal->paket) {
              return '<center>' . $distribusi->soal->paket . '</center>';
            } else {
              return '<center><label class="label label-danger">tidak ada</label></center>';
            }
          })
          ->addColumn('kelas', function ($distribusi) {
            if ($distribusi->kelas->nama) {
              return '<center>' . $distribusi->kelas->nama . '</center>';
            } else {
              return '<center><label class="label label-danger">tidak ada</label></center>';
            }
          })
          ->rawColumns(['action', 'soal', 'kelas'])
          ->make(true);
      } else {
        return Datatables::of($distribusi)
          ->addColumn('empty_str', function ($distribusi) {
            return '';
          })
          ->addColumn('action', function ($distribusi) {
            return '<div style="text-align:center">
                              <a href="distribusi/ubah/' . $distribusi->id . '" class="btn btn-xs btn-primary">Ubah</a>
<a href="distribusi/hapus/' . $distribusi->id . '" class="btn btn-danger btn-xs">Hapus</a>                            </div>';
          })
          ->addColumn('soal', function ($distribusi) {
            if ($distribusi->soal->paket) {
                return '<center>' . $distribusi->soal->paket . '</center>';
              } else {
                return '<center><label class="label label-danger">tidak ada</label></center>';
              }
            })
          ->addColumn('kelas', function ($distribusi) {
            if ($distribusi->kelas->nama) {
              return '<center>' . $distribusi->kelas->nama . '</center>';
            } else {
              return '<center><label class="label label-danger">tidak ada</label></center>';
            }
          })
          ->rawColumns(['action', 'soal', 'kelas'])
          ->make(true);
      }
    }
    public function detailDistribusi(Request $request)
    {
      if (Auth::user()->status == 'G' or Auth::user()->status == 'A') {
        $user = User::where('id', Auth::user()->id)->first();
        $kelas = Kelas::where('id', $request->id)->first();
        $jumlah = User::select('id')->where('status_sekolah', 'Y')->where('id_kelas', $request->id)->count();
        return view('kelas.detail', compact('user', 'kelas', 'jumlah'));
      } else {
        return redirect()->route('home.index');
      }
    }
    public function ubahDistribusi($id)
    {
      if (Auth::user()->status == 'G' or Auth::user()->status == 'A') {
        $user = User::where('id', Auth::user()->id)->first();
        $distribusi = Distribusisoal::where('id',$id)->with('soal')->with('kelas')->get();
        $distribusis = Distribusisoal::where('id',$id)->value('id');
        $kelas = Kelas::all();
        $soal = Soal::all();
        return view('distribusi.form.ubah', compact('user', 'kelas', 'soal','distribusi','distribusis'));
      } else {
        return redirect()->route('home.index');
      }
    }
    public function detailKelasSiswa(Request $request)
    {
      $siswas = User::where('status', 'S')->where('status_sekolah', 'Y')->where('id_kelas', $request->id_kelas)->get();
      return Datatables::of($siswas)
        ->editColumn('jk', function ($siswas) {
          if ($siswas->jk == 'L') {
            return 'Laki-laki';
          } else {
            return 'Perempuan';
          }
        })
        ->addColumn('action', function ($siswas) {
          return '<div style="text-align:center"><a href="../../siswa/detail/' . $siswas->id . '" class="btn btn-xs btn-success">Detail</a></div>';
        })
        ->make(true);
    }
}