<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthSftpController extends Controller
{
    public function index(Request $request)
    {
        $user = DB::connection('db1')->table('users')->select('uid', 'username', 'password')->where('username', $request->username)->first();
        if (!$user) {
            return ['login' => false];
        }
        $check = Hash::check($request->password, $user->password);
        if ($check) {
            return ['login' => $user->uid];
        }
        return ['login' => false];
    }

}