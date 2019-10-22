<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use Illuminate\Support\Facades\DB;
use App\Uploads;
use App\Comments;
use App\Rest;
use App\RestApi;
use App\Profiles;
use App\RestRequests;
use App\UsersByUser;
use App\restTablesCont;
use Session;
use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\LogCont as Logsave;
use Auth;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tables = restTablesCont::where('uid', Auth::user()->id);
        $users = UsersByUser::where('uid', Auth::user()->id);
        $reqs = DB::table('rest_requests')->where('api_id', Auth::user()->api_id);

        // bigChart numbers
        $bigChart = [];
        $months =[];
        $reqGet1 = [0 => 0];
        $reqPost1 = [0 => 0];
        $reqPut1 = [0 => 0];
        $reqDelete1 = [0 => 0];
        $bigChartKeys = [];
        $tablesPer = "";
        
        if ($reqs) {
          $tb = [];
        foreach ($reqs->get() as $key ) {
            if (array_key_exists($key->table, $tb) !== false) {
               $tb[$key->table] =  $tb[$key->table] + 1;
            }else{
                $tb[$key->table] = 1;
            }
            $body = strtolower($key->body);
            if (strpos($body, 'get') !== false) {
                   $reqGet1[0] = $reqGet1[0]+ 1;
                }elseif (strpos($body, 'delete') !== false) {
                    $reqDelete1[0] = $reqDelete1[0] + 1;
                }elseif (strpos($body, 'put') !== false) {
                    $reqPut1[0] = $reqPut1[0] + 1;
                }elseif (strpos($body, 'post') !== false) {
                    $reqPost1[0] = $reqPost1[0]+ 1;
                }
                $st =  strtotime($key->created_at);
                $date = date('M-DD', $st);

                if (array_key_exists($date, $months) !== false) {
                    $months[$date] = $months[$date] + 1;
                }else{
                    $months[$date] = 1;
                }
                $date =false;
            }
               
            foreach ($months as $key => $value) {
                if (count($bigChart) < 30) {
                    $bigChart[] = $value;
                    $bigChartKeys[] = $key;
                }
                
            }
            $countTb =0;
            foreach ($tb as $key => $value) {
                if (count($countTb) < 10) {
                    $tablesPer .= "{name: '".$key."',y: " . $value . "},";
                    $countTb++;
                }
            }
        } 
        return view('pages.dashboard')->with([
            'requests' => $reqs,
            'users' => $users,
            'tables' => $tables,
            'bigChart' => $bigChart,
            'bigChartKeys' => $bigChartKeys,
            'reqGet' => $reqGet1,
            'reqPost'=> $reqPost1,
            'reqDel' => $reqDelete1,
            'reqPut' => $reqPut1,
            'tablesPer' => $tablesPer
        ]);
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
        //
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
