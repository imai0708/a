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
     * @param  \App\Models\JobOffer  $job_offer
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
            $entry->save();
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors('依頼が発生しました');
        }

        return redirect()
            ->route('posts.show', $post)
            ->with('notice', 'エントリーしました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobOffer  $job_offer
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Request $request)
    {
        $request->delete();

        return redirect()->route('posts.show', $post)
            ->with('notice', '依頼を取り消しました');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $occupations = Occupation::all();
        // return view('requeest.create', compact('occupations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function show(Post $job_offer)
    // {
    //     JobOfferView::updateOrCreate([
    //         'job_offer_id' => $job_offer->id,
    //         'user_id' => Auth::user()->id,
    //     ]);

    //     $entry = !isset(Auth::user()->company)
    //         ? $job_offer->entries()->firstWhere('user_id', Auth::user()->id)
    //         : '';
    //     return view('job_offers.show', compact('job_offer', 'entry'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Request  $request
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
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
    }
}
