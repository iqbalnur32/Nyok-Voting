@extends('admin.dahsboard')
@section('content')

<div class="row">
	<div class="col-xl-8 order-xl-2">
		<div class="card">
			<div class="card-header">
				<h2>Management Jawaban Vote</h2>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table align-items-center">
						<thead class="thead-light">
							<tr>
								<th class="sort text-center">No</toh>
									<th class="sort text-center">Id Vote</th>
									<th class="sort text-center">Username</th>
									<th class="sort text-center">Nama</th>
									<th class="sort text-center">Jawaban</th>
									<th class="sort text-center">Description</th>
									<th class="sort text-center"><i class="fas fa-cog"></i></th>
								</tr>
								@forelse($jawaban as $key)
								<tbody>
									<tr id="row_{{$key->id_jawaban}}">
										<td class="text-center">{{ $loop->iteration }}</td>
										<td class="text-center">{{ $key->id_voting }}</td>
										<td class="text-center">{{ $key->jawaban_voting_users->username }}</td>
										<td class="text-center">{{ $key->nama_lengkap }}</td>
										<td class="text-center">{{ $key->jawaban }}</td>
										<td class="text-center">{{ $key->description }}</td>
										<td align="center" class="d-flex">
											<button class="btn btn-sm btn-primary open_modal_jawaban" value="<?=$key->id_jawaban?>"><i class="fas fa-pencil-alt"></i></button>
											<form action="{{ route('management-jawaban.destroy',$key->id_jawaban) }}"  method="POST">
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
					<h2>Add Data Jawaban</h2>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-xl-12">
							<form method="POST" action="{{ route('management-jawaban.store') }}">
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
									<label>Id Vote</label>
									<select class="form-control" name="id_voting">
										@foreach($id_vote as $key)
										<option value="{{ $key->id_voting }}">{{ $key->id_voting }} | </option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Users</label>
									<select class="form-control" name="id_users">
										@foreach($id_users as $key)
										<option value="{{ $key->id_users }}">{{ $key->username }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Nama Lengkap</label>
									<input class="form-control" type="text" name="nama_lengkap" required>
								</div>
								<div class="form-group">
									<label>Jawaban</label>
									<select class="form-control" name="jawaban">
										<option value="setuju">Setuju</option>
										<option value="tidak_setuju">Tidak Setuju</option>
									</select>
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
</div>

<!-- Modal -->
<div class="modal fade" id="jawaban-vote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
						<form method="POST" action="{{ route('management-jawaban.store') }}">
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

							<input class="form-control" type="hidden" name="id_jawaban" id="id_jawaban" required>
							<div class="form-group">
								<label>Id Vote</label>
								<select class="form-control" name="id_voting" id="id_voting">
									@foreach($id_vote as $key)
									<option value="{{ $key->id_voting }}">{{ $key->id_voting }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label>Users</label>
								<select class="form-control" name="id_users" id="id_users">
									@foreach($id_users as $key)
									<option value="{{ $key->id_users }}">{{ $key->username }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label>Nama Lengkap</label>
								<input class="form-control" type="text" name="nama_lengkap" id="nama_lengkap" required>
							</div>
							<div class="form-group">
								<label>Jawaban</label>
								<select class="form-control" name="jawaban" id="jawaban">
									<option value="setuju">Setuju</option>
									<option value="tidak_setuju">Tidak Setuju</option>
								</select>
							</div>
							<div class="form-group">
								<label>Description</label>
								<textarea class="form-control" name="description" id="description" required></textarea>
							</div>
							<div class="float-right">
								<button class="btn btn-xl btn-outline-primary" id="jawaban-update" type="submit">Update</button>
							</div>
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

		// Open Modal Jawaban
		$(document).on('click', '.open_modal_jawaban', function() {
			var id_jawaban = $(this).val()

			var base_url = my_url + "{{ route('management-jawaban.edit', ':id') }}"
			base_url = base_url.replace(':id', id_jawaban);

			fetch(base_url)
			.then(response => response.json())
			.then(result => {
				if (result.code === 200) {
					$('#id_jawaban').val(result.data.id_jawaban)
					$('#id_voting').val(result.data.id_voting)
					$('#id_users').val(result.data.id_users)
					$('#nama_lengkap').val(result.data.nama_lengkap)
					$('#jawaban').val(result.data.jawaban)
					$('#description').val(result.data.description)
					$('#jawaban-vote').modal('show')
				}
			})
		})

		$('#jawaban-update').click(function(e) {
			e.preventDefault();

			var id_jawaban = $('#id_jawaban').val();

			let _token = $('meta[name="csrf-token"]').attr('content');
			var formData = {
				id_voting : $('#id_voting').val(),
				id_users : $('#id_users').val(),
				nama_lengkap : $('#nama_lengkap').val(),
				jawaban : $('#jawaban').val(),
				description : $('#description').val(),
				_token : _token
			}

			var base_url = my_url + "{{ route('management-jawaban.update', ':id') }}"
			base_url = base_url.replace(':id', id_jawaban);

			var type = "PUT";
			var dataType = 'JSON';

			$.ajax({
				url: base_url,
				type: type,
				enctype: 'multipart/form-data',
				data: formData,
				dataType: dataType,
				success: function(result) {
					if (result.code === 200) {
						alert('berhasil');
						// $('#row_'+id_jawaban).html(result.data);
						location.reload();
					} else {
						alert('gagal');
					}

				},
				error: function(err){
					console.log(err)
				}
			})
		})

	})
</script>
@endsection