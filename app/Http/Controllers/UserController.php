<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $params = $request->query();
        // $posts = Post::mypost($params)->paginate(5);
        // $posts = $request->user()->advisor->posts;
        $posts = [];
        if (isset($request->user()->advisor)) {
            $posts = $request->user()->advisor->posts;
        }
        // dd($posts);
        return view('dashboard', compact('posts'));
    }
}
