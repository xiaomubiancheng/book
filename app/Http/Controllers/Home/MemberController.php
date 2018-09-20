<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function toLogin( $value='' ){
        return view('home/login');
    }

    public function toRegister( $value='' ){
        return view('home/register');
    }
}
