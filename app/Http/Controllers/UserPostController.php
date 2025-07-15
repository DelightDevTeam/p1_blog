<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// auth
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;

class UserPostController extends Controller
{
    
    // auth constructor
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    // index
    public function index()
    {
        $posts = Post::all();
        $categories = Category::all();
        return view('welcome', compact('posts', 'categories'));
    }

    // detail 
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $comments = Comment::where('post_id', $id)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Add like status for current user
        if (auth()->check()) {
            $userId = auth()->id();
            $comments->each(function ($comment) use ($userId) {
                $comment->is_liked_by_user = $comment->isLikedByUser($userId);
                $comment->replies->each(function ($reply) use ($userId) {
                    $reply->is_liked_by_user = $reply->isLikedByUser($userId);
                });
            });
        }
        
        return view('detail_post', compact('post', 'comments'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->profile_picture = $request->profile_picture;
        
        $user->save();
        return redirect()->route('profile');
    }
}
