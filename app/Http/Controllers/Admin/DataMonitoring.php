<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Users;
use DB;

class DataMonitoring extends Controller
{
	
	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	
}

?>