<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function change($mode)
    {
        abort_unless(in_array($mode, ['light', 'dark']), 400);

        session()->put('theme', $mode);

        return redirect()->back();
    }
}
