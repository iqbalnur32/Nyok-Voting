<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Str;
use Auth;
use Session;
use App\File;
use App\Models\MultiVote;
use App\Models\CategoryVoting as category;
use App\Models\JawabanVoting as jawaban;
use App\Models\Users;

class VotingMultiController extends Controller
{   

    private function getRand($length=10)
    {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    /*
    * Rules Validate
    */
    private function rules_multi() {
        return [
            'id_category' => 'required',
            'title' => 'required|string|min:5|max:255',
            'description' => 'required|string|min:5|max:255',
            'candidate_img1' => 'required',
            'candidate_img1.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = category::all();
        $voting = MultiVote::with('category_voting')->where('id_users', Auth::guard('user')->user()->id_users)->get();

        return view('users.voting.v_voting_multi', compact('category', 'voting'));
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

        try {

            $this->validate($request, $this->rules_multi());

            $uuid = $this->getRand(12);
            
            $data = array();
            if ($request->hasFile('candidate_img1')) {

                $files = $request->file('candidate_img1');

                foreach ($files as $file => $key) {

                    // Check apakah file nya valid 
                    if ($key->isValid()) {

                        // path data image
                        $filename = $key->getClientOriginalName();
                        $key->move(public_path() . '/images', $filename);
                        $data[] = $filename;
                        
                    }
                }

                $multi_create = array(
                    'id_multi' => $uuid, 
                    'id_users' => Auth::guard('user')->user()->id_users, 
                    'title' => $request->title, 
                    'description' => $request->description, 
                    'id_category' => $request->id_category, 
                    'candidate_name1' => json_encode($request['candidate_name1']),  
                    'candidate_img1' => json_encode($data), 
                    'created_at' => $date, 
                    'updated_at' => $date, 
                );

                // dd($multi_create); die();

                MultiVote::insert($multi_create);
                return redirect()->back()->with('success_multi', 'Sukses Menambahkan Data');

            } else {

                return redirect()->back()->with('gagal_multi', 'Gagal Menambahkan Data');
            }


        } catch (Exception $e) {

            return redirect()->back()->with('gagal_multi', 'Gagal Menambahkan Data');
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
        //
    }

    public function fileMulti()
    {
        $avatar_path = storage_path('images') . '/' . $file;

        if (file_exists($avatar_path)) {
            $file = file_get_contents($avatar_path);
            return response($file, 200)->header('Content-Type', 'image/jpeg');
        }

        return "Data File Tidak Di Temukan";
    }
}

// Multiple file upload tutorial
// https://laravel.web.id/multiple-upload-file-menggunakan-filesystem-di-laravel/
// https://medium.com/dot-intern/create-multiple-upload-images-laravel-plus-displaying-on-view-6074aca289d
