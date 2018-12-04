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
use Session;
use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\LogCont as Logsave;
use Auth;

class RestApiCont extends Controller
{
    public function index(Request $req, $table)
    {
        $uid = Auth::user()->api_id;
        $checkTable = DB::table('rest_tables_conts')->where(['api_id'=> $uid, 'table'=>$table])->first();
        if (!$checkTable) {
            return response()->json(['error' => 'Not authorized.'],403);
        }
        $col = DB::getSchemaBuilder()->getColumnListing($table);
        $data = [];
        foreach ($col as $key => $value) {
                if ($req->$value !== null) {
                    $data[$value] = $req->$value;
                }
        }
        $list = DB::table($table)->where($data)->get();
        $this->storeReuqest('Get all data from ' . $table, $table, '200');

        return response()->json($list, 200);
    }

    public function show(Request $req, $table, $id)
    {
        $uid = Auth::user()->api_id;
        $checkTable = DB::table('rest_tables_conts')->where(['api_id'=> $uid, 'table'=>$table])->first();
        if (!$checkTable) {
            return response()->json(['error' => 'Not authorized.'],403);
        }
        $item = DB::table($table)->where('id', $id)->first();

        // store the request
        $this->storeReuqest('Get ' . $id, $table, '200');

        return response()->json($item, 201);
    }

    public function store(Request $request, $table)
    {
        $col = DB::getSchemaBuilder()->getColumnListing($table);
        $checkTable = DB::table('rest_tables_conts')->where(['api_id'=> Auth::user()->api_id, 'table'=>$table])->first();
        // if not asking for fields start building the fields request
           $data = [];
            foreach ($col as $key => $value) {
                if ($value !== 'id' AND $value !== 'created_at' AND $value !== 'updated_at' AND $value !== 'tableIs') {
                    $data[$value] = $request->$value;
                }
            }
        // convert request to array
        

        if (!$checkTable) {
            return response()->json(['error' => 'Not authorized.'],403);
        }

        // return fields
        if ($request->fields == 1) {

            // store the request
            $this->storeReuqest('Get = ' . json_encode($data), $table, 'Columns returned!');

            return response()->json($col, 200);
        }

        

        // check if the request has at least one field
        if (count($data) >= 1) {
            $data['created_at'] = \DB::raw('CURRENT_TIMESTAMP');
            $data['updated_at'] = \DB::raw('CURRENT_TIMESTAMP');
            $new = DB::table($table)->insert($data);
            $uid = Auth::user()->api_id;
            
            // store the request
            $this->storeReuqest(json_encode($data), $table, 'Added!');

            return response()->json('Added!', 201);
        }

        // store the request
        $this->storeReuqest('Post = ' . json_encode($data), $table, 'Missing fields!');

        return response()->json('Missing fields!', 201);
            
        
    }

    public function update(Request $request, $table, $id)
    {
        $uid = Auth::user()->api_id;
        $col = DB::getSchemaBuilder()->getColumnListing($table);
        $checkTable = DB::table('rest_tables_conts')->where(['api_id'=> $uid, 'table'=>$table])->first();
        // if not asking for fields start building the fields request
           $data = [];
            foreach ($col as $key => $value) {
                if ($value !== 'id' AND $value !== 'created_at' AND $value !== 'updated_at' AND $value !== 'tableIs') {
                    $data[$value] = $request->$value;
                }
            }
        if (!$checkTable) {
            return response()->json(['error' => 'Not authorized.'],403);
        }
        $child = $data;
        $update = DB::table($table)->where('id', $id)->update($child);


        // store the request
        $this->storeReuqest('Put = ' . json_encode($data), $table, $id . ' updated successfully!');

        return response()->json($id . ' updated successfully!', 200);
    }

    public function delete($table, $id)
    {
        $uid = Auth::user()->api_id;
        $checkTable = DB::table('rest_tables_conts')->where(['api_id'=> $uid, 'table'=>$table])->first();
        if (!$checkTable) {
            return response()->json(['error' => 'Not authorized.'],403);
        }
        DB::table($table)->where('id', $id)->delete();


        // store the request
        $this->storeReuqest('Deleted ' . $id, $table, '200');

        return response()->json($id . ' deleted successfully!', 200);
    }
    // store all request under each user
    protected function storeReuqest($request, $table, $reponse)
    {
        $new = new RestRequests;
        $new->uid = Auth::user()->id;
        $new->api_id = Auth::user()->api_id;
        $new->table = $table;
        $new->body = $request;
        $new->response = $reponse;
        $new->save();
        return;
    }
}
