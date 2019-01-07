<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     *
     * @param User $user
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        $data = [
            'profileUser' => $user,
            'activities' => Activity::feed($user)
        ];

        if (request()->expectsJson()) {
            return $data;
        }

        return view('profiles.show', $data);
    }
}
