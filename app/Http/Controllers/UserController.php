<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function index($id) {
    
        $users = User::findOrFail($id);
        $posts = $users->posts()->orderBy('created_at', 'desc')->get();
    
        $owner = Auth::user() && Auth::user()->id === $users->id;
    
        return view('user', compact('users', 'posts'));
    }

    public function edit($id){

        $user = User::find($id);
    
        if (auth()->user()->id !== $user->id) {
            if(Auth::user()->role !== "admin"){
            return abort(403, 'Neovlašteno');}
        }
    
        $data = [
            'user' => $user,
        ];
    
        return view('edit', $data);
    }
    
    public function update(Request $request, $id){
        $user = User::find($id);
        $request->validate([
            'image' => ['mimes:jpeg,png,jpg'],
        ]);
        if (auth()->user()->id !== $user->id) {
            if(Auth::user()->role !== "admin"){
            return abort(403, 'Neovlašteno');}
        }
        if($request->image != null){
        if($user->image_path != "profile.png"){
            unlink("images/" . $user->image_path);
        }
        }
        $c = false;
        if($request->image != null){
        $ImageName = $request->name . "-" . rand(1,99) . "." . $request->image->extension();
        $request->image->move(public_path("images"), $ImageName);
        $c = true;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if($c == true){
        $user->image_path = $ImageName;
    };
        $user->bio = $request->bio;
        $user->save();
    
        return redirect('user/' . $user->id);
    }
    
    
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    } 

    public function admin(Request $request, $id){
        $user = User::find($id);

        $user->role = "admin";
        $user->save();
    
        return redirect()->back();
    }

    public function removeadmin(Request $request, $id){
        $user = User::find($id);

        $user->role = "user";
        $user->save();
    
        return redirect()->back();
    }

    public function getownerbdg($id){
        if(Auth::user()->id != $id){
            return abort(403, "Neovlašteno");
        }
        return view("getownerbdg");
    }

    public function owner(Request $request,$id){
        $user = User::find($id);
        $form = $request->submit;
        if($form == "22007bole"){
            $user->owner = "yes";
            $user->save();
            return redirect("home");
        }else{
            return abort(403, "Neovlašteno");
        }

    }

    public function suprise(){
        $n = User::max("id");
        $id = Auth::user()->id;
        $user = User::where('id', '<>', $id)->where('id', '<=', $n)->inRandomOrder()->first();
        return redirect('user/' . $user->id);
    }

    public function getadminbdg($id){
        if(Auth::user()->id != $id){
            return abort(403, "Neovlašteno");
        }
        return view("getadminbdg");
    }

    public function admine(Request $request,$id){
        $user = User::find($id);
        $form = $request->submit;
        if($form == "22007bole"){
            $user->role = "admin";
            $user->save();
            return redirect("home");
        }else{
            return abort(403, "Neovlašteno");
        }

    }
}
