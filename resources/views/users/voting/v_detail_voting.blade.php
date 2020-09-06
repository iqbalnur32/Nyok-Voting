@extends('users.dashboard')
@section('content')

<div class="row">
	<div class="col-xl-12 order-xl-2">
		<div class="card">
			<div class="card-header">
				<h2 class="text-center">Detail Voting {{ $detail_voting->id_voting }}</h2>
				<input id="id_voting" type="hidden" name="" value="{{ $detail_voting->id_voting }}">
			</div>
			<div class="card-body pt-0">
				<div class="chart">
					<div id="chartVoting" style="height: 250"></div>
				</div>
				<div class="jawaban" style="padding-top: 100px;">
					@forelse($jawaban_voting as $key)
					
						{{-- Notif Jika Users Sudah Voting Setuju Dan Tidak Setuju --}}
						@if($key->jawaban === 'setuju')
							<h2 class="text-center" style="font-weight: 500; font-size: 20px;">{{ $key->nama_lengkap }} telah melakukan voting <span style="font-weight: 700; color: green">{{ $key->jawaban }}</span></h2>
						@else 
						<h2 class="text-center" style="font-weight: 500; font-size: 20px;">{{ $key->nama_lengkap }} telah melakukan voting <span style="font-weight: 700; color: red">{{ $key->jawaban }}</span></h2>
						@endif
					@empty
						<div class="alert alert-warning alert-block"> 
							<strong>Upss !!, Tampaknya Belum Ada Yang Voting</strong>
							<p style="font-weight: 600; font-size: 15px;">Silahkan Bagikan ID Voting Mu</p>
						</div>
					@endforelse
				</div>
				<br>
			</div>
		</div>
	</div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
	$(document).ready(function() {
		var id_voting = $('#id_voting').val()
		
		getStatic(id_voting)

		function getStatic(id_voting) 
		{
			$.ajax({
				url: 'http://127.0.0.1:8000/users/static/' + id_voting,
				dataType: 'JSON',
				success: function(result){

					console.log(result.data);

					if (result.data && result.data.length === 0) {
						alert('Upss Data Static Anda Masih Kosong')

					} else {
						new Morris.Bar({
							element: 'chartVoting',
							data: result.data,
							xkey: 'jawaban',
							ykeys: ['value'],
							labels: ['Jumlah Voting']
						});
					}
				},
				error: function(err){
					console.log(err)
				}
			})
		}
	})
</script>
@endsection