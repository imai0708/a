<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post)
    {
        $entry = new Request([
            'post_id' => $post->id,
            'user_id' => Auth::user()->id,
        ]);

        try {
            // 登録
            $request->save();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('エントリーでエラーが発生しました');
        }

        return redirect()
            ->route('posts.show', $post)
            ->with('notice', 'エントリーしました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Request $request)
    {
        $request->delete();

        return redirect()->route('posts.show', $post)
            ->with('notice', 'エントリーを取り消しました');
    }
    // /**
    //  * Run the migrations.
    //  *
    //  * @return void
    //  */
    // public function up()
    // {
    //     Schema::create('requests', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('user_id')
    //             ->constrained()
    //             ->cascadeOnUpdate()
    //             ->cascadeOnDelete();
    //         $table->foreignId('advisor_id')
    //             ->constrained()
    //             ->cascadeOnUpdate()
    //             ->cascadeOnDelete();
    //         $table->tinyInteger('status')->default(0)->comment('依頼の認否');
    //         $table->timestamps();
    //         $table->unique(['advisor_id', 'user_id']);
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  *
    //  * @return void
    //  */
    // public function down()
    // {
    //     Schema::dropIfExists('requests');
    // }
}
