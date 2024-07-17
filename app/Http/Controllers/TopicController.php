<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\topic;

class TopicController extends Controller
{
    public function create()
    {
        return view('create_topic');
    }

    public function store(Request $request)
    {
        $request->validate([
            'instansi' => 'required|string|max:255',
            'topic_pub' => 'required|string|max:255',
            'topic_sub' => 'required|string|max:255',
        ]);

        topic::create($request->all());

        return redirect()->route('topics.create')->with('success', 'Topic added successfully!');
    }
}
