<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\CategoryVoting as Category;
use App\Models\CreateVoting as Created;
use App\Models\MultiVote as Multi;
use App\Models\Users;
use Auth;
use Str;
use DB;
use Session;

class MonitoringData extends Controller
{

	private function random_color_part() {
		return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
	}

	private function random_color() {
		return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
	}

	public function staticUsers($tanggal = null)
	{
		$tanggal_awal = date('Y-m-d', strtotime('-1 week', strtotime($tanggal)));
		$tanggal_akhir = date('Y-m-d', strtotime($tanggal));

		$user_static = Users::select(['last_login', DB::raw('count(*) as count') ])
					->groupBy('last_login')
					->whereBetween('last_login', [$tanggal_awal, $tanggal_akhir])
					->get();

		return response()->json([
			'tanggal_awal' => $tanggal_awal,
			'tanggal_akhir' => $tanggal_akhir,
			'data' => $user_static
		]); 
	}

	public function staticDataJawaban()
	{
		# code...
	}

	public function staticDataCreateVote()
	{
		# code...
	}

	public function staticDataUsersRegistrasi()
	{
		# code...
	}

	public function test($tanggal = null)
	{
		try {

			$tanggal_awal = date('Y-m-d', strtotime('-1 week', strtotime($tanggal)));
			$tanggal_akhir = date('Y-m-d', strtotime($tanggal));

			// Labels Tanggal
			$labels = array();
			for($i=1; $i <= 7; $i++){
				
				$labels[] = date('Y-m-d', strtotime($tanggal_akhir . '-'.$i.'days'));
			}

			$static_data = Users::select(['email', DB::raw('count(*) as value')])
							->groupBy('email')
							->whereBetween('last_login', [$tanggal_awal, $tanggal_akhir])
							->get();

			$output = array();
			foreach ($static_data as $key => $value) {
				$output[] = [
					'label' => $value->email,
					'backgroundColor' => '#'.$this->random_color(),
					'data' => [$value->value]
				];	
			}

			return response()->json([
				'status' => 200,
				'tanggal_awal' => $tanggal_awal,
				'tanggal_akhir' => $tanggal_akhir,
				'data' => $output,
				'labels' => $labels
			], 200);
			
		} catch (Exception $e) {
			
			return response()->json([
				'status' => 500,
				'msg' => 'Bad Request !'
			], 500);
		}
	}
}

?>