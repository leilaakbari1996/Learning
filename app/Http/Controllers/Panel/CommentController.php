<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($status = null)
    {
        \Head::SetTitle('لیست کامنت ها');
        if($status == 'UnRead' || $status == 'Accepted' || $status == 'Rejected'){dd($status);
            $comments = Comment::GetComment(['Status' => $status])->get();
        }else{
            $comments = Comment::GetComment();
        }
        $parents = Comment::GetComment(['parent_id'=>null])->get();

        $comments = separate_comments($comments,$parents);
        $commentsCourses = $comments[0];
        $commentsPodcasts = $comments[1];
        $commentsBlogs = $comments[2];

        return view('panel.comment',compact('commentsBlogs','commentsCourses','commentsPodcasts'));
    }

    public function update(Comment $comment,CommentRequest $request)
    {
        $comment->update([
            'Status' => 'Accepted'
        ]);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'Successfully Accepted'
        ];

        return  $response;

    }

    public function destroy(Comment $comment)
    {
        $comment->update([
            'Status' => 'Rejected'
        ]);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'Successfully Rejected'
        ];

        return  $response;
    }

    public function filter($status = null)
    {
        \Head::SetTitle('لیست کامنت ها');
        if($status == 'UnRead' || $status == 'Accepted' || $status == 'Rejected'){
            $comments = Comment::GetComment(['Status' => $status])->get();
        }else{
            $comments = Comment::GetComment();
        }
        $parents = Comment::GetComment(['parent_id'=>null])->get();

        $comments = separate_comments($comments,$parents);
        $commentsCourses = $comments[0];
        $commentsPodcasts = $comments[1];
        $commentsBlogs = $comments[2];

        return view('panel.comment',compact('commentsBlogs','commentsCourses','commentsPodcasts'));
    }
}
