<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $id){
        $post = Post::findOrFail($id);
        $comment = new Comment;
        $comment->content = $request->content;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $post->id;
        $comment->save();

        return redirect()->back();
    }

    public function edit($id){

        $comment = Comment::find($id);
        if (Auth::user()->id != $comment->user_id) {
            if(Auth::user()->role != "admin"){
            return abort(403, 'Unauthorized');}
        }
    
        $data = [
            'comment' => $comment,
        ];
    
        return view('comments.editcomment', $data);
    }

    public function update(Request $request, $id){
        $comment = Comment::find($id);
        $comment->content = $request->content;
        $comment->save();
    
        return redirect('post/' . $comment->post_id);
    }

    public function destroy($id){
        $comment = Comment::find($id);
        $comment->delete();
        return redirect('post/' . $comment->post_id)->with('success', 'Objava uspješno obrisana');
    }

}
