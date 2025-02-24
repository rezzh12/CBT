@extends('layouts.app')
@section('title', 'Ubah kelas')
@section('breadcrumb')
  <h1>Master Data</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Kelas</li>
  </ol>
@endsection
@section('content')
  <?php include(app_path().'/functions/myconf.php'); ?>
  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-edit" aria-hidden="true"></i> Ubah Distribusi</h3>
        <div class="pull-right">
          <button type="button" class="btn btn-primary" id="btn-create"><i class="fa fa-edit"></i> Buat Distribusi</button>
        </div>
      </div>
      <div class="box-body">
        <div class="col-sm-12">
          <div class="col-sm-12">
            <form id="form-distribusi" style="" class="form-horizontal">
            <div class="form-group">
                <label for="id_soal" class="col-sm-2 control-label">Mata Pelajaran</label>
                <div class="col-sm-10">
                <input type="hidden" name="id" value="{{ $distribusis }}">
                <select class="form-control" name="id_soal" id="id_soal" placeholder="Soal">
                    @forelse($distribusi as $ds)
                      <option value="{{$ds->id_soal }}">{{  $ds->soal->paket }}</option>
                    @empty
                    @endforelse
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
                    @forelse($distribusi as $ds)
                      <option value="{{  $ds->id_kelas }}">{{  $ds->kelas->nama }}</option>
                    @empty
                    @endforelse
                    @forelse($kelas as $kelas)
                      <option value="{{  $kelas->id }}">{{  $kelas->nama }}</option>
                    @empty
                    @endforelse
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
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  <script>
    $(document).ready(function (){
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