@extends('admin.dahsboard')
@section('content')
<div class="row">
	<div class="col-xl-12 order-xl-2">
		<div class="card">
			<div class="card-header">
				<h2 class="text-center">Monitoring Users</h2>
				<input class="form-control" align="left" type="date" id="staticUsersDate" value="<?= date('Y-m-d')?>">
			</div>
			<div class="card-body">
				<div id="chartStatic">
					<div id="myChart"></div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
	$(document).ready(function() {

		$('#staticUsersDate').change(function() {
			var date = $('#staticUsersDate').val();

			getStaticUsers(date)
		});

		function getStaticUsers($date) {

			$.ajax({
				url: 'static/users/' + $date,
				method: 'GET',
				datatype: 'json',
				success: function(result){
					Morris.Line({
						element: 'myChart',
						data: result.data,
						xkey: ['last_login'],
						ykeys: ['count'],
						labels: ['Last Login']
					})
				}
			});
		}

		$(document).ready(function() {
			var mom = moment().format("YYYY-MM-DD");

			getStaticUsers(mom)
		});
	})
</script>
@endsection