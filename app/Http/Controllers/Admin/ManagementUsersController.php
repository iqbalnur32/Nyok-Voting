<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Users;
use DB;

class ManagementUsersController extends Controller
{
    public function rules()
    {
        return [
            'username' => 'required|string|min:5',
            'email' => 'required|email|unique:users_voting',
            'password' => 'required',
            'level_id' => 'required'
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Users::join('users_level', 'users_voting.level_id', '=', 'users_level.id_level')->get();
        $level = DB::table('users_level')->get();

        return view('admin.management-user.v_index', compact('users', 'level'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        
        try {

            $this->validate($request, $this->rules());
            
            Users::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'level_id' => $request->level_id,
                'last_login' => date('Y-m-d'),
                'status' => 'tidak_aktif',
            ]);

            return redirect()->back()->with('sukses', 'Success Add Data !');

        } catch (Exception $e) {

            return redirect()->back()->with('gagal', 'Failed Add Data !');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            
            if ($request->input('password')) {
                
                $update = array(
                  'username' => $request->username,
                  'email' => $request->email,
                  'password' => Hash::make($request->password),
                  'level_id' => $request->level_id,
                  'status' => 'tidak_aktif'
                );

                Users::find($id)->update($update);

                return response()->json([
                    'status' => 200,
                    'msg' => 'berhasil pake password'
                ], 200);

            }else{

                $update = array(
                  'username' => $request->username,
                  'email' => $request->email,
                  'password' => Hash::make($request->password),
                  'level_id' => $request->level_id,
                  'status' => 'tidak_aktif'
                );

                Users::find($id)->update($update);

                return response()->json([
                    'status' => 200,
                    'msg' => 'berhasil tanpa pake password'
                ], 200);
            }


        } catch (Exception $e) {
            
            return response()->json([
                'status' => 401,
                'msg' => 'berhasil tanpa pake password'
            ], 401);  
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Users::find($id);

        if ($delete === null) {
            return response()->json([
                'status' => 401,
                'msg' => 'failed delete'
            ], 401);  
        }
        
        $delete->delete();
        return redirect()->back();  

    }
}
