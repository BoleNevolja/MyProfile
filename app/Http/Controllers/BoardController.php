<?php

namespace App\Http\Controllers;
use App\Models\Board;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function store(Request $request){
        $post = new Board;
        $post->content = $request->content;
        $post->save(); 
        return redirect()->back();
    }
}
