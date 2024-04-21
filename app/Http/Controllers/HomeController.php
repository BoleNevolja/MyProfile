<?php

namespace App\Http\Controllers;
use App\Models\Board;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = Auth::id();
        $users = User::where('id', '!=', $userId)->inRandomOrder()->take(10)->get();
        $shuffled = $users->shuffle();
        $followedUsers = Auth::user()->followings; 
            $data = [
                'users' => $shuffled,
                'followedUsers'=>$followedUsers,
            ];
   
            return view('home' , $data);  
    }

    public function search(){
        $search_text = $_GET['querry'];
    
        $users = User::where('name', 'like', '%' . $search_text . '%')->where('id', '!=', Auth::user()->id)->get();
        $followedUsers = Auth::user()->followings; 
        $data = [
            'users' => $users,
            'followedUsers'=>$followedUsers,
        ];
    
        return view('home', $data);
    }

    public function hotposts(){
    $time = now()->subDays(7);

    $posts = Post::withCount('likes')
                 ->where('created_at', '>', $time)
                 ->orderByDesc('likes_count')
                 ->get();

    $followedUsers = Auth::user()->followings;

    $data = [
        'posts' => $posts,
        'followedUsers' => $followedUsers,
    ];

    return view('posts.hotposts', $data);
    }

    public function adminview(){
        if(Auth::user()->role != "admin"){
            return abort(403, "Neovlašteno");
        }

        $time = now()->subDays(1);

        $users = User::orderBy('created_at', 'desc')->take(4)->get();
        $posts = Post::orderBy('created_at', 'desc')->get();
        $comments = Comment::orderBy('created_at', 'desc')->get();
        $n = User::count();
        $na = User::where('role','=','admin')->count();
        $newU = User::where('created_at', '>', $time)->count();
        $newP = Post::where('created_at', '>', $time)->count();
        $msg = Board::orderBy('created_at', 'desc')->get();

        $data = [
            'posts' => $posts,
            'users' => $users,
            'comments' => $comments,
            'TotalUsers' => $n,
            'TotalAdmins' => $na,
            'NewUsers' => $newU,
            'NewPosts' => $newP,
            'msgs' => $msg,
        ];
        return view("admin.admin", $data);
    }

    public function adminusers(){
        if(Auth::user()->role != "admin"){
            return abort(403, "Neovlašteno");
        }

        $time = now()->subDays(1);

        $users = User::orderBy('created_at', 'desc')->get();
        $n = User::count();
        $newU = User::where('created_at', '>', $time)->count();

        $data = [
            'users' => $users,
            'TotalUsers' => $n,
            'NewUsers' => $newU,
        ];
        return view("admin.users", $data);
    }

    public function followedusers(){
        $followedUsers = Auth::user()->followings; 
            $data = [
                'users'=>$followedUsers,
            ];
   
            return view('followedusers' , $data);  
    }

}
