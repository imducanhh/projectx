<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Response;

class HomeController extends Controller
{
    public function index() {
    	$list = Post::get();
        $categories = Category::get();
    	return view('home')->with([
            'list' => $list,
            'categories' => $categories
        ]);

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

    // Bài viết
    public function posts() {
    	$list = Post::get();
    	$categories = Category::get();
        return view('posts')->with([
            'list' => $list,
            'categories' => $categories
        ]);
    }

    // Danh mục bài viết
    public function categories() {
        $list = Post::get();
        $categories = Category::get();
        return view('categories')->with([
            'list' => $list,
            'categories' => $categories
        ]);
    }

    // Thêm mới bài viết
    public function addPost(Request $request) {
    	$title = $request->input('title');
    	$slug = $request->input('slug');
        $category_id = $request->input('category');
    	$content = '';
    	$image = '';
    	Post::create([
    		'title'       => $title,
    		'slug'        => $slug,
            'category_id' => $category_id,
    		'content'     => $content,
    		'image'       => $image
    	]);
    	return response()->json(['message'=>1]);
    }

    public function getPosts() {
        $posts = Post::select(['id','image','title','slug','content','created_at'])->orderBy('id','DESC')->get();

        return Datatables::of($posts)
        ->addIndexColumn()
        ->editColumn('image', function ($post) {
            return '<img src="/img/santa.jpg" alt="" style="height: 63px;">';
        })
        ->editColumn('title', function ($post) {
        	return $post->title;
        })
        ->editColumn('content', function ($post) {
            return $post->content;
        })
        ->editColumn('created_at', function ($post) {
            return date('d-m-Y', strtotime($post->created_at));
        })
        ->addColumn('action',function ($post)
        {
            return '<div class="hoverBtn hiden">
            <a href="/post/'.$post->slug.'" target="_blank" style="color: white;"><button type="button" class="btn-view btn btn-primary btn-sm" title="Xem chi tiết"><i class="fas fa-eye"></i></button></a>
            <button type="button" class="btn-update btn btn-warning btn-sm" data-id="'.$post->id.'" title="Cập nhật"><i class="fas fa-pencil-alt"></i></button>
            <button type="button" class="btn-delete btn btn-danger btn-sm" data-id="'.$post->id.'" title="Xóa"><i class="fas fa-trash"></i></button>
            </div>';
        })
        ->rawColumns(['action', 'image'])
        ->make(true);
    }

    public function deletePost($id) {
    	Post::where('id', $id)->delete();
    	return response()->json(['message'=>1]);
    }

    // Xem chi tiết bài viết
    public function viewPost($slug) {
        $post = Post::where('slug', $slug)->first();
        return view('post')->with([
            'post' => $post
        ]);
    }

    public function getPostUpdate($id) {
        $post = Post::where('id', $id)->first();
        return response()->json(['post'=>$post]);
    }

    public function updatePost(Request $request) {
        $title = $request->input('title');
        $slug = $request->input('slug');
        $category_id = $request->input('category_id');
        $content = '';
        $image = '';
        Post::create([
            'title'       => $title,
            'slug'        => $slug,
            'category_id' => $category_id,
            'content'     => $content,
            'image'       => $image
        ]);
        return response()->json(['message'=>1]);
    }

    // get list danh mục
    public function getCategories() {
        $categories = Category::select(['id','name', 'slug', 'image', 'content'])->orderBy('id','ASC')->get();
        return Datatables::of($categories)
        ->addIndexColumn()
        ->editColumn('name', function ($category) {
        	return $category->name;
        })
        ->editColumn('slug', function ($category) {
            return $category->slug;
        })
        ->editColumn('image', function ($category) {
            return $category->image;
        })
        ->editColumn('content', function ($category) {
            return $category->content;
        })
        ->addColumn('action',function ($category)
        {
            return '<button type="button" class="btn-delete btn btn-danger btn-sm" data-id="'.$category->id.'" title="Xóa"><i class="fas fa-trash"></i></button>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    // Thêm mới danh mục
    public function addCategory(Request $request) {
        $name = $request->get('name');
        $slug = $request->get('slug');
        $content = $request->get('content');
        $image = '';
        Category::create([
            'name'    => $name,
            'slug'    => $slug,
            'content' => $content,
            'image'   => $image
        ]);
        return response()->json(['message'=>1]);
    }
}
