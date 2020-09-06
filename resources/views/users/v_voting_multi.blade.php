@extends('users.dashboard')
@section('content')
<div class="row">
	<div class="col-xl-12 order-xl-2">
		<div class="card">
			<div class="card-header">
				<h2 class="text-center">Silahkan Pilih Pilihanmu</h2>
				@if($count_voting_multi === 1)
					<div class="alert alert-warning">
						<button type="button" class="close" data-dismiss="alert">×</button>
						Tampak nya anda sudah melakukan Vote , Terima Kasih !!
					</div>
				@else 
					<div class="jumbotron">
						<h1 class="text-center" style="color: red">{{ $voting_multi->id_multi }}</h1>
						<p class="text-center" style="color: red;">* Perhatian !!! UNTUK MELAKUKAN PEMILIHAN PASTIKAN KODE UNIK DI ATAS DI MASUKAN PADA 1 KANDIDAT YANG AKAN DI PILIH</p>
					</div>
				@endif
			</div>
			<div class="card-body">
				@if($count_voting_multi === 1)
					<div class="count_vote">
						
					</div>
				@else 
					<h2 class="text-center">{{ $voting_multi->title }}</h2>
					<hr style="border: 1px solid; width: 50%;">
					<div class="row">
						<?php foreach (json_decode($voting_multi->candidate_img1)as $picture) { ?>
							<div class="col-xl-3 col-sm-3 col-md-3 col-lg-3">
								<div class="card">
									<div class="card-header">
										<div class="widget-user-image text-center">
											<img class="img-fluid" src="{{ asset('/images/'.$picture) }}" style="height: 170px;width: 200px;">
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="row">
						<?php foreach (json_decode($voting_multi->candidate_name1)as $name) { ?>
							<div class="col-xl-3 col-sm-3 col-md-3 col-lg-3">
								<h3 class="text-center">{{ $name }}</h3>
								<form method="POST" action="{{ route('vote.multi.process') }}">
									@csrf
									<div class="text-center">
										<input class="form-control" type="hidden" name="pilihan" value="{{ $name }}">
										<input class="form-control" type="number" name="id_multi" placeholder="Inputkan ID Vote Anda Sesuai Vote Anda">
										<div class="buttom" style="margin-bottom: 12px;"></div>
										<button class="btn btn-primary btn-sm">Pilih</button>
									</div>
								</form>
								<div class="buttom" style="margin-bottom: 14px;"></div>
							</div>
						<?php } ?>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>

@endsection

@section('javascript')
@section('javascript')
<script type="text/javascript">
	$(document).ready(function () {

		// $('#sumit-pilihan').click(function(e) {
		// 	e.preventDefault();

		// 	var id_multi = $('#id_multi').val();
		// 	var id_pilihan = $('#pilihan').val();
		// 	alert(id_pilihan)
		// })

		$('#count_vote').ready(function() {
			swal("Upss !!!!", "Upss Tampaknya anda sudah melakukan vote", "error");
		})
	})
</script>
@endsection
@endsection