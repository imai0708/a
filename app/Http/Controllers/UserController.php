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
        $requests = [];
        // $posts = [];
        if (isset($request->user()->advisor)) {
            // $posts = $request->user()->advisor->posts;
            $requests = $request->user()->advisor->requests;
        }
        // dd($posts);
        return view('dashboard', compact(['requests']));
    }

        //     // $request->queryでパラメータの取得
        // $params = $request->query();
        // $job_offers = JobOffer::myJobOffer($params)->paginate(5);

        // return view('dashboard', compact('job_offers'));

        // if (Auth::user()->can('company')) {
        //     $query->latest()
        //         ->with(['entries', 'occupation'])
        //         ->where('company_id', Auth::user()->company->id)
        //         // ?? 1つ目の値がヌルだったら別の値(2つ目)を入れる
        //         ->where('is_published', $params['is_published'] ?? self::STATUS_OPEN);
        // } else {
        //     $query->latest()
        //         ->with(['entries', 'occupation'])
        //         // >whereHasはリレーション先の検索
        //         ->whereHas('entries', function ($query) use ($params) {
        //             $query->where('user_id', Auth::user()->id);
        //         });
        // }

        // return $query;
}
