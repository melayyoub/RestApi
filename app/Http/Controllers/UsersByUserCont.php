<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use Illuminate\Support\Facades\DB;
use App\Uploads;
use App\Comments;
use App\Profiles;
use App\UsersByUser;
use App\Rest;
use App\User;
use App\restTablesCont;
use Session;
use Input;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersByUserCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = DB::getSchemaBuilder()->getColumnListing('users');
        $usersList = DB::table('users_by_users')->where('uid', Auth::user()->id);
        $numbers = '1,2,3,4,5,6,6,7,8,98,12,21,2';
        $req = '';
        $requests = [];

        return view('users.index')->with([
            'usersList' => $usersList,
            'numbers' => $numbers,
            'col' => $columns,
            'req' => $req,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $columns = DB::getSchemaBuilder()->getColumnListing('users');
        return view('users.create')->with([
            'col' => $columns,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // create the user first
         $user = new User;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->level = 3;
        $user->role = 2;
        $user->industry = $request->industry;
        $user->job_title = $request->job_title;
        $user->api_token = $user->generateToken();
        $user->api_id = $user->generateToken();
        $user->api_only = 1;
        $user->save();


        $col = DB::getSchemaBuilder()->getColumnListing('users_by_users');
        $user2 = new UsersByUser;
        $user2->uid = Auth::user()->id;
        $user2->firstname = $user->firstname;
        $user2->lastname = $user->lastname;
        $user2->api_id = $user->api_id;
        $user2->user = $user->id;
        $user2->save();



        // create the user profile
        $prof = new Profiles;
        $prof->uid = $user->id;
        $prof->picture = 'img/profileM.png';
        $prof->save();

        Session::flash('Success', 'User Created!');
        return redirect::back();
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
}
