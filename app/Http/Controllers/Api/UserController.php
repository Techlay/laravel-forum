<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $search = request('username');

        return User::where('username', 'LIKE', "%$search%")
            ->take(5)
            ->pluck('username');
    }
}
