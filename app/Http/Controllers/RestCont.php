<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use Illuminate\Support\Facades\DB;
use App\Uploads;
use App\Comments;
use App\Profiles;
use App\Rest;
use App\RestRequests;
use App\restTablesCont;
use Session;
use Input;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RestCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = DB::table('rest_tables_conts')->where('api_id', Auth::user()->api_id);
        $numbers = '';
        $req = '';
        $requests = [];

        return view('rest.index')->with([
            'tables' => $tables,
            'numbers' => $numbers,
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
        return view('rest.create');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function testCalls(Request $req)
    {
        $tbs = [];
        $results = '';
        $table = $req->table;
        $method = $req->method;
        $q = $req->q;
        if (!empty($method)) {
           
        // check results if request is not null           
            $host = env('APP_URL');
            $url = $host . '/api/ddk/'. $table . '?' . $q;
            $results =  $this->testRequest($url, $method, $q);
        }

        $tables = DB::table('rest_tables_conts')->where('api_id', Auth::user()->api_id)->get();
        foreach ($tables as $key) {
           $tbs = [$key->table=>$key->table];
        }
        return view('rest.test')->with([
            'tables' => $tbs,
            'results' => $results,
        ]);
    }
    // test request using curl 
    public function testRequest($url, $method, $q)
    {
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_CUSTOMREQUEST => $method,
              CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Authorization: Bearer ".Auth::user()->api_token,
                "Cache-Control: no-cache",
                "Content-Type: application/json",
              ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            
            if ($err) {
               return $results = "cURL Error #:" . $err;
            } else{
               return $results = '<pre>' . $response . '<br> URL '. $url;
            }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $uid = Auth::user()->id;
        $req = $request;
        // check if table exist reutrn back
        if (Schema::hasTable($uid . '_' . $request->title)) {
            Session::flash('Success', 'Table exist, try another name!');
            return redirect::back();
            
        }

            Schema::create($uid . '_' . $request->title, function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();
            });
            $i = 0;
            // create the fields now after table
            while(isset($req->fieldname[$i])):
                $name = $req->fieldname[$i];
                $t = $req->typeis[$i];
                $null = $req->fieldnull[$i];
                    if ($null == 'yes') {

                        if (strtolower($t) == 'integer') {
                        Schema::table($uid . '_' . $request->title, function($table) use ($i) {
                                $table->integer(str_replace('_', ' ',request('fieldname')[$i]))->nullable();
                         });
                        }elseif (strtolower($t) == 'text') {
                             Schema::table($uid . '_' . $request->title, function($table) use ($i) {
                                $table->text(str_replace('_', ' ',request('fieldname')[$i]))->nullable();
                                });
                            }elseif (strtolower($t) == 'string') {
                                 Schema::table($uid . '_' . $request->title, function($table) use ($i) {
                                    $table->string(str_replace('_', ' ',request('fieldname')[$i]))->nullable();
                                });
                            }
                             
                    }else{
                         if (strtolower($t) == 'integer') {
                             Schema::table($uid . '_' . $request->title, function($table) use ($i) {
                                $table->integer(str_replace('_', ' ',request('fieldname')[$i]))->default((request('fielddefault['.$i.']') ? request('fielddefault['.$i.']') : '0'));
                            });
                        }elseif (strtolower($t) == 'text') {
                             Schema::table($uid . '_' . $request->title, function($table) use ($i) {
                                $table->text(str_replace('_', ' ',request('fieldname')[$i]))->default((request('fielddefault['.$i.']') ? request('fielddefault['.$i.']') : '0'));
                                });
                            }elseif (strtolower($t) == 'string') {
                                 Schema::table($uid . '_' . $request->title, function($table) use ($i) {
                                    $table->string(str_replace('_', ' ',request('fieldname')[$i]))->default((request('fielddefault['.$i.']') ? request('fielddefault['.$i.']') : '0'));
                                });
                            }
                    }  
                $i++;
              endwhile;
          
        if($request):
            $new = new restTablesCont;
            $new->body = $request->body;
            $new->table = $uid . '_' . $request->title;
            $new->uid = $uid;
            $new->api_id = Auth::user()->api_id;
            $new->save();

        endif;
        $tables = DB::table('rest_tables_conts')->where('api_id', Auth::user()->api_id);
        Session::flash('Success','table created!');
        return view('rest.index')->with([
            'tables' => $tables,
            'req' => '',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($table)
    {
        $tables = DB::table('rest_tables_conts')->where('api_id', Auth::user()->api_id)->where('table', $table)->first();
        $numbers = '1,2,3,4,5,6,6,7,8,98,12,21,2';
        $usList = [];
        $userslist = [];
        $allowedUsers = DB::table('users_by_users')->where('uid', Auth::user()->id)->get();
        if ($allowedUsers) {
            foreach ($allowedUsers as $key) {
                $userList = DB::table('rest_tables_conts')->where('api_id', $key->api_id)->where('table', $table)->first();
                if (!empty($userList)) {
                   $usList[$key->id] = $key->id;
                }
                
            }
        }
        $userslist=['None'];
        foreach ($allowedUsers as $key) {
             $userslist[$key->id] = $key->id;
        }
        $req = '';
        $requests = [];
        $columns = DB::getSchemaBuilder()->getColumnListing($table);
        $info = DB::table($tables->table)->get();
        return view('rest.show')->with([
            'table' => $info,
            'tables' => $tables,
            'columns' => $columns,
            'userlist' => $userslist,
            'allowedUsers' => $usList,
        ]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addFields(Request $request)
    {
        $i=0;
        $table = $request->tableIs;
        $req = $request;
        while(isset($req->fieldname[$i])):
                $name = $req->fieldname[$i];
                $t = $req->typeis[$i];
                $null = $req->fieldnull[$i];
                    if ($null == 'yes') {
                        if (strtolower($t) == 'integer') {
                        Schema::table($table, function($table) use ($i) {
                                $table->integer(str_replace('_', ' ',request('fieldname')[$i]))->nullable();
                         });
                        }elseif (strtolower($t) == 'text') {
                             Schema::table($table, function($table) use ($i) {
                                $table->text(str_replace('_', ' ',request('fieldname')[$i]))->nullable();
                                });
                            }elseif (strtolower($t) == 'string') {
                                 Schema::table($table, function($table) use ($i) {
                                    $table->string(str_replace('_', ' ',request('fieldname')[$i]))->nullable();
                                });
                            }
                             
                    }else{
                         if (strtolower($t) == 'integer') {
                             Schema::table($table, function($table) use ($i) {
                                $table->integer(str_replace('_', ' ',request('fieldname')[$i]))->default((request('fielddefault['.$i.']') ? request('fielddefault['.$i.']') : '0'));
                            });
                        }elseif (strtolower($t) == 'text') {
                             Schema::table($table, function($table) use ($i) {
                                $table->text(str_replace('_', ' ',request('fieldname')[$i]))->default((request('fielddefault['.$i.']') ? request('fielddefault['.$i.']') : '0'));
                                });
                            }elseif (strtolower($t) == 'string') {
                                 Schema::table($table, function($table) use ($i) {
                                    $table->string(str_replace('_', ' ',request('fieldname')[$i]))->default((request('fielddefault['.$i.']') ? request('fielddefault['.$i.']') : '0'));
                                });
                            }
                    }  
                $i++;
              endwhile;

        $usersList = $request->input('users');
            if (!empty($usersList) AND count($usersList) > 0) {
                foreach ($usersList as $key => $value) {
                    if ($value !== '0') {
                        $userL = DB::table('users_by_users')->where('id', (int)$value)->first();
                        $check =  DB::table('rest_tables_conts')->where('api_id', $userL->api_id)->first();
                        if ($check) {
                           
                        }else{
                            $new = new restTablesCont;
                            $new->table = $table;
                            $new->uid = $value;
                            $new->body = 'Added by: ' . Auth::user()->firstname;
                            $new->api_id = $userL->api_id;
                            $new->save();
                        }

                        
                    }
                    
                }
                if (in_array('0', $usersList)) {
                   restTablesCont::where('uid', '!=' , Auth::user()->id)->where('table', $table)->delete();
                }
            }
            
        return redirect::back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function insert(Request $request)
    {
        $table = $request->tableIs;
        $col = DB::getSchemaBuilder()->getColumnListing($table);
        $data = [];
        foreach ($col as $key => $value) {
            if ($value !== 'id' AND $value !== 'created_at' AND $value !== 'updated_at' AND $value !== 'tableIs') {
                $data[$value] = $request->$value;
            }
        }
        
        $data['created_at'] = \DB::raw('CURRENT_TIMESTAMP');
        $data['updated_at'] = \DB::raw('CURRENT_TIMESTAMP');
        $new = DB::table($table)->insert($data);
        Session::flash('Success', 'Data Added!');
        return redirect::back()->with(['results' => $request->users]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delROw(Request $request)
    {
        $table = $request->tableIs;
        DB::table($table)->delete($request->id);
        Session::flash('Success', 'Data Deleted!');
        return redirect::back()->with([]);
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
        $res = restTablesCont::find($id);
        Schema::dropIfExists($res->table);
        $res = restTablesCont::destroy($id);
         Session::flash('Success','table removed!');
        return redirect::back();
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delTable($table)
    {
        // $res = restTablesCont::where('table', $table);
        Schema::dropIfExists($table);
        $res = restTablesCont::where('table', $table)->destroy();
         Session::flash('Success','table removed!');
        return redirect::back();
    }
}
