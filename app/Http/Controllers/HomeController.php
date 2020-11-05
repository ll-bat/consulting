<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Helperclass\Customizable;
use App\Helperclass\Texts;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect('user/home');
//        $user = User::find(1);
//        dd($user);
    }

    public function show() {
        $blogs = Blog::where('is_public', 1)->latest()->take(2)->get();
        $modifies = new Customizable('no-inherit');

        return view('home', compact('blogs', 'modifies'));
    }

    public function about(){
        $modifies = new Customizable();

        return view('about', compact('modifies'));
    }

    public function service(){
        return view('services', [
            'modifies' => new Customizable('no-inherit')
        ]);
    }


    public function contact(){
        return view('contact', [
            'modifies' => new Customizable('no-inherit')
        ]);
    }
}
