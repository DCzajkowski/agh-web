<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'content' => ['required', 'min:1', 'max:255'],
            'to' => ['required', 'exists:users,id'],
        ]);

        $data['from'] = request()->user()->id;

        Message::create($data);

        return response()->json(null, 201);
    }

    public function show($id)
    {
        return Message::where('from', ($auth = request()->user())->id)->where('to', $id)->orWhere('to', $auth->id)->where('from', $id)->orderBy('created_at')->get();
    }
}
