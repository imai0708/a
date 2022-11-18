<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Genre;
use App\Models\GenrePost;
use App\Models\Item;
use App\Models\Occupation;
use App\Models\Post;
use App\Models\Situation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->genres;
        $params = $request->query();
        // $posts = Post::search($params)
        //     ->with(['advisor'])->latest()->paginate(5);
        // $posts = GenrePost::where('genre_id', 1)->first();
        $posts = GenrePost::find($id);
        // dd($posts);

        // $posts->appends(compact('genres'));

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


        $file = $request->file('image');
        $post->image = date('YmdHis') . '_' . $file->getClientOriginalName();

        DB::beginTransaction();
        try {
            // 登録
            $post->save();

            // 画像アップロード
            if (!Storage::putFileAs('public/images/posts', $file, $post->image)) {
                // 例外を投げてロールバックさせる
                throw new \Exception('画像ファイルの保存に失敗しました。');
            }

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // return back()->withInput()
            //     ->withErrors('記事登録処理でエラーが発生しました');
            return back()->withInput()->withErrors($e->getMessage());
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
                ->withErrors('自分の記事以外は更新できません');
            $post->fill($request->all());
            try {
                $post->save();
            } catch (\Exception $e) {
                return back()->withInput()
                    ->withErrors('記事更新処理でエラーが発生しました');

                return redirect()->route('posts.show', $post)
                    > with('notice', '記事情報を更新しました');
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

        // $post = Post::all();
        // return view('posts.edit', compact('post'));

        if (Auth::user()->cannot('delete', $post)) {
            return redirect()->route('posts.show', $post)
                ->withErrors('自分の求人情報以外は削除できません');
        }

        try {
            $post->delete();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('求人情報削除処理でエラーが発生しました');
        }

        return redirect()->route('posts.index')
            ->with('notice', '記事を削除しました');
    }

    // public function search(Request $request)
    // {
        // ユーザー一覧をページネートで取得
        // $posts = Post::paginate(20);

     // 検索フォームで入力された値を取得する
        // $search = $request->input('search');

        // クエリビルダ
        // $query = User::query();

       // もし検索フォームにキーワードが入力されたら
//         if ($search) {

//             // 全角スペースを半角に変換
//             $spaceConversion = mb_convert_kana($search, 's');

//             // 単語を半角スペースで区切り、配列にする（例："山田 翔" → ["山田", "翔"]）
//             $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);


//             // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
//             foreach($wordArraySearched as $value) {
//                 $query->where('name', 'like', '%'.$value.'%');
//             }

// // 上記で取得した$queryをページネートにし、変数$usersに代入
//             $posts = $query->paginate(20);

        // }

        // ビューにusersとsearchを変数として渡す
    //     return view('posts.index')
    //         ->with([
    //             'posts' => $posts,
    //             'search' => $search,
    //         ]);
    // }
// }

}
