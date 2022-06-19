<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use Illuminate\Http\Request;
use \App\Http\Controllers\Api\PodcastController as PodcastApi;

class PodcastController extends Controller
{
    public function index(Request $request)
    {
        \Head::SetTitle('Podcast');
        $podcasts = PodcastApi::GetPodcast($request,20)['data'];

        return view('client.podcast.index',compact('podcasts'));
    }

    public function show(Request $request,$slug)
    {
        \Head::SetTitle('Podcast');

        $podcast = PodcastApi::GetPodcast($request,1,['Slug' => $slug])['data'];
        $podcast = $podcast[0];
        if(empty($podcast)){
            abort(404);
        }
        $relatedPodcast = PodcastApi::RelatedPodcast($request,$podcast, 5)['data'];
        $relatedCourse = PodcastApi::RelatedCourse($request,$podcast,5)['data'];
        $relatedBlog = PodcastApi::RelatedBlog($request,$podcast,5)['data'];
        $relatedGuidance = PodcastApi::RelatedGuidance($request,$podcast,5)['data'];
        $tags = PodcastApi::GetTag($request,$podcast,4)['data'];
        $comments = PodcastApi::GetComments($request,$podcast)['data'];

        return view('client.podcast.show',compact('relatedPodcast','relatedCourse',
            'comments','tags','relatedBlog','relatedGuidance'));
    }
}
