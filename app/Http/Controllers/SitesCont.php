<?php

namespace App\Http\Controllers;

use App\User;
use App\Settings;
use App\Admins;
use App\Sites;
use Illuminate\Http\Request;
use App\Posts;
use App\Tags;
use Illuminate\Support\Facades\DB;
use App\Uploads;
use App\Comments;
use App\Profiles;
use Session;
use Illuminate\Support\Facades\Auth;

class SitesCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = Sites::orderby('id', 'desc')->paginate(10);
            return view('admin.sites.index')->with([
                'sites' => $sites,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = $this->tags();
        $user = User::find(Auth::user()->id);
        return view('site.create')->with([
            'user' => $user,
            'tags' => $tags
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
         $UploadsCont = new Uploads;
        // validate the data
        $this->validate($request, array(
            'title' => 'required|max:255',
            'body' => 'required',
            'uid' => 'required',
            'image' => 'max:2000|mimes:jpg,png,gif,jpeg,svg',
            ));

        $slug = $this->create_slug($request->title);
        // check image file
        $destinationPath = 'uploads/files/' . $request->uid;
        if(!empty($request->file('image'))):
        
        $file = $request->file('image');
        $checkFile = Uploads::where('ftype', $file->getClientOriginalName());
        if ($checkFile->count() > 0) {
            $file = $checkFile->first();
            $saveFile = $file->file;
            }else{
              
              //Move Uploaded File
                  $file->move($destinationPath, $file->getClientOriginalName());
                  $saveFile = $destinationPath . '/' . $file->getClientOriginalName();

             // start saving the file
                $fileDB = new Uploads;
                $fileDB->uid = $request->uid;
                $fileDB->nid = null;
                $fileDB->ntype = 'site';
                $fileDB->file = $saveFile;
                $fileDB->ftype = $file->getClientOriginalName();
                $fileDB->save();
                $saveFile = $fileDB->file;
              }

          else:
            $saveFile = 'img/siteImage.png';
          endif;

    // check image file
        $files = $request->file('files');
        $saveFilesA = '';
     
        if(!empty($request->file('files'))):
         foreach ($files as $filea) {
            $fileDes = $destinationPath . '/' . $filea->getClientOriginalName();
            $checkFile = Uploads::where('file', $fileDes);
                if ($checkFile->count() > 0) {
                    $filea = $checkFile->first();
                    $saveFilesA = '1';
                    }else{
                  //Move Uploaded File
                      $filea->move($destinationPath, $filea->getClientOriginalName());
                      $saveFile = $destinationPath . '/' . $filea->getClientOriginalName();
                 // start saving the file
                    $fileDB = new Uploads;
                    $fileDB->uid = $request->uid;
                    $fileDB->nid = null;
                    $fileDB->ntype = 'site';
                    $fileDB->file = $saveFile;
                    $fileDB->ftype = $filea->getClientOriginalName();
                    $fileDB->save();
                    $saveFilesA = '1';
                  }
              }
          endif;
        // store
        $site = new Sites;
        $site->url = $request->url;
        $site->title = $request->title;
        $site->path = $slug;
        $site->body = $request->body;
        $site->uid = $request->uid;
        $site->files = $saveFilesA;
        $site->image = $saveFile;

        $site->save();


         // save categories and tags
        // remove and add in case of TAGS
        if (!empty($request->tags)) {
             DB::table('tags')->where(['nid'=> $site->id, 'type'=>'site'])->delete();
            foreach ($request->tags as $key => $value) {
                $newTag = new Tags;
                $newTag->type = 'site';
                $newTag->tag = $value;
                $newTag->nid = $site->id;
                $newTag->uid = $request->uid;
                $newTag->save();
            }
        }else{
            DB::table('tags')->where(['nid'=> $site->id, 'type'=>'site'])->delete();
        }

        
        // now update the file node id
        if(!empty($request->file('image'))):
            DB::table('uploads')->where([
                'uid' => $request->uid,
                'file' => $saveFile
            ])->whereNull('nid')->update(
                ['nid' => $site->id]
            );
        endif;

       // update the files list to connect with the site
         if(!empty($files)):
            foreach ($files as $key) {
                $checkFile = $destinationPath . '/' . $key->getClientOriginalName();
                // now update the file node id
                DB::table('uploads')->where([
                        'uid' => $request->uid,
                        'file' => $checkFile
                    ])->whereNull('nid')->update(
                        ['nid' => $site->id]
                    );
            }
         endif;
        // add views record for this site
        DB::table('views')->insert(
                ['nid' => $site->id, 'views' => 0]
            );
        Session::flash('Success', 'site created successfully!');
        // redirect

        return redirect()->route('site.show', $site->id);
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
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tags($type = false)
    {
      if ($type) {
        $tags = DB::table('tags')->where('type', $type)->get();
        $final = [];
        foreach ($tags as $key) {
            if(!in_array($key->tag, $final)){
                $final[$key->tag] = $key->tag;
                }        
        }
        return $final;
      }else{
        $tags = DB::table('tags')->get();
        $final = [];
        foreach ($tags as $key) {
            if(!in_array($key->tag, $final)){
                $final[$key->tag] = $key->tag;
                }        
        }
        return $final;
      }
        
    }
    

    public function create_slug($string = false)
    {

        // if no string
        if($string == null){
            return false;
        }

            $string = preg_replace( '/[«»""!?,.!@£$%^&*{};:()]+/', '', $string );
            $string = strtolower($string);
            $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

        return $slug;
     }
}
