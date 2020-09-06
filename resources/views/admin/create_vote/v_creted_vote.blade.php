@extends('admin.dahsboard')
@section('content')

<div class="row">
	<div class="col-xl-8 order-xl-2">
		<div class="card">
			<div class="card-header">
				<h2>Management Created Vote</h2>
			</div>
			<div class="card-body pt-0">
				<div class="table-responsive">
					<table class="table align-items-center">
						<thead class="thead-light">
							<tr>
								<th class="sort text-center">No</toh>
									<th class="sort text-center">Users</th>
									<th class="sort text-center">Category</th>
									<th class="sort text-center">Title</th>
									<th class="sort text-center">Img</th>
									<th class="sort text-center">Description</th>
									<th class="sort text-center"><i class="fas fa-cog"></i></th>
								</tr>
								@forelse($created as $key)
								<tbody>
									<tr>
										<td class="text-center">{{ $loop->iteration }}</td>
										<td class="text-center">{{ $key->users->username }}</td>
										<td class="text-center">{{ $key->category_voting->name_category }}</td>
										<td class="text-center">{{ $key->title }}</td>
										<td class="text-center"><img src="{{ url('/users/storange/image/' . $key->img) }}" width="150" height="150"></td>
										<td class="text-center">{{ $key->description }}</td>
										<td align="center">
											<button class="btn btn-sm open_modal_created" value="<?=$key->id_voting?>"><i class="fas fa-pencil-alt"></i></button>
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
					<h2>Add Data</h2>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-xl-12">
							<form enctype="multipart/form-data" method="POST" action="{{ route('created-vote') }}">
								@csrf
								@if (session('sukses'))
								<div class="alert alert-primary">
									<button type="button" class="close" data-dismiss="alert">×</button>
									{{ session('sukses') }}
								</div>
								@elseif(session('gagal'))
								<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert">×</button>
									{{ session('gagal') }}
								</div>
								@endif

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
									<label>Username</label>
									<select class="form-control" name="id_users" required>
										@foreach($users as $key)
										<option value="{{ $key->id_users }}">{{ $key->username }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Category Vote</label>
									<select class="form-control" name="id_category" required>
										@foreach($category as $key)
										<option value="{{ $key->id_category }}">{{ $key->name_category }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Title</label>
									<input class="form-control" type="text" name="title" required>
								</div>
								<div class="form-group">
									<label>File Image</label>
									<input class="form-control" type="file" name="img" required>
								</div>
								<div class="form-group">
									<label>Description</label>
									<textarea class="form-control" name="description" required></textarea>
								</div>
								<div class="float-right">
									<button class="btn btn-sm btn-primary" type="submit">Tambah</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Created Vote -->
	<div class="modal fade" id="created-vote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Category Vote</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xl-12">
							<form id="test" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="id_voting" id="id_voting">
								<div class="form-group">
									<label>Username</label>
									<select class="form-control" name="id_users" required id="id_users">
										@foreach($users as $key)
										<option value="{{ $key->id_users }}">{{ $key->username }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Category Vote</label>
									<select class="form-control" name="id_category" required id="id_category">
										@foreach($category as $key)
										<option value="{{ $key->id_category }}">{{ $key->name_category }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Title</label>
									<input class="form-control" type="text" name="title" required id="title" id="title">
								</div>
								<div class="form-group">
									<label>Img</label>
									<input class="form-control" type="file" name="img" id="img">
									<small style="color: red">* Kosongkan Jika Tidak Di Ubah Gambarnya</small>
								</div>
								<div class="form-group">
									<label>Description</label>
									<textarea class="form-control" name="description" required id="description"></textarea>
								</div>
								<div class="float-right">
									<button class="btn btn-sm btn-primary" type="submit" id="btn-update">Update</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@section('javascript')
	<script type="text/javascript">
		$(document).ready(function() {

			var my_url = '{{ env('BaseUrl') }}'
			
			$(document).on('click', '.open_modal_created', function() {
				var id_voting = $(this).val()

				$.ajax({
					url: my_url + 'crated-vote/edit/' + id_voting,
					type: "GET",
					success: function(result){
						if (result.code === 200) {
							// console.log(result.data)
							$('#id_voting').val(result.data.id_voting)
							$('#id_users').val(result.data.users.id_users)
							$('#id_users').val(result.data.category_voting.id_category)
							$('#title').val(result.data.title)
							// $('#img').append('<img src="/users/storange/image/'+result.data.img+'" name="img" width="150" height="150">')
							$('#description').val(result.data.description)
							$('#created-vote').modal('show');

						} else {
							alert('error')
						}
					}
				})
			})

			$('#btn-update').click(function(e) {
				e.preventDefault();

				let _token = $('meta[name="csrf-token"]').attr('content');
				var formData = {
					id_voting : $('#id_voting').val(),
					id_users : $('#id_users').val(),
					id_category : $('#id_category').val(),
					title : $('#title').val(),
					img : $('input[name=image]').val(),
					description : $('#description').val(),
					_token : _token
				}

				// var id_users = $('#id_users').val()
				// var id_category = $('#id_category').val()
				// var title = $('#title').val()
				// var description = $('#description').val()
				// var file_data = $('#img').prop('files')[0];

				// var formDataP = new FormData($('#test')[0]);
				// formDataP.append('img', file_data)
				// formDataP.append('id_users', id_users)
				// formDataP.append('id_category', id_category)
				// formDataP.append('title', title)
				// formDataP.append('description', description)
				// formDataP.append('_token', _token)

				var state = $('#btn-update');
				var type = "PUT";
				var id_voting = $('#id_voting').val();
				var dataType = 'JSON';

				var base_url = my_url + "{{ route('created.vote.edit', ':id') }}"
				base_url = base_url.replace(':id', id_voting);

				$.ajax({
					headers: {
						'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					},
					url: base_url,
					type: type,
					enctype: 'multipart/form-data',
					data: formData,
					// processData: false,
					// contentType: false,
					dataType: dataType,
					success: function(result){
						if (result.code === 200) {
							alert('berhasil');
							location.reload();
						} else {
							alert('gagal')
						}
					},
					error: function(err){
						console.log(err.responseJSON)
					}
				})
				
			})

			/*fetch(my_url + 'crated-vote/edit/' + id_voting)
			.then(response => response.json())
			.then(result => {
				console.log(result)
				if (result.code === 200) {
					$('#title').val(data.title);
					$('#created-vote').modal('show');
				}
			})*/
		});


	</script>
	@endsection

	@endsection