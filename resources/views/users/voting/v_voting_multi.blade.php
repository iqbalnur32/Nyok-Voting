@extends('users.dashboard')
@section('content')

<div class="row">
	<div class="col-xl-12 order-xl-2">
		<div class="card">
			<div class="card-header">
				<h2 class="text-center">Buat Voting Multi Mu Disini !</h2> 
			</div>
			<div class="card-body">
				<form enctype="multipart/form-data" action="{{ route('voting-multi.store') }}" method="POST">
					@csrf

					@if (count($errors) > 0)
					<div class="alert alert-danger">
						<strong>Sorry !</strong> There were some problems with your input.<br><br>
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif

					@if (session('success_multi'))
					<div class="alert alert-success alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button> 
						<strong>{{ session('success_multi') }}</strong>
					</div>

					@elseif(session('gagal_multi'))
					<div class="alert alert-danger alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button> 
						<strong>{{ session('gagal_multi') }}</strong>
					</div>
					@endif

					<div class="row">
						<div class="col-xl-12">
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group">
										<label>Title</label>
										<input class="form-control" type="text" name="title" required="">
									</div>
									<div class="form-group">
										<label>Candidate Name</label>
										<div class="input-group increment">
											<input class="form-control" type="text" name="candidate_name1[]" placeholder="Candidate 1" required=""><br>
										</div>
										<div class="clone hide">
											<div class="input-group" style="margin-top:10px">
												<input class="form-control" type="text" name="candidate_name1[]" placeholder="Candidate 1" required="">
												<div class="input-group-append"> 
													<button class="btn btn-outline-danger" type="button">Remove</button>
												</div>
											</div>
										</div>
										<small style="color: red">* Sesuaikan dengan calon anda</small><br>
										<button class="btn btn-outline-primary" id="btn-input-multi-candidate">Add Kandidat</button>
									</div>	
								</div>
								<div class="col-xl-6">
									<div class="form-group">
										<label>Pilih Categroy Voting</label>
										<select class="form-control" name="id_category">
											@foreach($category as $key)
											<option value="{{ $key->id_category }}">{{ $key->name_category }}</option>
											@endforeach
										</select>
									</div>	
									<div class="form-group">
										<label>Image</label>
										<div class="input-group increment-img">
											<input class="form-control" type="file" name="candidate_img1[]"><br>
										</div>
										<div class="clone-img">
											<div class="input-group input-img" style="margin-top:10px">
												<input class="form-control" type="file" name="candidate_img1[]"><br>
												<div class="input-group-append"> 
													<button class="btn btn-outline-danger" id="img-btn" type="button">Remove</button>
												</div>
											</div>
										</div>
										{{-- <button class="btn btn-sm btn-warning" id="takeBtn">Ambil Foto</button> --}}
										<small style="color: red">* Sesuaikan foto calon anda</small><br>
										<button class="btn btn-outline-primary" id="btn-input-multi-img">Add Img</button>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Description</label>
								<textarea class="form-control" name="description" required=""></textarea> 
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
	<div class="col-xl-12 order-xl-2">
		<div class="card">
			<div class="card-header">
				<h2>Multiple Vote Table</h2>
			</div>
			<div class="card-body pt-0">
				<div class="table-responsive">
					<table class="table align-items-center">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Candidate</th>
								<th>Gambar Candidate</th>
								<th>Description</th>
								<th>Category</th>
								<th>Actions</th>
							</tr>
						</thead>
						@foreach($voting as $key)
						<tbody>
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td> 
									<div class="row">
										<?php foreach (json_decode($key->candidate_name1)as $name) { ?>
											<div class="col-md-3 order-xl-2">
												{{ $name }}
											</div>
										<?php } ?>
									</div>
								</td>
								<td> 
									<div class="row">
										<?php foreach (json_decode($key->candidate_img1)as $picture) { ?>
											<div class="col-xl-3 order-xl-2">
												<img src="{{ asset('/images/'.$picture) }}" style="height:50px; width:50px"/>
											</div>
										<?php } ?>
									</div>
								</td>
								<td>{{ $key->description }}</td>
								<td>{{ $key->category_voting->name_category }}</td>
								<td class="d-flex">
									<button class="btn btn-sm btn-primary" id="get-id-voting" data-toggle="modal" data-target="	#exampleModal"
									data-id_multi="{{ $key->id_multi }}"
									data-title="{{ $key->title }}"
									>Share Vote</button>
									<form action="{{ route('vote.multi.delete',$key->id_multi) }}" method="POST">
										@method('DELETE')
										@csrf
										<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
									</form>
								</td>
							</tr>
						</tbody>
						@endforeach
					</table>
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
        <p style="font-weight: 600" id="id_multi"></p>
        <small style="color: red">* Bagikan Link ID Vote Anda Ke Users</small>
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

		// Get ID Voting
		$(document).on('click', '#get-id-voting', function() {
			var id_multi = $(this).data('id_multi');
			var title = $(this).data('title');

			console.log(id_multi)

			$('#title').text(title);
			$('#id_multi').text(id_multi);
			$('#myModal').modal('show');
		});

		// Multi Candidate Img Appen Input
		$('#btn-input-multi-img').click(function() {
			$('.clone-img').append('<div class="input-group input-img" style="margin-top:10px"><input class="form-control" type="file" name="candidate_img1[]"><br><div class="input-group-append"> <button class="btn btn-outline-danger" type="button">Remove</button></div></div>');
		})

		// Multi Candidate Name Appen Input
		$('#btn-input-multi-candidate').click(function() {
			$('.clone').append('<div class="input-group" style="margin-top:10px"><input class="form-control" type="text" name="candidate_name1[]" placeholder="Candidate 1" required=""><div class="input-group-append"><button class="btn btn-outline-danger" type="button">Remove</button></div></div>');
		})



		// Delete Input Name And Img Candidate
		$("body").on("click",".btn-outline-danger",function(){ 
			$(this).parents(".input-group").remove();
		});

		$("body").on("click","#img-btn",function(){ 
			$(this).parents(".increment-img").remove();
		});
	});

</script>
@endsection
