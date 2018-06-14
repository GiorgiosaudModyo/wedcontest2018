<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    /**
     * [index description].
     *
     * @return [type] [description]
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * [makeAdmin description].
     *
     * @param User $user [description]
     *
     * @return [type] [description]
     */
    public function toggleAdmin(User $user)
    {
        if (auth()->user()->id !== $user->id) {
            $user->roles()->toggle('1');
        }

        return view('users.index');
    }

    /**
     * Delete User.
     *
     * @param Reply $reply [description]
     *
     * @return [type] [description]
     */
    public function destroy(User $user)
    {
        if (auth()->user()->id !== $user->id) {
            $user->delete();
        }

        return view('users.index');
    }
}