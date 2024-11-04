<?php

namespace App\Http\Controllers;

use App\Models\blog;
use Illuminate\Http\Request;
// use Illuminate\Routing\Controllers\HasMiddleware;
// use Illuminate\Routing\Controllers\Middleware;

class BlogController extends Controller
{

        //MIDDLEWARE CONNECTIONS

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return blog::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    try{

        $blogsave = $request->validate([
            'title' => 'required|max:150',
            'body'=> 'required',
       ]); 

       if(!$blogsave){
            return response()->json([
                'status' => false,
                'message' => 'Blog Validation Error!',
            ]);
       }

    $blog = blog::create([
        'title' => $request->title, 
        'body'=> $request->body,
    ]);

       return response()->json([
            'status' => true,   
            'blog' => $blog,
            'Message' => 'Blog Uploaded'
       ]) ;    

    }catch(\Throwable $th){
        return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
        ],500);
    }
    
    }

    /**
     * Display the specified resource.
     */
    public function show(blog $blog)
    {
        return blog::all();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, blog $blog)
    {
        $blogupdate = $request->validate([
            'title' => 'required|max:255',  
            'body' => 'required| max:5255'
        ]);
        $blog->update( $blogupdate);

        return response()->json(['Blog Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(blog $blog)
    {
        $blog->delete();

        return response()->json([
            'message' => 'This blog was deleted!'
        ]);
    }
}
