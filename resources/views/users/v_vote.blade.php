@extends('users.dashboard')
@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card card-profile">
			<!-- <img src="{{ url('template/assets/img/theme/img-1-1000x600.jpg') }}" alt="Image placeholder" class="card-img-top"> -->
			<div class="row justify-content-center">
				<div class="col-lg-3 order-lg-2">
					<div class="card-profile-image">
						<a href="#">
							<img src="{{ url('/users/storange/image/' . $voting_search->img) }}" class="rounded-circle">
						</a>
					</div>
				</div>
			</div>
			<div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
				<div class="d-flex justify-content-between">
					<a href="#" class="btn btn-sm btn-info  mr-4 ">Connect</a>
					<a href="#" class="btn btn-sm btn-default float-right">Message</a>
				</div>
			</div>
			<div class="card-body pt-0">
				@if($count_users_vote === 1)
					<div class="alert alert-warning alert-block">
						<h2 style="text-align: center; color: #fff; font-weight: 700">Upss !! Tampaknya Anda Sudah Melakukan Vote :"(</h2>
					</div>
				@else
					<button class="btn btn-block btn-xl btn-primary" style="border-radius: 20px;">{{ $voting_search->title }}</button>
					<br>
					<form action="{{ route('process.vote',$voting_search->id_voting) }}" method="POST">
						@csrf

						{{-- Validation Data Error --}}
						@if (count($errors) > 0)
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
						@endif
						
						<div class="form-group">
							<label>Nama Lengkap</label>
							<input class="form-control" type="text" name="nama_lengkap" placeholder="Masukan Nama Lengkap" required>
						</div>
						<div class="form-group">
							<label>Jawaban</label>
							<select class="form-control" name="jawaban">
								<option value="setuju">Setuju</option>
								<option value="tidak_setuju">Tidak Setuju</option>
							</select>
						</div>
						<div class="form-group">
							<label>Keterangan</label>
							<textarea class="form-control" name="description" placeholder="Keterangan ..." required></textarea>
						</div>
						<div class="button" style="text-align: center;">
							<button type="submit" class="btn btn-xl btn-success" style="width: 200px; border-radius: 20px;">Vote !</button>
						</div>
					</form>
				@endif
			</div>
		</div>
	</div>
</div>

@endsection