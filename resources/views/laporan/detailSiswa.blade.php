@extends('layouts.app')
@section('title', $siswa->nama)
@section('breadcrumb')
<h1>Laporan</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></li>
	<li><a href="{{ url('/elearning/laporan') }}">Laporan</a></li>
	<li class="active">Detail</li>
</ol>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="col-md-8">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Detail Jawaban Siswa</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-2 col-sm-4">
					@if($siswa->gambar != '')
					<img class="profile-user-img img-responsive img-rounded" src="{{ url('/assets/img/'.$siswa->gambar) }}" alt="User profile picture">
					@else
					<img class="profile-user-img img-responsive img-rounded" src="{{ url('/assets/img/noimage.jpg') }}" alt="User profile picture">
					@endif
				</div>
				<div class="col-md-10 col-sm-8">
					<table style="background: #e6ebf2" class="table table-condensed table-bordered table-striped">
						<tr>
							<td>Nama siswa</td>
							<td>{{ $siswa->nama }}</td>
						</tr>
						<tr>
							<td>NIS</td>
							<td>{{ $siswa->no_induk }}</td>
						</tr>
						<tr>
							<td>NISN</td>
							<td>{{ $siswa->nisn }}</td>
						</tr>
						<tr>
							<td>Kelas</td>
							<td>{{ $siswa->getKelas->nama }}</td>
						</tr>
						<tr>
							<td>Paket soal</td>
							<td>{{ $soal->paket }}</td>
						</tr>
						<tr>
							<td>Waktu ujian</td>
							<td>{{ timeStampIndo($hasil_ujian->created_at) }}</td>
						</tr>
						<tr>
							<td>Status ujian</td>
							<td>
								@if($hasil_ujian->status == 1)
								<label class="label label-info">Selesai</label>
								@else
								<label class="label label-warning">Sedang berlangsung</label>
								@endif
							</td>
						</tr>
						<tr>
							<td>Nilai</td>
							<td><b>{{ ($hasil_ujian->jumlah_nilai + $nilai_essay) }}</b></td>
						</tr>
					</table>

					@if($hasil_ujian->status == 1)
					<a target="_blank" href="{{ url('/cetak/pdf/hasil-ujian-persiswa/'.$siswa->id.'/'.$soal->id) }}" class="btn btn-warning btn-md" data-toggle='tooltip' title="Cetak laporan hasil ujian paket soal {{ $soal->paket }} untuk siswa an. {{ $siswa->nama }}"><i class="fa fa-file-pdf-o"></i> Cetak Laporan</a>
					@endif
				</div>
			</div>
			<hr>
			<h4>Soal Pilihan Ganda</h4>
			<hr style="margin: 4px 0 5px">
			<table id="table_hasil_ujian" class="table table-hover table-condensed">
				<thead>
					<tr>
						<th style="width: 10px"></th>
						<th>Soal</th>
						<th>Kunci</th>
						<th>Jawaban</th>
						<th>Nilai</th>
					</tr>
				</thead>
			</table>

			<hr>
			<h4>Soal Essay</h4>
			<hr style="margin: 4px 0 5px">
			<table class="table table-hover table-condensed">
				<thead>
					<tr>
						<th style="width: 10px"></th>
						<th style="width: 50%">Soal</th>
						<th>Jawaban</th>
						<th class="text-center" style="width: 90px">Nilai</th>
					</tr>
				</thead>
				<tbody>
					@if($soal_essay->count())
					<?php $no = 1; ?>
					@foreach($soal_essay as $essay)
					<tr>
						<td>{{ $no++ }}</td>
						<td>{!! $essay->soal ?? '' !!}</td>
						<td>{!! $essay->getJawab->jawab ?? '' !!}</td>
						<td>
							<input type="text" class="form-control text-center nilai-essay" data-id="{{ $essay->id ?? 0 }}" data-user="{{ $essay->getJawab->id_user ?? 0 }}" value="{{ $essay->getJawab->score ?? '' }}" placeholder="{{ rand(40,99) }}">
						</td>
					</tr>
					@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-md-4">
	@if($user->status == 'G' or $user->status == 'A')
	<div class="box box-danger">
		<div class="box-body">
			<p><i class="fa fa-question-circle" style="color: indianred"></i> Hasil kerja siswa dapat digunakan sebagai bahan evaluasi belajar siswa.</p>
			<p>Anda dapat mengelompokan jawaban siswa yang benar atau salah, sehingga memudahkan untuk mengidentifikasi materi apa yang sudah ataupun belum dikuasai oleh siswa.</p>
		</div>
	</div>
	@endif
</div>
@endsection
@push('css')
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
@endpush
@push('scripts')
<script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
<script>
	function delay(callback, ms) {
		var timer = 0;
		return function() {
			var context = this,
				args = arguments;
			clearTimeout(timer);
			timer = setTimeout(function() {
				callback.apply(context, args);
			}, ms || 0);
		};
	}


	$(document).ready(function() {
		table_hasil_ujian = $('#table_hasil_ujian').DataTable({
			processing: true,
			serverSide: true,
			responsive: true,
			lengthChange: true,

			ajax: {
				url: '{{ route("elearning.hasilSiswa") }}',
				data: {
					"id_user": '{{ $siswa->id }}'
				},
			},
			columns: [{
					data: 'empty_space',
					name: 'empty_space',
					orderable: false,
					searchable: false
				},
				{
					data: 'dataSoal',
					name: 'dataSoal',
					orderable: true,
					searchable: true
				},
				{
					data: 'kunci',
					name: 'kunci',
					orderable: true,
					searchable: true,
				},
				{
					data: 'pilihan',
					name: 'pilihan',
					orderable: true,
					searchable: true,
				},
				{
					data: 'score',
					name: 'score',
					orderable: true,
					searchable: true,
				},
			],
			"drawCallback": function(setting) {}
		});

		$(document).on('keyup', '.nilai-essay', delay(function() {
			const essay_id = $(this).data('id');
			const id_user = $(this).data('user');
			const score = $(this).val();
			$.ajax({
				type: "GET",
				url: "{{ url('elearning/soal/essay/simpan-score') }}",
				data: {
					essay_id: essay_id,
					id_user: id_user,
					score: score
				},
				success: function(data) {
					console.log(data);

				}
			})
		}, 500));
	});
</script>
@endpush