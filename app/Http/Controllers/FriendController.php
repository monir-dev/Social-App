<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\User;

class FriendController extends Controller
{
    public function getIndex()
    {
        $friends = Auth::user()->friends();
        $requests =Auth::user()->friendRequests();

        return view('friends.index')
                    ->withFriends($friends)
                    ->withRequests($requests);
    }

    public function getAdd($username)
    {
        $user = User::where('username', $username)->first();

        if(Auth::user() == $user){
            return redirect()
                  ->route('home');
        }

        if (!$user) {
            return redirect()
                    ->route('home')
                    ->withInfo('That user could not be found');
        }

        if (Auth::user()->hasFriendRequestPending($user) || $user->hasFriendRequestPending(Auth::user())) {
            return redirect()
                  ->route('profile.index', ['username' => $user->username])
                  ->withInfo('Friend request already pending.');
        }

        if (Auth::user()->isFriendsWith($user)) {
            return redirect()
                  ->route('profile.index', ['username' => $user->username])
                  ->withInfo('You are already friend.');
        }

        Auth::user()->addFriend($user);

        return redirect()
               ->route('profile.index', ['username' => $username])
               ->withInfo('Friend request sent.');
    }

    public function getAccept($username)
    {
        $user = User::where('username', $username)->first();

        if(!$user){
          return redirect()
                ->route('home')
                ->withInfo('That user could not be found.');
        }

        if(!Auth::user()->hasFriendRequestReceived($user)){
            return redirect()->route('home');
        }

        Auth::user()->acceptFriendRequest($user);

        return redirect()
              ->route('profile.index', ['username' => $username])
              ->withInfo('Friend request accepted.');
    }

    public function postDelete($username)
    {
        $user = User::where('username', $username)->first();

        if (!Auth::user()->isFriendsWith($user)) {
            return redirect()->back();
        }

        Auth::user()->deleteFriend($user);

        return redirect()->back()->withInfo('Friend deleted.');
    }

}
