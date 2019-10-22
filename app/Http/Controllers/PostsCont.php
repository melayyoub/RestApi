<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use Illuminate\Support\Facades\DB;
use App\Uploads;
use App\Comments;
use App\Profiles;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;

class PostsCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // create a variable and store in it from the database 
            $posts = Posts::orderby('id', 'desc')->paginate(10);
            return view('post.index')->with([
                'posts' => $posts,
            ]);
        // return a view and pass in the above variable 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHomeposts()
    {
        // create a variable and store in it from the database 
            $posts = Posts::orderby('id', 'desc');
            return $posts;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllposts()
    {
        // create a variable and store in it from the database 
            $posts = Posts::orderby('id', 'desc')->where('homepage', 1);
            return $posts;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHeaderposts($num = 3)
    {
        // create a variable and store in it from the database 
            $posts = Posts::orderby('id', 'desc')->where('homepage', 2);
            return $posts;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTopposts()
    {   
            $toppost = null;
            $topposts = [];
            $getViews = DB::table('views')->orderby('views', 'DESC')->get();
            if ($getViews) {
                foreach ($getViews as $post) {
                    $toppost = Posts::where('id', $post->nid)->first();
                    $topposts[] = ['id' => $toppost->id, 'title'=> $toppost->title, 'body'=>$toppost->body, 'date'=>$toppost->created_at];
                }
            }
            return $topposts;
        // return a view and pass in the above variable 
    }

     public function indexMe()
    {
        // create a variable and store in it from the database 
            // $posts = Posts::all();

            $posts = DB::table('posts')->where('uid', Auth::user()->id)->orderby('id', 'desc')->get();

            return view('post.index')->withposts($posts);
        // return a view and pass in the above variable 
    }

    public function getUserposts($uid)
    {
        // create a variable and store in it from the database 
            // $posts = Posts::all();

            $posts = DB::table('posts')->where('uid', $uid)->orderby('id', 'desc')->get();

            return $posts;
        // return a view and pass in the above variable 
    }

    public function getUserpostsCount($uid)
    {
        // create a variable and store in it from the database 
            // $posts = Posts::all();

            $postsc = DB::table('posts')->where('uid', $uid)->count();
            if ($postsc) {
                $count = $postsc;
            }else{
                $count = 0;
            }
            return $count;
        // return a view and pass in the above variable 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categories();
        $tags = $this->tags();
        $user = User::find(Auth::user()->id);
        $profileInfo = Profiles::where('uid', $user->id);
        return view('post.create')->with([
            'user' => $user,
            'profile' => $profileInfo,
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myPosts()
    {
        return;
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
                $fileDB->ntype = 'post';
                $fileDB->file = $saveFile;
                $fileDB->ftype = $file->getClientOriginalName();
                $fileDB->save();
                $saveFile = $fileDB->file;
              }

          else:
            $saveFile = 'img/postImage.png';
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
                    $fileDB->ntype = 'post';
                    $fileDB->file = $saveFile;
                    $fileDB->ftype = $filea->getClientOriginalName();
                    $fileDB->save();
                    $saveFilesA = '1';
                  }
              }
          endif;
        // store
        $post = new Post;
        $post->title = $request->title;
        $post->path = $slug;
        $post->body = $request->body;
        $post->uid = $request->uid;
        $post->files = $saveFilesA;
        $post->image = $saveFile;

        $post->save();


         // save categories and tags
        // remove and add in case of TAGS
        if (!empty($request->tags)) {
             DB::table('tags')->where(['nid'=> $post->id, 'type'=>'post'])->delete();
            foreach ($request->tags as $key => $value) {
                $newTag = new postTags;
                $newTag->type = 'post';
                $newTag->tag = $value;
                $newTag->nid = $post->id;
                $newTag->uid = $request->uid;
                $newTag->save();
            }
        }else{
            DB::table('tags')->where(['nid'=> $post->id, 'type'=>'post'])->delete();
        }

        
        // now update the file node id
        if(!empty($request->file('image'))):
            DB::table('uploads')->where([
                'uid' => $request->uid,
                'file' => $saveFile
            ])->whereNull('nid')->update(
                ['nid' => $post->id]
            );
        endif;

       // update the files list to connect with the post
         if(!empty($files)):
            foreach ($files as $key) {
                $checkFile = $destinationPath . '/' . $key->getClientOriginalName();
                // now update the file node id
                DB::table('uploads')->where([
                        'uid' => $request->uid,
                        'file' => $checkFile
                    ])->whereNull('nid')->update(
                        ['nid' => $post->id]
                    );
            }
         endif;
        // add views record for this post
        DB::table('views')->insert(
                ['nid' => $post->id, 'views' => 0]
            );
        Session::flash('Success', 'post created successfully!');
        // redirect

        return redirect()->route('post.show', $post->id);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showTitle($slug = false) 
    {
        $post = Posts::where('path', $slug)->first();
        $comments = DB::table('comments')->where('nid', $post->id)->get();
        $tags = App(\App\Http\Controllers\PostsCont::class)->nTags($post->id, 'blog');
        if ($tags) {
            $tags = implode(', ', $tags);
        }else{
            $tags = '';
        }
        $user = User::find($post->uid);

        return view('post.show')->with([
            'post'=>$post,
            'comments'=> $comments,
            'nTags' =>$tags,
            'slug' => $slug,
            'user' => $user
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // myFiles list for each user
        $myFiles = Uploads::where('nid', $id)->orderBy('created_at', 'desc');
        $post = Posts::find($id);
        $user = User::find($post->uid);
        $nTags = $this->nTags(['nid'=>$id, 'type'=>'post']);
        $tags = $this->tags();
        $profileInfo = Profiles::where('uid', $user->id);
        $comments = DB::table('comments')->where('nid', $id)->where('type', 'post')->get();
        return view('post.show')->with([
            'post'=>$post,
            'comments'=> $comments,
            'user' => $user,
            'Profile' => $profileInfo,
            'files' => $myFiles,
            'nTags' => $nTags,
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
        // myFiles list for each user
        $myFiles = Uploads::where('nid', $id)->orderBy('created_at', 'desc');
        // find the post in the database and save it in variable 
        $nTags = $this->nTags(['nid'=>$id, 'type'=>'post']);
        $tags = $this->tags();
        $post = Posts::find($id);
        $comments = DB::table('comments')->where('nid', $id)->where('type', 'post')->get();
        $user = DB::table('users')->where('id', $post->uid)->first();
        $profileInfo = Profiles::where('uid', $user->id);
        return view('post.edit')->with([
              'post'=>$post,
              'user'=>$user,
              'profile'=>$profileInfo,
              'files' => $myFiles,
              'tags' => $tags,
              'nTags' => $nTags
            ]);
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
        // validate the data
        $this->validate($request, array(
            'title' => 'required|max:255',
            'body' => 'required'
            ));

        $slug = $this->create_slug($request->input('title'));
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
                $fileDB->ntype = 'post';
                $fileDB->file = $saveFile;
                $fileDB->ftype = $file->getClientOriginalName();
                $fileDB->save();
                $saveFile = $fileDB->file;
              }

          else:
            $saveFile = 'img/postImage.png';
          endif;

    // check image file
        $files = $request->file('newfiles');
        $saveFilesA = '';
     
        if(!empty($files)):
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
                    $fileDB->ntype = 'post';
                    $fileDB->file = $saveFile;
                    $fileDB->ftype = $filea->getClientOriginalName();
                    $fileDB->save();
                    $saveFilesA = '1';
                  }
              }
          endif;
        

        // save the data to tthe database
        $post = Posts::find($id);
        $post->title = $request->input('title');
        $post->path = $slug;
        $post->body = $request->input('body');
        if(!empty($request->file('image'))):
            $post->image = $saveFile;
        endif;
        if(!empty($request->file('files'))):
            $post->files = $saveFileA;
        endif;
        $post->save();
         // save categories and tags
        // remove and add in case of TAGS
        if (!empty($request->tags)) {
             DB::table('tags')->where(['nid'=> $post->id, 'type'=>'post'])->delete();
            foreach ($request->tags as $key => $value) {
                $newTag = new postTags;
                $newTag->type = 'post';
                $newTag->tag = $value;
                $newTag->nid = $post->id;
                $newTag->uid = $request->uid;
                $newTag->save();
            }
        }else{
            DB::table('tags')->where(['nid'=> $post->id, 'type'=>'post'])->delete();
        }

        
        
        // now update the file node id
        if(!empty($request->file('image'))):
        DB::table('uploads')->where([
                'uid' => $request->uid,
                'file' => $saveFile
            ])->whereNull('nid')->update(
                ['nid' => $post->id]
            );
        endif;
        
        // update the files list to connect with the post
     
        if(!empty($files)):
            foreach ($files as $key) {
                $checkFile = $destinationPath . '/' . $key->getClientOriginalName();
                // now update the file node id
                DB::table('uploads')->where([
                        'uid' => $request->uid,
                        'file' => $checkFile
                    ])->whereNull('nid')->update(
                        ['nid' => $post->id]
                    );
            }
         endif;
        // set flash data with success msg
        Session::flash('Success', 'post updated successfully!');
        // redirect
        return redirect()->route('post.show', $post->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('views')->where('nid', $id)->DELETE();
        Posts::destroy($id);
        return redirect()->route("post.index");
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function nTags($nid, $type = false)
    {
        if ($type) {
          $tags = DB::table('tags')->where(['nid'=>$nid, 'type'=>$type])->get();
          $final = [];
          foreach ($tags as $key) {
                  $final[$key->tag] = $key->tag;         
          }
          
        return $final;
        }else{
          $tags = DB::table('tags')->where('nid', $nid)->get();
        $final = [];
        foreach ($tags as $key) {
                $final[$key->tag] = $key->tag;         
        }
        
        return $final;
        }
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
