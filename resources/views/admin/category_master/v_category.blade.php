@extends('admin.dahsboard')
@section('content')

<div class="row">
	<div class="col-xl-8 order-xl-2">
		<div class="card">
			<div class="card-header">
				<h2>Master Category Vote</h2>
			</div>
			<div class="card-body pt-0">
				<div class="table-responsive">
					<table class="table align-items-center">
						<thead class="thead-light">
							<tr>
								<th class="sort text-center">No</toh>
									<th class="sort text-center">Name</th>
									<th class="sort text-center">Description</th>
									<th class="sort text-center"><i class="fas fa-cog"></i></th>
								</tr>
								@forelse($category as $key)
								<tbody>
									<tr id="row_{{$key->id_category}}">
										<td class="text-center">{{ $loop->iteration }}</td>
										<td class="text-center">{{ $key->name_category }}</td>
										<td class="text-center">{{ $key->description }}</td>
										<td align="center" class="d-flex">
											<button class="btn btn-sm" id="get-id-category" data-toggle="modal" data-target="#exampleModal"
											data-id_category="{{ $key->id_category }}"
											data-name_category="{{ $key->name_category }}"
											data-description="{{ $key->description }}"
											><i class="fas fa-pencil-alt"></i></button>
											<form action="{{ route('category.delete',$key->id_category) }}"  method="POST">
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
					<h2>Add Data</h2>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-xl-12">
							<form method="POST" action="{{ route('master-category') }}">
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
									<label>Name</label>
									<input class="form-control" type="text" name="name_category" required>
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

	<!-- Modal Category -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
							<form>
								@csrf
								<div class="form-group">
									<label>Name Category</label>
									<input class="form-control" type="text" name="name_category" id="name_category" required>
									<input class="form-control" type="hidden" name="id_category" id="id_category" required>
								</div>
								<div class="form-group">
									<label>Description</label>
									<textarea class="form-control" name="description" id="description" required></textarea>
								</div>
								<div class="float-right">
									<button class="btn btn-sm btn-primary" id="btn-edit">Update</button>
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

		// Get Modal Show Edit Category
		$(document).on('click', '#get-id-category', function() {
			var id_category = $(this).data('id_category');
			var name_category = $(this).data('name_category');
			var description = $(this).data('description');

			$('#id_category').val(id_category);
			$('#name_category').val(name_category);
			$('#description').val(description);
			$('#myModal').modal('show');
		});

		// Update Data Category
		$('#btn-edit').click(function(e) {
			e.preventDefault();

			let _token   = $('meta[name="csrf-token"]').attr('content');
			var formData = {
				id_category:	$('#id_category').val(),
				name_category:	$('#name_category').val(),
				description:	$('#description').val(),
				_token: _token
			}

			var state = $('#btn-edit');
			var type = "PUT";
			var id_category = $('#id_category').val();
			var dataType = 'JSON';

			var base_url = my_url + "{{ route('category.edit', ':id') }}"
			base_url = base_url.replace(':id', id_category);
			console.log(base_url);

			// my_url + 'admin/master-category/edit/' + id_category
			$.ajax({
				url: base_url,
				type: type,
				data: formData,
				dataType: dataType,
				success: function(result){
					
					if (result.code === 200) {
						window.location = "/admin/master-category/"

					} else {
						swal("Upss !!!!", "Gagal Update Data", "error");
					}
				},
				error: function(err){
					console.log(err.responseJSON)
				}
			})
		})

		// Delete
		/*$('#btn-click').click(function(e) {

			e.preventDefault();

			let _token   = $('meta[name="csrf-token"]').attr('content');
			var id_category = $('#id_category').val();

			console.log(id_category)

			$.ajax({
				url: my_url + 'delete/' + id_category,
				type: 'DELETE',
				data: {
					_token: _token
				},
				success: function(response) {
					$("#row_"+id_category).remove();
				}
			});
		})*/

	});


</script>
@endsection

@endsection