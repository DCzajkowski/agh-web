<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index', [
            'users' => User::where('id', '!=', ($auth = Auth::user())->id)->get()->toJson(),
            'auth' => $auth->toJson(),
        ]);
    }
}
