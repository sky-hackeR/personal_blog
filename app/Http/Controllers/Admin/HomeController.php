<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;
use App\Models\BreakingNews;
use App\Models\Post;

use Alert;


class HomeController extends Controller
{
    public function home(){

        return view('admin.home');
    }


    // CATEGORY LOGIC
    public function categories(){

        $categories = Category::all();
        return view('admin.categories', [
            'categories' => $categories
        ]);
    }
    public function addCategory(Request $request){

        $validator = Validator::make($request->all(), [
            'category' => 'string|required|unique:categories',
            'slug' => 'string|unique:slugs',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->input('category'))));

        Category::create([
            'category' => $request->input('category'),
            'slug' => $slug,
        ]);

        alert()->success('Good Job', 'Category added successfully')->persistent('Close');
        return redirect()->back();
    }
    public function updateCategory(Request $request){
        $category = Category::find($request->input('category_id'));
        $category->category = $request->input('category');
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|unique:categories',
            'category_id' => 'required',
            
        ]);
        if ($validator->fails()) {
            Alert::error('Oops!', 'Failed to update category')->persistent('Close');
            return redirect()->back();
        }
        if(!$category = Category::find($request->input('category_id'))){
            Alert::error('Oops!', 'Category not found')->persistent('Close');
            return redirect()->back();
        }
        if($request->input('category') != $category->category){
            $slug =strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $request->input("category"))));
            $category->slug = $slug;
            $category->category = $request->input("category");
        }
        if($category->save()){
            Alert::success('Success!','Category updated successfully')->persistent('Close');
            return redirect()->back();
        }
    }
    public function deleteCategory(Request $request){
        $category = Category::find($request->input('category_id'));
        $category->category = $request->input('category');
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            
        ]);
        if ($validator->fails()) {
            Alert::error('Oops!', 'Failed to delete category')->persistent('Close');
            return redirect()->back();
        }
        if(!$category = Category::find($request->input('category_id'))){
            Alert::error('Oops!', 'Category not found')->persistent('Close');
            return redirect()->back();
        }
        if($request->input('category') != $category->category){
            $slug =strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $request->input("category"))));
            $category->slug = $slug;
            $category->category = $request->input("category");
        }
        if($category->forceDelete()){
            Alert::success('Success!','Category deleted successfully')->persistent('Close');
            return redirect()->back();
        }
    }
        public function blogposts(){
        $blogposts = Post::with('category')->get();
        $categories = Category::all();
        return (view ("admin.blogposts" , [
            "categories"=> $categories,
            "blogposts"=> $blogposts,
        ]));
    }


    // BLOGPOST LOGIC
    public function addPost(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required',
            'post_body' => 'required',
            'category_id' => 'required',
            'image' => 'mimes:jpeg,jpg,png|required|max:10000'
        ]);
        
        if ($validator->fails()) {
            Alert::error('Error!', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }
        $admin = Auth::guard('admin')->user();
        $admin_id = $admin->id;
        $title = $request->title;
        $description = $request->description;
        $post_body = $request->post_body;
        $category_id = $request->category_id;
        $slug =strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $request->title)));
        $imageUrl = 'uploads/blogposts/'. $slug.'.'.$request->file('image')->getClientOriginalExtension();
        $image = $request->file('image')->move('uploads/blogposts',$imageUrl);
        $newPost =([
            'title' => $title,
            'description'=> $description,
            'category_id'=> $category_id,
            'admin_id' => $admin_id,
            'post_body' => $post_body,
            'image' => $imageUrl,
            'slug'=> $slug

        ]);
        if($createPost = Post::create($newPost)){
            Alert::success('Good Job!','Post added successfully')->persistent('Close');
            return redirect()->back();
        };
        Alert::error('Oops!', 'Submission Successful!')->persistent('Close');
    }


    // BREAKING NEWS LOGIC
    public function breakingnews(){

        $breakingnews = BreakingNews::all();
        return view('admin.breakingnews', [
            'breakingnews' => $breakingnews
        ]);
    }
    public function addbreakingNews(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'string|required|unique:breaking_news',
        ]);

        if ($validator->fails()) {
            alert()->error('Error', $validator->messages()->all()[0])->persistent('Close');
            return redirect()->back();
        }

        BreakingNews::create([
            'title' => $request->input('title'),
        ]);

        alert()->success('Good Job', 'Breaking News added successfully')->persistent('Close');
        return redirect()->back();
    }



    // NEWSLETTER LOGIC
    public function newsletters(){

        return view('admin.newsletters');
    }


    //USERS LOGIC
    public function users(){

        return view('admin.users');
    }    

}
