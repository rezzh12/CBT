@extends('layouts.app')
@section('title', 'Data Distribusi')
@section('breadcrumb')
  <h1>Distribusi</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Distribusi</li>
  </ol>
@endsection
@section('content')
  <?php include(app_path().'/functions/myconf.php'); ?>
  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title aaaa"><i class="fa fa-address-card" aria-hidden="true"></i> Data Distribusi</h3>
        <div class="pull-right">
          <button type="button" class="btn btn-primary" id="btn-create"><i class="fa fa-edit"></i> Buat Distribusi</button>
        </div>
      </div>
      <div class="box-body">
        <div class="col-sm-12">
          <div class="col-sm-12">
            <form id="form-distribusi" style="display: none; margin: 0 auto 20px;" class="form-horizontal well">
              <div class="form-group">
                <label for="id_soal" class="col-sm-2 control-label">Mata Pelajaran</label>
                <div class="col-sm-10">
                <select class="form-control" name="id_soal" id="id_soal" placeholder="Soal">
                    <option>Pilih Soal</option>
                    @forelse($soal as $soal)
                      <option value="{{$soal->id }}">{{  $soal->paket }}</option>
                    @empty
                    @endforelse
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="id_kelas" class="col-sm-2 control-label">Kelas</label>
                <div class="col-sm-10">
                  <select class="form-control" name="id_kelas" id="id_kelas" placeholder="Kelas">
                    <option>Pilih Kelas</option>
                    @forelse($kelas as $kelas)
                      <option value="{{  $kelas->id }}">{{  $kelas->nama }}</option>
                    @empty
                    @endforelse
                      <input type="hidden" name="id" value="N">
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="save" class="col-sm-2 control-label">&nbsp</label>
                <div class="col-sm-10">
                  <div class="alert alert-danger" id="notif" style="display: none; margin: 0 auto 10px"></div>
                  <button type="button" class="btn btn-primary" id="save">Simpan</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="clearfix"></div>
  	    <table id="tabel_distribusi" class="table table-hover table-condensed">
  	    	<thead>
  	    		<tr>
              <th>ID Distribusi</th>
  	    			<th>Mata Pelajaran</th>
              <th style="text-align: center;">Nama Kelas</th>
  	    			<th style="width: 130px; text-align: center;">Aksi</th>
  	    		</tr>
          
  	    	</thead>
  	    </table>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title" style="color: darkorange"><i class="fa fa-info-circle"></i> Informasi</h3>
      </div>
      <div class="box-body">
        <p>Daftarkan seluruh kelas malalui halaman ini. Data kelas diperlukan untuk mengelompokan siswa dan untuk mendistribusian paket soal.</p>
        <p>Jika terdapat data kelas yang belum valid atau kelas yang belum terdaftar, hubungi operator sekolah untuk merubah atau mendaftarkan kelas tersebut.</p>
      </div>
    </div>
  </div>
@endsection
@push('css')
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
@endpush
@push('scripts')
  <script src="{{URL::asset('assets/dist/js/offline.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
  <script>
    $(document).ready(function (){
      function checkconnection() {
        var status = navigator.onLine;
        if (status) {
          // alert("online");
        } else {
          // alert("offline");
        }
      }

    	tabel_kelas = $('#tabel_distribusi').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthChange: true,
        ajax:'{!! route('distribusi.data_distribusi') !!}',
        columns: [
          {data: 'id', name: 'id', orderable: true, searchable: true },
          {data: 'soal', name: 'soal', orderable: true, searchable: true },
          {data: 'kelas', name: 'kelas', orderable: false, searchable: false },
          {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "drawCallback": function (setting) {
          $('.del-distribusi').on('click', function() {
            var id_distribusi = $(this).attr('id');
            var $this = $(this);
            swal({
              title: 'Yakin akan dihapus?',
              text: "Data yang telah dihapus tidak bisa dikembalikan.",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                $.ajax({
                  type: 'POST',
                  url: "{{ url('crud/delete-distribusi') }}",
                  data: {id_distribusi:id_distribusi},
                  success: function(data) {
                    swal(
                      'Berhasil!',
                      'Data Distribusi berhasil dihapus.',
                      'success'
                    )
                    $this.closest('tr').hide();
                  }
                })
              }
            })
          });
        }
      });

      $('#btn-create').click(function() {
        $('#form-distribusi').slideToggle();
      });

      $('#save').click(function() {
        $('#notif').hide();
        var formData = $('#form-distribusi').serialize();
        $.ajax({
          type: 'POST',
          url: "{{ url('crud/simpan-distribusi') }}",
          data: formData,
          success: function(data) {
            if (data == 1) {
              window.location.href = "{{ url('distribusi') }}";
            }else{
              $('#notif').html(data).show();
            }
          }
        })
      });
    });
  </script>
@endpush