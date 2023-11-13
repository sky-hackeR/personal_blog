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

use Alert;


class HomeController extends Controller
{
    public function home(){

        return view('admin.home');
    }

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

    public function blogposts(){

        return view('admin.blogposts');
    }


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

    public function newsletters(){

        return view('admin.newsletters');
    }

    public function users(){

        return view('admin.users');
    }    

}
