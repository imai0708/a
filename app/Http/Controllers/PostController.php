<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Genre;
use App\Models\Item;
use App\Models\Occupation;
use App\Models\Post;
use App\Models\Situation;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->query();
        $posts = Post::search($params)
            ->with(['advisor'])->latest()->paginate(5);

        $posts->appends($params);

        $genres = Genre::all();

        return view('posts.index', compact('posts', 'genres'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        $items = Item::all();
        $situations = Situation::all();
        return view('posts.create', compact('genres', 'items', 'situations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $post
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = new Post($request->all());
        $post->advisor_id = $request->user()->advisor->id;

        try {
            // 登録
            $post->save();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('記事登録処理でエラーが発生しました');
        }

        return redirect()
            ->route('posts.show', $post)
            ->with('notice', '記事を登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // Post::updateOrCreate([
        //     'post_id' => $post->id,
        //     'user_id' => Auth::user()->id,
        // ]);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)

    {
        if (Auth::user()->cannot('update', $post)) {
            return redirect()->route('posts.show', $post)
                ->withErrors('自分の求人情報以外は更新できません');

            if (Auth::user()->cannot('update', $post)) {
                return redirect()->route('posts.show', $post)
                    ->withErrors('自分の求人情報以外は更新できません');
            }
            $post->fill($request->all());
            try {
                $post->save();
            } catch (\Exception $e) {
                return back()->withInput()
                    ->withErrors('求人情報更新処理でエラーが発生しました');

                return redirect()->route('posts.show', $post)
                    > with('notice', '求人情報を更新しました');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        $post = Post::all();
        return view('posts.edit', compact('post'));
    }
}
