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
    // dd(Auth::user()->id);

        try {
        $entry = new Request([
            'advisor_id' => $post->advisor_id,
            'user_id' => Auth::user()->id,
        ]);
            // 登録
            $entry->save();
        } catch (\Exception $e) {
        dd($e);
            return back()->withInput()
                ->withErrors('依頼が発生しました');
        }

        return redirect()
            ->route('posts.show', $post)
            ->with('notice', 'エントリーしました');
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
     * Display the specified resource.
     *
     * @param  \App\Models\JobOffer  $job_offer
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //     JobOfferView::updateOrCreate([
        //         'job_offer_id' => $job_offer->id,
        //         'user_id' => Auth::user()->id,
        //     ]);

        $request = !isset(Auth::user()->advisor)
            ? $post->entries()->firstWhere('user_id', Auth::user()->id)
            : '';

        $entries = Auth::user()->id == $post->advisor->user_id
            ? $post->request()->with('user')->get()
            : [];

        return view('posts.show', compact('post', 'request', 'entries'));
    }

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
    public function destroy(Post $post, Request $request)
    {
        $request->delete();

        return redirect()->route('posts.show', $post)
            ->with('notice', 'エントリーを取り消しました');
    }

    /**
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function approval($id)
    {
        $request = Request::find($id);
        // dd($request);
        $requests = $request->advisor->request;
        $request->status = Request::STATUS_APPROVAL;

        $request->save();

        // return redirect()->route('posts.show', $post)
        //     ->with('notice', 'エントリーを承認しました');
        return redirect()->route('dashboard', $requests)
        ->with('notice', 'エントリーを承認しました');
    }

    /**
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reject($id)
    {
        $request = Request::find($id);
        $request->status = Request::STATUS_REJECT;
        $request->save();
        $requests = $request->advisor->request;

        return redirect()->route('dashboard', $requests)
        ->with('notice', 'エントリーを承認しました');
    }


}
