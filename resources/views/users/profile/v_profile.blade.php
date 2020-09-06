@extends('users.dashboard')
@section('content')

<div class="row">
	<div class="col-xl-4 order-xl-2">
		<div class="card card-profile">
			<img src="{{ url('template/assets/img/theme/img-1-1000x600.jpg') }}" alt="Image placeholder" class="card-img-top">
			<div class="row justify-content-center">
				<div class="col-lg-3 order-lg-2">
					<div class="card-profile-image">
						<a href="#">
							<img src="{{ url('template/assets/img/theme/team-4.jpg') }}" class="rounded-circle">
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
				<div class="row">
					<div class="col">
						<div class="card-profile-stats d-flex justify-content-center">
							<div>
								<span class="heading">22</span>
								<span class="description">Friends</span>
							</div>
							<div>
								<span class="heading">10</span>
								<span class="description">Photos</span>
							</div>
							<div>
								<span class="heading">89</span>
								<span class="description">Comments</span>
							</div>
						</div>
					</div>
				</div>
				<div class="text-center">
					<h5 class="h3">
						{{ $profile->username }}<span class="font-weight-light">, 27</span>
					</h5>
					<div class="h5 font-weight-300">
						<i class="ni location_pin mr-2"></i>Bucharest, Romania
					</div>
					<div class="h5 mt-4">
						<i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer
					</div>
					<div>
						<i class="ni education_hat mr-2"></i>University of Computer Science
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-8 order-xl-1">
		<div class="card">
			<div class="card-header">
				<div class="row align-items-center">
					<div class="col-8">
						<h3 class="mb-0">Edit profile </h3>
					</div>
					<div class="col-4 text-right">
						<a href="#!" class="btn btn-sm btn-primary">Settings</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<h6 class="heading-small text-muted mb-4">User information</h6>
				<div class="pl-lg-4">
					<form action="{{ route('profile.update') }}" method="POST">
						@csrf
						{{ method_field('PUT') }}

						 @if (session('success'))
							 <div class="alert alert-success alert-block">
							 	<button type="button" class="close" data-dismiss="alert">×</button> 
							 	<strong>{{ session('success') }}</strong>
							 </div>

						 @elseif(session('gagal'))
							 <div class="alert alert-danger alert-block">
							 	<button type="button" class="close" data-dismiss="alert">×</button> 
							 	<strong>{{ session('success') }}</strong>
							 </div>
						 @endif
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="form-control-label" for="input-username">Username</label>
									<input type="text" id="input-username" class="form-control" name="username" value="{{ $profile->username }}">
									<input type="hidden" class="form-control" name="id_users" value="{{ $profile->id_users }}">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="form-control-label" for="input-email">Email address</label>
									<input type="email" id="input-email" class="form-control" name="email" value="{{ $profile->email }}">
								</div>
								<div class="float-right">
									<button type="submit" class="btn btn-xl btn-primary">Update Profile</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<hr class="my-4" />
				<!-- Address -->
				<h6 class="heading-small text-muted mb-4">Password information</h6>
				<div class="pl-lg-4">
					<form action="{{ route('profile.password') }}" method="POST">
						@csrf
						{{ method_field('PUT') }}
						
						@if ($message = Session::get('sukses'))
						<div class="alert alert-success alert-block">
							<button type="button" class="close" data-dismiss="alert">×</button> 
							<strong>{{ $message }}</strong>
						</div>
						@endif

						@if ($message = Session::get('gagal'))
						<div class="alert alert-danger alert-block">
							<button type="button" class="close" data-dismiss="alert">×</button> 
							<strong>{{ $message }}</strong>
						</div>
						@endif

						@if ($message = Session::get('peringatan'))
						<div class="alert alert-warning alert-block">
							<button type="button" class="close" data-dismiss="alert">×</button> 
							<strong>{{ $message }}</strong>
						</div>
						@endif
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="form-control-label" for="input-last-name">Password Lama</label>
									<input type="password" class="form-control" placeholder="Masukan Password Lama" name="password_old"	>
								</div>
								<div class="form-group">
									<label class="form-control-label" for="input-last-name">Password Baru</label>
									<input type="password" class="form-control" placeholder="Masukan Password Baru" name="password_new">
								</div>
								<div class="float-right">
									<button type="submit" class="btn btn-xl btn-primary">Update Password</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection