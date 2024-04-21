<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //
    public function like(Request $request){
        $liker = Auth::user();
        $liker->likes()->attach($request->post_id);
        return 1;
    }

    public function unlike(Request $request){
        $liker = Auth::user();
        $liker->likes()->detach($request->post_id);
        return 1;
    }

    public function index(User $user){
        $posts = $user->likes()->with('likedBy')->get();
    
        return view('likes.likedposts', ['posts' => $posts]);
    }

    public function likes($id){
        $post = Post::find($id);
        if(Auth::user()->id != $post->user->id){
            return abort(403, "Neovlašteno");
        }
        $users = $post->likes;

        return view('likes.likes', compact('users'));
    }
}
