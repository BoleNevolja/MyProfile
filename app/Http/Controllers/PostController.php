<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request){
        $name = $request->title;
        $request->validate([
            'image' => ['mimes:jpeg,png,jpg'],
        ]);
        $name = trim($name);
        $c = false;
 if($request->image != null){
        $ImageName = $name . "-" . rand(10,99) . "." . $request->image->extension();; 
        $request->image->move(public_path("data"), $ImageName);
        $c = true;
    }  

        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;
        if($c == true){
        $post->image_path = $ImageName;
        }
        $post->user_id = Auth::user()->id;
        if(Auth::user()->owner == "yes"){
            $post->verified = "yes";
        }
        $post->save();

        return redirect('user/' . Auth::user()->id);
    }

    public function destroy($id){
        $post = Post::find($id);
        if($post->image_path != null){
        unlink(public_path('data/' . $post->image_path));
    }
        $post->delete();
        return redirect('user/' . $post->user_id)->with('success', 'Objava uspješno obrisana');
    }

    public function update(Request $request, $id){
        $post = Post::find($id);

        $post->title = $request->title;
        $post->content = $request->content;
        $post->verified = "no";
        $post->edited = "yes";
        $post->save();
    
        return redirect('user/' . $post->user_id);
    }

    public function edit($id){

        $post = Post::find($id);
        $user = User::find($post->user_id);
    
        if (Auth::user()->id != $user->id) {
            if(Auth::user()->role != "admin"){
            return abort(403, 'Unauthorized');}
        }
    
        $data = [
            'post' => $post,
        ];
    
        return view('posts.editpost', $data);
    }

    public function verify(Request $request, $id){
        $post = Post::find($id);

        $post->verified = "yes";
        $post->save();
    
        return redirect()->back();
    }

    public function unverify(Request $request, $id){
        $post = Post::find($id);

        $post->verified = "no";
        $post->save();
    
        return redirect()->back();
    }

    public function index($id) {
    
        $post = Post::findOrFail($id);
        $comments = $post->comments()->orderBy('created_at', 'desc')->get();
    
        return view('posts.post', compact('post', 'comments'));
    }

}
