<?php 

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;
use App\Models\Users;
use Session;

class UsersController extends Controller
{
	
	public function __construct()
	{
		# code...
	}

	// Dashboard Index
	public function index()
	{
		return view('users.index');
	}

	// Profile View
	public function profileView()
	{
		$profile = Users::where('id_users', Auth::guard('user')->user()->id_users)->first();

		return view('users.profile.v_profile', compact('profile'));
	}

	// Update Profile
	public function updateProfile(Request $request)
	{
		DB::beginTransaction();
		
		try {
			
			if ($request->input('password')) {
				$update = array(
					'username' => $request->username,
					'email' => $request->email,
					'password' => Hash::make($request->password)
				);
				Users::find($request->id_users)->update($update);
				DB::commit();
				return redirect()->back()->with('success', 'Berhasil Update Profile');

			} else {
				$update = array(
					'username' => $request->username,
					'email' => $request->email,
				);
				Users::find($request->id_users)->update($update);
				DB::commit();
				return redirect()->back()->with('success', 'Berhasil Update Profile');
			}

		} catch (Exception $e) {
			DB::rollback();
			return redirect()->back()->with('gagal', 'Gagal Update Profile');
		}
	}

	// Update Password Profile
	public function updateProfilePassword(Request $request)
	{
		try {
			
			$where = [
				'id_users' => Auth::guard('user')->user()->id_users
			];

			$data = Users::where($where)->first();

			if (!Hash::check($request->password_old, $data->password)) {
		
				Session::flash('peringatan', 'Password Tidak Sama');
				return redirect('/users/profile');
			} else {

				$user_pass = Users::find(Auth::guard('user')->user()->id_users);
				$user_pass->password = Hash::make($request->password_new);
				$user_pass->update();

				Session::flash('sukses', 'Password Berhasil Ter Update');
				return redirect('/users/profile');
				
			}
		} catch (Exception $e) {

			Session::flash('gagal', 'Gagal Update Password');
			return redirect('/users/profile');
			// $2y$10$h1AtCJUi1cYR6/y12X/bEezSE4KsumqTuUNdlySgou4WWZ9/vU/V2
			// 1234
		}
	}
}

?>