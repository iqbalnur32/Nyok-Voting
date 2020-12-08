<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Users;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\ResetPassword;
use App\Jobs\SendEmailJob;
use DB;
use Auth;
use Session;

class AuthController extends Controller
{
	
	protected $table = 'users_voting';

	/*
	* 	Login View
	*/
	public function login()
	{
		return view('auth.login');
	}

	/*
	* 	Login Process
	*/
	public function loginProcess(Request $request)
	{
		date_default_timezone_set('Asia/Jakarta');

		try {

			$this->validate($request, [
				'email' => 'required|max:225',
				'password' => 'required'
			]);

			$where_admin = [
				'email' => $request->email,
				'password' => $request->password,
				'level_id' => 1
			];

			$where_users = [
				'email' => $request->email,
				'password' => $request->password,
				'level_id' => 2
			];

			if (Auth::guard('user')->attempt($where_users)) {

				// Data status dan updated_at akan terupdate
				DB::table($this->table)->where('email', $request->email)->update(array('last_login' => date("Y-m-d"), 'status' => 'aktif'));
				return redirect()->intended('/users');
			} elseif (Auth::guard('user')->attempt($where_admin)) {
				
				// Data status dan updated_at akan terupdate
				DB::table($this->table)->where('email', $request->email)->update(array('last_login' => date("Y-m-d"), 'status' => 'aktif'));
				
				return redirect('/admin');
			} else {
				
				return redirect('/login')->with('gagal', 'Login Failed !');
			}

		} catch (Exception $e) {
			
			return redirect('/login')->with('gagal', 'Login Failed !');
		}
	}

	/*
	* 	Register View
	*/
	public function register()
	{
		return view('auth.register');
	}

	/*
		Register Process
	*/
		public function registerProcess(Request $request)
		{
			date_default_timezone_set('Asia/Jakarta');
			
			$request->validate( 
				[
					'username' => 'required|max:225',
					'email' => 'required|unique:users_voting|max:255',
					'password' => 'required'
				],
				[	
					'email:unique' => 'Upsss Account is ready please login'
				]
			);

			$register = new Users;
			$register->username = $request->username;
			$register->email = $request->email;
			$register->password = Hash::make($request->password);
			$register->level_id = 2;
			$register->status = 'tidak_aktif';
			$register->last_login = date("Y-m-d");
			$register->save();

			return redirect('/login');
		}

	/*
		View Reset Password
	*/
		public function lupaPassword()
		{
			return view('auth.lupa_password');
		}

	/*
		Check Email Reset Password Process
	*/
		public function lupaPasswordProcess(Request $request)
		{
			try {

				$this->validate($request, [
					'email' => 'required' 
				]);

				$checkUser = Users::where('email', $request->email)->first();

				if ($checkUser) {

					$emailInput = $request->email;

					$password_reset = array(
						'email' => $emailInput,
						'token' => Str::random(60),
						'created_at' => Carbon::now() 
					);

					DB::table('reset_password')->insert($password_reset);

					$reset = DB::table('reset_password')->where('email', $emailInput)->first();

					$token = $reset->token;
					$email = $reset->email;

			 		// Mail::to($email)->send(new ResetPassword($reset));
			 		// Queue Send Email Handle
					dispatch(new SendEmailJob($reset));

					Session::flash('sukses', 'Berhasil Mengirim Token Email, Silahkan Cek Email !');
					return redirect()->back();
				} else {

					Session::flash('gagal', 'Gagal ! Pastikan Email Anda Terdaftar !');
					return redirect()->back();
				}


			} catch (Exception $e) {

				echo "gagal";	
			}
		}

	/*
		View Reset By Token
	*/
		public function lupaPasswordToken($token)
		{
			$tokenData = DB::table('reset_password')->where('token', $token)->first();

			if ( !$tokenData ){

				Session::flash('invalid_token', 'Invalid Token !');
				return redirect('/reset-password');
			}else {

				return view('auth.reset_password_token', compact('tokenData'));
			}

		}

	/*
		Process Verify Password
	*/
		public function lupaPasswordTokenVerifyProcess(Request $request, $token)
		{
			try {

				$this->validate($request, [
					'password_old' => 'required|string',
					'password_new' => 'required|string',
				// 'password_confirmation' => 'required|same:password_new'
				]);

				$tokenData = DB::table('reset_password')->where('token', $token)->first();

				$user = Users::where('email', $tokenData->email)->first();
				if ($user) {

					$user->password = Hash::make($request->password_new);
					$user->update();

				DB::table('reset_password')->where('email', $user->email)->delete(); // Jika user sudah memasukan password dan berhasil token akan terhapus
				
				Session::flash('sukses_verify', 'Password Berhasil Di Update !');
				return redirect('/login'); // Redirect ke page home jika berhasil

			} else {
				// return redirect('/reset-pw' . $tokenData->token);  
				Session::flash('gagal_verify', 'Password Gagal Di Update !');
				return redirect('/login'); // Redirect ke page home jika berhasil
			}

		} catch (Exception $e) {

			echo "gagal";
		}
	}

	/*
	* 	Logout Process
	*/
	public function Logout()
	{
		$id_users = Auth::guard('user')->user()->id_users;
		$logout = DB::table($this->table)->where('id_users', $id_users)->update(['status' => 'tidak_aktif']);

		if ($logout && Auth::guard('user')->check()) {
			Auth::guard('user')->logout();
			return redirect('/login');
		}
		
		return redirect('/login');
		
	}

	// 29081997	

}

?>