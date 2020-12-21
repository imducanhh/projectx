<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Response;

class HomeController extends Controller
{
    public function index() {
    	$list = Post::get();
    	return view('home')->with('list', $list);
    }

    public function signIn(Request $request) {
    	$email = $request->input('email');
        $password = $request->input('password');

        if(Auth::guard('users')->attempt(['email' => $email, 'password' => $password])) {
        	return response()->json(['message'=>1]);
        } else {
        	return response()->json(['message'=>0]);
        }
    }

    public function logOut() {
    	//Session::flush ();
	    Auth::guard('users')->logout();
	    return redirect('/signin');
    }

    public function posts() {
    	$list = Post::get();
    	return view('posts')->with('list', $list);
    }

    public function addPost(Request $request) {
    	$title = $request->input('title');
    	$slug = $request->input('slug');
    	$content = '';
    	$image = '';
    	Post::create([
    		'title'   => $title,
    		'slug'    => $slug,
    		'content' => $content,
    		'image'   => $image
    	]);
    	return response()->json(['message'=>1]);
    }

    public function getPosts() {
        $posts = Post::select(['id','title','content'])->orderBy('id','ASC')->get();

        return Datatables::of($posts)
        ->addIndexColumn()
        ->editColumn('title', function ($post) {
        	return $post->title;
        })
        ->editColumn('content', function ($post) {
            return $post->content;
        })
        ->addColumn('action',function ($post)
        {
            return '<button type="button" class="btn-delete btn btn-danger btn-sm" data-id="'.$post->id.'"><i class="fas fa-trash"></i></button>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function deletePost($id) {
    	Post::where('id', $id)->delete();
    	return response()->json(['message'=>1]);
    }
}
