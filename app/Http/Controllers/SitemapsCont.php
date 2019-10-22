<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Profiles;
use App\Posts;
use App\Followers;
use App\Uploads;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminCont;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;


class SitemapsCont extends Controller
{
    public function index()
        {
          $post = Posts::orderBy('updated_at', 'desc')->first();

          return response()->view('sitemaps.index', [
              'post' => $post,
          ])->header('Content-Type', 'text/xml');
        }
    public function posts()
        {
            $posts = Posts::all();
            return response()->view('sitemaps.posts', [
                'posts' => $posts,
            ])->header('Content-Type', 'text/xml');
        }

    public function categories()
        {
            $categories = Category::all();
            return response()->view('sitemaps.categories', [
                'categories' => $categories,
            ])->header('Content-Type', 'text/xml');
        }

}
