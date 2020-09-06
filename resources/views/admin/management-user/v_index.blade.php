@extends('admin.dahsboard')
@section('content')

<div class="row">
	<div class="col-xl-8 order-xl-2">
		<div class="card">
			<div class="card-header">
				<h2>Management Users</h2>
			</div>
			<div class="card-body pt-0">
				<div class="table-responsive">
					<table class="table align-items-center">
						<thead class="thead-light">
							<tr>
								<th class="sort text-center">No</toh>
									<th class="sort text-center">Username</th>
									<th class="sort text-center">Status</th>
									<th class="sort text-center">Level</th>
									<th class="sort text-center"><i class="fas fa-cog"></i></th>
								</tr>
								@forelse($users as $key)
								<tbody>
									<tr>
										<td class="text-center">{{ $loop->iteration }}</td>
										<td class="text-center">{{ $key->username }}</td>
										<td class="text-center">{{ $key->status }}</td>
										<td class="text-center">{{ $key->name }}</td>
										<td align="center" class="d-flex">
											<button class="btn btn-sm" id="get-id-category" data-toggle="modal" data-target="#exampleModal"
											data-id_users="{{ $key->id_users }}"
											data-username="{{ $key->username }}"
											data-email="{{ $key->email }}"
											data-password="{{ $key->password }}"
											data-level_id="{{ $key->level_id }}"
											><i class="fas fa-pencil-alt"></i></button>

											<form action="{{ route('management-users.destroy',$key->id_users) }}"  method="POST">
												@csrf
												@method('delete')
												<button type="submit" class="btn btn-danger btn-sm"  onclick="return confirm('Yakin Data Mau Dihapus??');"><i class="fas fa-trash"></i></button>
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
					<h2>Add Users</h2>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-xl-12">
							<form method="POST" action="{{ route('management-users.store') }}">
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
								<div class="alert alert-warning">
									<button type="button" class="close" data-dismiss="alert">×</button>
									<ul>
										@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
								@endif
								<div class="form-group">
									<label>Username</label>
									<input class="form-control" type="text" name="username">
								</div>
								<div class="form-group">
									<label>Email</label>
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Email .." name="email" aria-describedby="basic-addon2">
										<div class="input-group-append">
											<span class="input-group-text" id="basic-addon2">@gmail.com</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>password</label>
									<input class="form-control" type="password" name="password">
								</div>
								<div class="form-group">
									<label>Level Users</label>
									<select class="form-control" name="level_id">
										@foreach($level as $key)
										<option value="{{ $key->id_level }}">{{ $key->name }}</option>
										@endforeach
									</select>
								</div>
								<button type="submit" class="btn btn-outline-primary btn-block">Submit</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Users Management -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Users Management</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xl-12">
							<form>
								@csrf
								<div class="form-group">
									<label>Username</label>
									<input class="form-control" type="hidden" name="username" id="id_users">
									<input class="form-control" type="text" name="username" id="username">
								</div>
								<div class="form-group">
									<label>Email</label>
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Email .." name="email" id="email" aria-describedby="basic-addon2">
										<div class="input-group-append">
											<span class="input-group-text" id="basic-addon2">@gmail.com</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>password</label>
									<input class="form-control" type="password" name="password" id="password">
								</div>
								<div class="form-group">
									<label>Level Users</label>
									<select class="form-control" name="level_id" id="level_id">
										@foreach($level as $key)
										<option value="{{ $key->id_level }}">{{ $key->name }}</option>
										@endforeach
									</select>
								</div>
								<button type="submit" id="btn-edit" class="btn btn-outline-primary btn-block">Update</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('javascript')
<script type="text/javascript">
	$(document).ready(function() {

		var my_url = '{{ env('BaseUrl') }}'

		// Get Modal Show Edit Category
		$(document).on('click', '#get-id-category', function() {
			var id_users = $(this).data('id_users');
			var username = $(this).data('username');
			var email = $(this).data('email');
			var password = $(this).data('password');
			var level_id = $(this).data('level_id');

			$('#id_users').val(id_users);
			$('#username').val(username);
			$('#email').val(email);
			$('#password').val(password);
			$('#level_id').val(level_id);
			$('#myModal').modal('show');
		});

		// Edit Process
		$('#btn-edit').click(function(e) {
			e.preventDefault();

			let _token   = $('meta[name="csrf-token"]').attr('content');
			var formData = {
				id_users:	$('#id_users').val(),
				username:	$('#username').val(),
				email:	$('#email').val(),
				password:	$('#password').val(),
				level_id:	$('#level_id').val(),
				_token: _token
			}

			var state = $('#btn-edit');
			var type = "PUT";
			var id_users = $('#id_users').val();
			var dataType = 'JSON';

			// console.log(formData)

			var base_url = my_url + "{{ route('management-users.update', ':id') }}"
			base_url = base_url.replace(':id', id_users);
			
			$.ajax({
				url: base_url,
				type: type,
				data: formData,
				dataType: dataType,
				success: function(result){			

					if (result.status === 200) {
						window.location = "/admin/management-users"

					} else if(result.status === 401) 	{
						swal("Upss !!!!", "Gagal Update Data", "error");
					} else {
						swal("Upss !!!!", "Gagal Update Data", "error");
					}
				},
				error: function(err){
					console.log(err.responseJSON)
				}
			})
		})
	});

</script>
@endsection