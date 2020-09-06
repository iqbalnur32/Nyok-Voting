<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JawabanVoting as Jawaban;
use App\Models\CreateVoting as Created;
use App\Models\Users;
use DB;

class ManagementJawabanController extends Controller
{
    private function rules_jawaban()
    {        
        return [
            'id_voting' => 'required',
            'id_users' => 'required',
            'nama_lengkap' => 'required',
            'jawaban' => 'required',
            'description' => 'required',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jawaban = Jawaban::with('jawaban_voting_users')->get();
        $id_vote = Created::all();
        $id_users = Users::all();

        return view('admin.jawaban_vote.v_jawaban_vote', compact('jawaban', 'id_vote' ,'id_users'));
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
        try {

            $this->validate($request, $this->rules_jawaban());

            $jawaban = new Jawaban;
            $jawaban->id_voting = $request->id_voting;
            $jawaban->id_users = $request->id_users;
            $jawaban->nama_lengkap = $request->nama_lengkap;
            $jawaban->jawaban = $request->jawaban;
            $jawaban->description = $request->description;
            $jawaban->save();

            return redirect()->back()->with('sukses', 'Berhasil Menambahkan Data');

        } catch (Exception $e) {

            return redirect()->back()->with('gagal', 'Gagal Menambahkan Data');
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
        $jawaban_edit = Jawaban::with('jawaban_voting_users')->find($id);

        if ($jawaban_edit === null) {

            return response()->json(['code' => 401, 'erorr' => 'error data null']);
        }
        
        return response()->json(['code' => 200, 'data' => $jawaban_edit]);
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
            $this->validate($request, $this->rules_jawaban());

            $jawaban = Jawaban::find($id);
            $jawaban->id_voting = $request->id_voting;
            $jawaban->id_users = $request->id_users;
            $jawaban->nama_lengkap = $request->nama_lengkap;
            $jawaban->jawaban = $request->jawaban;
            $jawaban->description = $request->description;
            $jawaban->update();

            return response()->json(['code' => 200, 'data' => $jawaban]);

        } catch (Exception $e) {
            
            return response()->json(['code' => 401, 'erorr' => 'error update data']);   
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
        $delete_jawaban = Jawaban::find($id);
        $delete_jawaban->delete();

        if ($delete_jawaban === null) {
            
            echo "gagal";
        }

        return redirect()->back();
    }
}
