<?php

namespace App\Http\Controllers;

use App\Files;
use App\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminConts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;
use File;

class FilesCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = Files::where('uid', Auth::user()->id);

        return view('files.index')->with([
            'files' => $files,
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
        // check if file exist
            if(!empty($request->file('file'))){
                $files = $request->file('file');
                foreach ($files as $file) {
                    $checkFile = Files::where('ftype', $file->getClientOriginalName());
                    if ($checkFile->count() > 0) {
                        $files = $checkFile->first();
                        Session::flash('Error', 'File ' . $files->ftype . ' exist already.');
                    }else{
                          //Move Uploaded File
                          $destinationPath = 'uploads/files/' . $request->uid;
                          $file->move($destinationPath, $file->getClientOriginalName());
                          $saveFile = $destinationPath . '/' . $file->getClientOriginalName();
                 //  Now save the file in our database 
                        $fileDB = new Files;
                        $fileDB->uid = $request->uid;
                        $fileDB->nid = null;
                        $fileDB->ntype = 'media';
                        $fileDB->file = $saveFile;
                        $fileDB->ftype = $file->getClientOriginalName();
                        $fileDB->save();
                        Session::flash('Success', 'Files uploaded successfully.');
                  }
                }
            }
            
            return redirect()->back();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFiles($files)
    {

        // check if file exist
        foreach ($files as $file) {
            $fileDes = $destinationPath . '/' . $file->getClientOriginalName();
            $checkFile = Files::where('file', $fileDes);
            if ($checkFile->count() > 0) {
                $files = $checkFile->first();
                Session::flash('Error', 'File ' . $files->ftype . ' exist already.');
            }else{
                  //Move Uploaded File
                  $destinationPath = 'uploads/files/' . $request->uid;
                  $file->move($destinationPath, $file->getClientOriginalName());
                  $saveFile = $destinationPath . '/' . $file->getClientOriginalName();
         //  Now save the file in our database 
                $fileDB = new Files;
                $fileDB->uid = $request->uid;
                $fileDB->nid = null;
                $fileDB->ntype = 'media';
                $fileDB->file = $saveFile;
                $fileDB->ftype = $file->getClientOriginalName();
                $fileDB->save();
                Session::flash('Success', 'Files uploaded successfully.');
            }
        }
    
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFile($file, $type, $uid)
    {

        $checkFile = Files::where('ftype', $file->getClientOriginalName());
        if ($checkFile->count() > 0) {
            $file = $checkFile->first();
            Session::flash('Error', 'File ' . $files->ftype . ' exist already.');
            $file1 = $checkFile->first()->file;
            return $file;
        }else{
              //Move Uploaded File
              $destinationPath = 'uploads/files/' . $uid;
              $file->move($destinationPath, $file->getClientOriginalName());
              $saveFile = $destinationPath . '/' . $file->getClientOriginalName();
     
        //  Now save the file in our database 
            $fileDB = new Files;
            $fileDB->uid = $uid;
            $fileDB->nid = null;
            $fileDB->ntype = $type;
            $fileDB->file = $saveFile;
            $fileDB->ftype = $file->getClientOriginalName();
            $fileDB->save();
            Session::flash('Success', 'Files uploaded successfully.');
            $file1 = $fileDB->file;
            return $file1;
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
         $getFile = Files::find($id);


         // find if there is any node connected
         $getPost = Posts::where(['image'=>$getFile->file]);
         if ($getPost->count() > 0) {
             $getPost = Posts::where(['image'=>$getFile->file])->update([
                'image' => 'img/blogImage.png'
             ]);
         }


         $remove = File::delete($getFile->file);
         $del = Files::destroy($id);

         Session::flash('Success', 'File removed succesfully.');
         return redirect()->back();
    }
}
