<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Users;
use App\Models\CategoryVoting as Category;
use App\Models\JawabanVoting;
use App\Models\CreateVoting as Created;
use Auth;
use Str;
use DB;
use Session;

class AdminController extends Controller
{
	
	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	private function getRand($length)
	{
		$result = '';

		for($i = 0; $i < $length; $i++) {
			$result .= mt_rand(0, 9);
		}

		return $result;
	}

	private function rules_category(){
		return [
			'name_category' => 'required|string|min:5|max:255',
			'description' => 'required|string|min:5|max:255'
		];
	}

	private function rules_created_vote() {
		return [
			'id_users' => 'required',
			'id_category' => 'required',
			'title' => 'required',
			'img' => 'required',
			'description' => 'required|string'
		];
	}

	public function home()
	{
		return view('admin.index');
	}

	public function monitoringKeseluruhan()
	{
		return view('admin.monitoring.v_keseluruhan');
	}

	/*
	* Master Category Vote Management 
	*/
	public function Category()
	{
		$category = Category::all();

		return view('admin.category_master.v_category', compact('category')); 
	}

	public function CategoryProcess(Request $request)
	{
		try {
			
			$this->validate($request, $this->rules_category());

			$category = new Category;
			$category->name_category = $request->name_category;
			$category->description = $request->description;
			$category->save();

			return redirect()->back()->with('sukses', 'Penambahan Data Berhasil');

		} catch (Exception $e) {
			
			return redirect()->back()->with('gagal', 'Penambahan Data Gagal');
		}
	}

	public function CategoryEdit(Request $request, $id_category)
	{
		try {
			
			$category = Category::find($id_category);
			$category->name_category = $request->name_category;
			$category->description = $request->description;
			$category->update();

			return response()->json(['code' => 200, 'data' => $category]);

		} catch (Exception $e) {
			
			return response()->json(['code' => 401, 'erorr' => 'error failed update']);
		}
	}

	public function CategoryDelete($id_category)
	{
		$categoryDelete = Category::find($id_category);
		$categoryDelete->delete();

		if ($categoryDelete === null) {
			
			return response()->json(['code' => 401, 'erorr' => 'error failed update']);
		}

		return redirect()->back();
	}

	/*
	* Created Vote Management 
	*/
	public function CraetedVote()
	{
		$created = Created::with('category_voting', 'users')->get();
		$users = Users::all();
		$category = Category::all();

		return view('admin.create_vote.v_creted_vote', compact('created', 'users', 'category'));
	}

	public function CraetedVoteProcess(Request $request)
	{
		date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d H:i:s');
		try {

			$this->validate($request, $this->rules_created_vote());

			$avatar = Str::random(9);
			$request->file('img')->move(storage_path('images'), $avatar);

			$create_voting = array(
				'id_voting' => $this->getRand(10),
				'id_users' => $request->id_users, 
				'id_category' => $request->id_category, 
				'title' => $request->title, 
				'img' => $avatar, 
				'description' => $request->description, 
				'created_at' => $date,
				'updated_at' => $date
			);

			Created::insert($create_voting);

			return redirect()->back()->with('sukses', 'Penambahan Data Berhasil');


		} catch (Exception $e) {
			
			return redirect()->back()->with('gagal', 'Penambahan Data Gagal');
		}
	}

	public function CraetedVoteEdit($id_voting)
	{
		try {
			
			$created_edit = Created::with('category_voting', 'users')->where('id_voting', $id_voting)->first();

			if ($created_edit === null) {
				
				return response()->json(['code' => 401, 'error' => 'error data null']);
			} 

			return response()->json(['code' => 200, 'data' => $created_edit]);

		} catch (Exception $e) {
			
			return response()->json(['code' => 401, 'error' => 'error data null']);
		}
	}

	public function CraetedVoteEditProcess(Request $request, $id_voting)
	{
		date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d H:i:s');
		try {
			
			if ($request->input('img')) {

				$avatar = Str::random(9);
				$request->file('img')->move(storage_path('images'), $avatar);

				$create_voting_edit = array(
					// 'id_voting' => $this->getRand(10),
					'id_users' => $request->id_users, 
					'id_category' => $request->id_category, 
					'title' => $request->title, 
					'img' => $avatar, 
					'description' => $request->description, 
					'created_at' => $date,
					'updated_at' => $date
				);

				Created::where('id_voting', $id_voting)->update($create_voting_edit);
				return response()->json(['code' => 200, 'data' => $create_voting_edit]);
			}else {

				$create_voting_edit = array(
					// 'id_voting' => $this->getRand(10),
					'id_users' => $request->id_users, 
					'id_category' => $request->id_category, 
					'title' => $request->title, 
					'description' => $request->description, 
					'created_at' => $date,
					'updated_at' => $date
				);

				Created::where('id_voting', $id_voting)->update($create_voting_edit);
				return response()->json(['code' => 200, 'data' => $create_voting_edit]);
			}

		} catch (Exception $e) {
			
			return response()->json(['code' => 401, 'error' => 'error data null']);
			// echo "gagal";
		}
	}
}

?>