<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        \Head::SetTitle('لیست تگ ها');
        $tags = Tag::GetTags();

        return view('panel.tag.index',compact('tags'));
    }

    public function create()
    {
        \Head::SetTitle('Tag');

        return  view('panel.tag.create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'Title' => 'required|min:2|string'
        ]);

        $tag = Tag::create([
            'Title' => $validateData['Title'],
        ]);

        $response = [
            'status' => 1,
            'text' => "",
            "data" => 'The tag was successfully saved.'
        ];

        return  $response;
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        $response = [
            'status' => 1,
            'data' => 'Tag successfull removed',
            'text' => ''
        ];

        return $response;
    }
}
