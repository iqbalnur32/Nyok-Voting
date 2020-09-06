@extends('users.dashboard')
@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h2 class="text-center">Vote Multiple</h2>
			</div>
			<div class="card-body">
				<a href="{{ route('voting-multi.index') }}" class="btn btn-outline-success btn-xl btn-block">Multiple Vote</a>
				<small style="color: red">* Ini merupakan fitur multiple vote, bisa lebih 2 untuk melakukan create voting dan maximal 4 column</small>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xl-8 order-xl-2">
		<div class="card">
			<div class="card-header">
				<h2>Voting Table</h2>
			</div>
			<div class="card-body pt-0">
				<div class="table-responsive">
					<table class="table align-items-center">
						<thead class="thead-light">
							<tr>
								<th class="sort text-center">No</toh>
								<th class="sort text-center">Title</th>
								<th class="sort text-center">Image</th>
								<th class="sort text-center">Description</th>
								<th class="sort text-center">Detail</th>
							</tr>
							@forelse($voting as $key)
								<tbody>
									<tr>
										<td class="text-center">{{ $loop->iteration }}</td>
										<td class="text-center">{{ $key->title }}</td>
										<td class="text-center"><img src="{{ url('/users/storange/image/' . $key->img) }}" width="150" height="150"></td>
										<td class="text-center">{{ $key->description }}</td>
										<td>
											<a  href="{{ route('voting.show', $key->id_voting) }}" class="btn btn-sm btn-success">Detail</a>
											<button class="btn btn-sm btn-primary" id="get-id-voting" data-toggle="modal" data-target="#exampleModal"
											data-id_voting="{{ $key->id_voting }}"
											data-title="{{ $key->title }}"
											>VOTE ID</button>
											<form action="{{ route('voting.destroy', $key->id_voting) }}" method="POST" class="d-inline">
												@csrf
												@if (session('success_delete'))
													<div class="alert alert-warning alert-block">
														<button type="button" class="close" data-dismiss="alert">×</button> 
														<strong>{{ session('warning_delete') }}</strong>
													</div>
												@endif
												@method('DELETE')
												<button type="submit" class="btn btn-danger btn-sm"  onclick="return confirm('Yakin Data Mau Dihapus??');"> Hapus</button>
											</form>
										</td>
									</tr>
								</tbody>
							@empty
								<br>
								<div class="alert alert-warning alert-block"> 
									<strong>Upss !!, Tampaknya Voting Anda Kosong</strong>
									<p style="font-weight: 600; font-size: 15px;">Silahkan Buat Voting Mu</p>
								</div>
							@endforelse
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-4 order-xl-2">
		<div class="card">
			<div class="card-header">
				<h2 class="text-center">Buat Voting Mu Disini !</h2>
			</div>
			<div class="card-body">
				<form enctype="multipart/form-data" action="{{ route('voting.store') }}" method="POST">
					@csrf

					@if (session('success'))
					<div class="alert alert-success alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button> 
						<strong>{{ session('success') }}</strong>
					</div>

					@elseif(session('gagal'))
					<div class="alert alert-danger alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button> 
						<strong>{{ session('gagal') }}</strong>
					</div>
					@endif
					<div class="row">
						<div class="col-xl-12">
							<div class="form-group">
								<label>Title</label>
								<input class="form-control" type="text" name="title" required>
							</div>
							<div class="form-group">
								<label>Image</label>
								<input class="form-control" type="file" name="img">
								<small style="color: red">* Kosongkan Jika Tidak Upload Gambar</small>
								{{-- <button class="btn btn-sm btn-warning" id="takeBtn">Ambil Foto</button> --}}
							</div>
							<div class="form-group">
								<label>Pilih Categroy Voting</label>
								<select class="form-control" name="id_category">
									@foreach($category as $key)
										<option value="{{ $key->id_category }}">{{ $key->name_category }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label>Description</label>
								<textarea class="form-control" name="description" required></textarea> 
							</div>
							<div class="float-right">
								<button type="submit" class="btn btn-primary btn-sm">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Id Voting -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ID Voting</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<label>Title Voting</label>
        <p style="font-weight: 600" id="title"></p><hr>
      	<label>ID Voting</label>
        <p style="font-weight: 600" id="id_voting"></p>
        <small style="color: red">* Bagikan Link ID Vote Jika Ingin Voting</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
	$(document).ready(function() {
		// $("#takeBtn").click(function(){
		// 	takeSnapshot();
		// });

		
		// function takeSnapshot()
		// {
		// 	const webcamElement = document.getElementById('webcam');
		// 	const webcam = new Webcam(webcamElement, 'user');

		// 	webcam.stop()
		// 	.then(result =>{
		// 		console.log("webcam started");
		// 	})
		// 	.catch(err => {
		// 		console.log(err);
		// 	});	
		// } 

		// Get ID Voting
		$(document).on('click', '#get-id-voting', function() {
			var id_voting = $(this).data('id_voting');
			var title = $(this).data('title');

			$('#title').text(title);
			$('#id_voting').text(id_voting);
			$('#myModal').modal('show');
		});
	});
</script>
@endsection