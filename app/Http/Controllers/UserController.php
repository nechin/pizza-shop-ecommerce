<?php

namespace App\Http\Controllers;

use Auth;

class UserController extends Controller
{
    public function isAuth()
    {
        return response()->json([
            'auth' => Auth::check()
        ]);
    }
}
