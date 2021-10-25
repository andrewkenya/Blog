<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    public function index() {

        $posts = BlogPost::all(); //fetch all blog posts from db
        return view('blog.index', [ 
            'posts' => $posts,
        ]);
        // return $posts; //returns the fetched posts
        // show all blog posts
    }

    public function create() {
       
        // show form to create a blog post
        {
            return view('blog.create');
        }
    }

    public function show(BlogPost $blogPost) {  

        // show a blog post
          return view('blog.show', [
              'post' => $blogPost,
          ]);   //returns the view with the post

    }

    public function edit(BlogPost $blogPost) { 
         
        // show form to edit the post
        return view('blog.edit', [
            'post' => $blogPost,

        ]); //returns the edit view with the post
    }

    public function store() {

        BlogPost::create(array_merge($this->validatePost(), [
            'title' => request()->title,
            'body' => request()->body,
            'user_id' => 1
        ]));
        
        return redirect('/');
    }

    public function update(BlogPost $blogPost) { 

        // save the edited post
    
        $attributes = $this->validatePost($blogPost);
        $blogPost->update($attributes);

        // return back('/')->with('success', 'Post Updated');
        // return redirect('/');
        return redirect('/blog')
        ->with('success','Item created successfully!');
    }
    
    public function destroy(BlogPost $blogPost) { 
        
        // delete a post
        $blogPost->delete();

        // return  back('/')->with('success', 'Post Deleted');
        return redirect('/');
    }


    protected function validatePost(?BlogPost $blogPost = null): array
    {
          $blogPost ??= new BlogPost();
        return request()->validate([
            'title' => 'required',
            'body' => 'required',

        ]);
    }
}
