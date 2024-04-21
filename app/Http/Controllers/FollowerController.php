<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    public function follow(Request $request){
     $follower = auth()->user();
     $follower->followings()->attach($request->user_id);

     return 1;
    }

    public function unfollow(Request $request){
        $follower = auth()->user();
        $follower->followings()->detach($request->user_id);
   
        return 1;
    }

    public function index($id){
        if(Auth::user()->id != $id){
            return abort(403, "Neovlašteno");
        }
        $user = User::find($id);
        $users = $user->followers;

        return view('followers', compact('users'));
    }
}
