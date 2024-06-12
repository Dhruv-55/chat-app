<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request){
        $users =  User::whereNotIn('id',[auth()->user()->id])->get();
        return view('dashboard',[
            'users' => $users
        ]);
    }
}
