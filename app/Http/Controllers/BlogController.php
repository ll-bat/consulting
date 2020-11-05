<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Category;
use App\Helperclass\Customizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    public function index(){

        $categoryId = request('categoryId') ?? false;

        if (!$categoryId)
           $blogs = Blog::where('is_public',1)->latest()->paginate(3);
        else
           $blogs = Blog::where('is_public', 1)->where('category_id', $categoryId)->latest()->paginate(3);

        $path = 'blog';
        if ($categoryId)
              $path.= '?categoryId='.$categoryId;

        $blogs->setPath($path);

        $categories = Category::where('id', '>', 0)->get();

        return view('blog' ,[
            'blogs' => $blogs,
            'categories' => $categories,
            'modifies' => new Customizable()
        ]);
    }

    public function all(){
        $param = request('key');
//        dd($param);
        $blogs = Blog::where('title', 'like', "%$param%")->latest()->paginate(6);
        return view('admin.blog' ,[
            'blogs' => $blogs
        ]);
    }

    public function show(Blog $blog){
        return view('single-blog', [
            'blog' => $blog
        ]);
    }

    public function store(){

        $data = $this->validateBlog();
        Blog::create($data);

        return redirect()->to('user/blogs');
    }


    public function edit(Blog $blog){
        return view('admin.blog.edit' ,[
            'blog' => $blog
        ]);
    }

    public function update(Blog $blog){
        $data = $this->validateBlog();

        if ($blog->image != '')
         if (file_exists($blog->image))
           unlink('storage/'.$blog->image);

        $blog->update($data);
        return redirect()->to('user/blogs');
    }

    public function toggle(Blog $blog){
        $blog->togglePublic();

        return 'done';
    }

    public function delete(Blog $blog){

        try {
            if ($blog->image != '')
            unlink('storage/'.$blog->image);
        }
        catch(Exception $e){
            echo 'blog does not have image';
        }

        $blog->delete();

        return redirect()->to('user/blogs');
    }

    public function validateBlog(){
        $data = request()->validate([
            'title' => ['required', 'max:155', 'string'],
            'excerpt' => ['required', 'max:420', 'string'],
            'body' => ['required', 'string'],
            'category_id' => ['integer', 'exists:categories,id'],
            'image'  => ['image']
        ]);
        if (!isset($data['category_id'])){
            $data['category_id'] = 0;
        }

        if (isset($data['image'])){
            // $data['image'] = request('image')->store('blogs');
             $data['image'] =  cloudinary()->upload(request()->file('image')->getRealPath())->getSecurePath(); 
        }
        $data['user_id'] = current_user()->id;
        return $data;
    }
}
