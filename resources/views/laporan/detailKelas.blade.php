@extends('layouts.app')
@section('title', 'Laporan')
@section('breadcrumb')
  <h1>Laporan</h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Laporan</li>
  </ol>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-8">
  <div class="box box-primary">
  	<div class="box-header with-border">
      <h3 class="box-title">Paket soal dalam kelas ({{ $kelas->nama }})</h3>
    </div>
    <div class="box-body">
	    <table class="table table-condensed" id="table_paket_soal">
	    	<thead>
	    		<tr>
	    			<th>Nama paket soal</th>
	    			<th style="text-align: center; width: 50px">Aksi</th>
	    		</tr>
	    	</thead>
      </table>
    </div>
  </div>
</div>
<div class="col-md-4">
  @if($user->status == 'G' or $user->status == 'A')
  <div class="box box-danger">
    <div class="box-body">
      <p><i class="fa fa-question-circle" style="color: indianred"></i> Rekap ujian dalam kelas {{ $kelas->nama }}. Daftar paket soal ujian akan tampil jika telah dikerjakan oleh siswa.</p>
      <p>Jika rekap ujian belum tampil, bisa dikarenakan soal belum di distribusikan atau soal belum dikerjakan oleh siswa.</p>
    </div>
  </div>
  @endif
</div>
@endsection
@push('css')
<link rel="stylesheet" href="{{url('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{url('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
<link rel="stylesheet" href="{{url('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
@endpush
@push('scripts')
<script src="{{url('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{url('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{url('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
<script>
$(document).ready(function () {
  table_paket_soal = $('#table_paket_soal').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: true,
    ajax: {
      url: '{{ route("elearning.laporan.data_paket_soal") }}', // Make sure the route is correct
      data: { "id_kelas": '{{ $kelas->id }}' }, // Ensure $kelas is defined in the Blade view
    },
    columns: [
      { data: 'paket', name: 'paket', orderable: true, searchable: true },
      { data: 'action', name: 'action', orderable: false, searchable: false },
    ],
    drawCallback: function (settings) {
      // Optional: You can perform additional actions after drawing the table (e.g., handling pagination or other elements)
    }
  });
});

</script>
@endpush