@extends('users.dashboard')
@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="spinner-grow text-primary" role="status" id="spinner">
			<span class="sr-only">Loading...</span>
		</div>
		{{-- Session Flash Alert Sukses Dan Gagal --}}
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
		<div class="jumbotron">
			<h2 class="text-center">Hallo !! {{ Auth::guard('user')->user()->username }}</h2>
			<br>
			<div class="float-center" style="text-align: center;">
				<button class="btn btn-xl btn-primary" data-toggle="modal" data-target="#voting">Ayok Voting !</button>
			</div>
			<br>
			<p style="color: red; text-align: center; font-weight: 700">* Click Tombol Ini Jika Ingin Melakukan Vote !</p>
		</div>
	</div>
</div>

<div class="modal fade" id="voting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Nyok Voting</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					@csrf

					<div class="alert alert-danger" id="titleError">
						<span class="alert-message"></span>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label class="text-dark">ID Voting</label>
								<input class="form-control" type="text" name="id_voting" id="id_voting" placeholder="12002xx" style="border-radius: 20px;">
								{{-- <span id="titleError" class="alert-message"></span> --}}
								<small style="color: red">* Masukan ID Voting Untuk Melakukan Voting</small>
							</div>	
							<div class="button" style="text-align: center;">
								<button class="btn btn-success btn-xl btn-block" id="btn-search">Voting</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
	$(document).ready(function() {
		
		var my_url = '{{ env('BaseUrl') }}'

		// Search Vote Berdasarkan ID Vote
		$('#btn-search').click(function(e) {
			e.preventDefault();
			let _token   = $('meta[name="csrf-token"]').attr('content');
			var formData = {
				id_voting:	$('#id_voting').val(),
				_token: _token
			}

			var state = $('#btn-search');
			var type = "POST";
			var id_voting = $('#id_voting').val();
			var dataType = 'JSON';

			$.ajax({
				url: my_url + 'users/vote/search',
				type: type,
				data: formData,
				dataType: dataType,
				success: function(result){

					if (result.code === 200 && result.status === 'vote_personal') {
						// alert('personal')
						window.location = "/users/vote/" + result.data.id_voting
					} else if(result.code === 200 && result.status === 'vote_multi') {
						
						window.location = "users/vote/multi/" + result.data_multi.id_multi
					} else {
						swal("Upss !!!!", "ID Vote Tidak Di Temukan", "error");
					}
				},
				error: function(err){
					$('#titleError').text(err.responseJSON.errors.id_voting);
				}
			})
		})
	})
</script>
@endsection