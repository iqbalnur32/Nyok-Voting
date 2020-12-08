<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use App\Models\CreateVoting;
use App\Models\MultiVote;
use App\Models\JawabanMulti;
use App\Models\CategoryVoting as category;
use App\Models\JawabanVoting as jawaban;
use App\Models\Users;
use DB;
use Str;
use Auth;
use Session;

class VotingController extends Controller
{

    private function getRand($length)
    {
        $result = '';
        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }
        return $result;
    }

    public function searchIDVote(Request $request)
    {
        /*$message = [
            'required' => 'ID Harus Di Isi',
            'min' => ':attribute harus diisi minimal :min karakter !'
        ];

        $this->validate($request, [
            'id_voting' => 'required|string|min:5',
        ], $message);*/

        $data = CreateVoting::where('id_voting', $request->input('id_voting'))->first();
        $multi = MultiVote::where('id_multi', $request->input('id_voting'))->first(); 

        if ($data) {
            return response()->json(['code' => 200, 'status' => 'vote_personal' ,'data' => $data]);
        } elseif($multi) {
            return response()->json(['code' => 200, 'status' => 'vote_multi' ,'data_multi' => $multi]);
        } else {
            return response()->json(['code' => 401, 'erorr' => 'Data Tidak Ditemukan']);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = category::all();
        $voting = CreateVoting::with('category_voting')->where('create_voting.id_users', Auth::guard('user')->user()->id_users)->get();

        // return $voting; die();
        return view('users.voting.v_voting', compact('category', 'voting'));
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
        $date = date('Y-m-d H:i:s');
        
        $avatar = Str::random(9);
        $request->file('img')->move(storage_path('images'), $avatar);

        $create_voting = array(
            'id_voting' => $this->getRand(10), 
            'id_users' => Auth::guard('user')->user()->id_users,
            'id_category' => $request->id_category,
            'title' => $request->title,
            'img' => $avatar,
            'description' => $request->description,
            'created_at' => $date,
            'updated_at' => $date
        );

        CreateVoting::insert($create_voting);
        return redirect()->back()->with('success', 'Berhasil Menambahkan Voting');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Detail Jawaban
        $detail_voting = CreateVoting::with('category_voting', 'jawaban_voting')->findOrFail($id);

        // Jawaban Voting
        $jawaban_voting = jawaban::where('id_voting', $id)->get();

        return view('users.voting.v_detail_voting', compact('detail_voting', 'jawaban_voting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = CreateVoting::where('id_voting', $id)->first();
        $data_jawaban = jawaban::where('id_voting', $id)->first();

        if (storage_path('images/' . $data->img)) {
            unlink(storage_path('images/' . $data->img));

            if ($data_jawaban === null) {

                echo "null";
                // Session::flash('warning_delete', 'Vote Jawaban Kosong');
                // return redirect('users/voting');
            } 

            $data->delete();
            $data_jawaban->delete();
            
            Session::flash('success_delete', 'Vote Jawaban Kosong');
            return redirect('users/voting');

        } else {
            echo "gagal";
        }


    }

    // Vote Process 
    public function votingProcess(Request $request, $id_voting)
    {
        try {

            $this->validate($request, [
                'nama_lengkap' => 'required|min:5|max:20',
                'jawaban' => 'required',
                'description' => 'required'
            ]); 

            $process_vote = array(
                'id_voting' => $id_voting,
                'id_users' => Auth::guard('user')->user()->id_users,
                'nama_lengkap' => $request->nama_lengkap,
                'jawaban' => $request->jawaban,
                'description' => $request->description
            ); 

            Jawaban::insert($process_vote);

            Session::flash('sukses', 'Berhasil Melakukan Vote');
            return redirect('/users');

        } catch (Exception $e) {

            Session::flash('gagal', 'Maaf Anda Gagal Melakukan Vote');
            return redirect('/users');
        }
    }

    // Vote View Berdasarkan ID Vote
    public function votingGetSearch($id_voting)
    {
        $voting_search = CreateVoting::with('category_voting')->where('create_voting.id_voting', $id_voting)->first();

        // Count Users Vote Supaya Tidak Vote Beberapa Kali
        $count_users_vote = jawaban::with('jawaban_voting')->where('jawaban_voting.id_users', Auth::guard('user')->user()->id_users)->where('jawaban_voting.id_voting', $id_voting)->count();

        return view('users.v_vote', compact('voting_search', 'count_users_vote'));
    }

    // Vote Multi
    public function MultiVote($id_voting)
    {
        $voting_multi = MultiVote::with('category_voting')->where('id_multi', $id_voting)->first();

        $count_voting_multi = MultiVote::with('category_voting')->where('id_users', Auth::guard('user')->user()->id_users)->where('id_multi', $id_voting)->count();
        
        // print_r($count_voting_multi); die();

        return view('users.v_voting_multi', compact('voting_multi', 'count_voting_multi'));
    }

    public function MultiVoteProcess(Request $request)
    {
        try {
            $jwbn_multi = new JawabanMulti();
            $jwbn_multi->id_multi = $request->id_multi;
            $jwbn_multi->id_users = Auth::guard('user')->user()->id_users;
            $jwbn_multi->point = $request->pilihan;
            $jwbn_multi->save();

            return redirect()->back();

        } catch (Exception $e) {

            echo "error";
        }
    }

    public function MultiVoteDelete($id_multi)
    {
        $delete_multi = MultiVote::find($id_multi);

        /* Delete Image */
        $labels = [];
        foreach (json_decode($delete_multi->candidate_img1) as $key => $value) {
            $image_path = public_path().'/images/';
            $labels[] = [
                'img' => unlink($image_path.$value)
            ];
        }

        if (is_array($labels)) {
            $delete_multi->delete();
            return redirect()->back();
        }else{
            print_r('gagal');
        }
    }

    // Buat Ngelihat File Materi Nya / Get File Materi Nya 
    public function fileMateri($file)
    {
       $avatar_path = storage_path('images') . '/' . $file;

       if (file_exists($avatar_path)) {
        $file = file_get_contents($avatar_path);
        return response($file, 200)->header('Content-Type', 'image/jpeg');
    }

        return "Data File Tidak Di Temukan";
    }

    // Static Vote
    public function StaticVoting($id_voting)
    {

        $static_data = DB::table('jawaban_voting')->select(['jawaban',  DB::raw('count(*) as value')])
        ->join('create_voting', 'jawaban_voting.id_voting', '=', 'create_voting.id_voting')
        ->groupBy('jawaban')
        ->where('jawaban_voting.id_voting', $id_voting)
        ->get();

        // print_r($static_data);  die();
        return response()->json([
            'code' => 200,
            'opsi' => ['setuju', 'tidak_setuju'],
            'data' => $static_data
        ]);

            // https://mazinahmed.net/blog/hacking-zoom/
            // https://www.youtube.com/watch?v=QkOpUN-S3Y0&feature=youtu.be
    }
}
