<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    public function index() 
    {
        $posts = Post::orderBy('title','asc')->paginate(2);
        return view('posts.post')->with('posts',$posts);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required',
            'cover_image'=>'image|max:1999|nullable'
        ]);
        if($request->hasFile('cover_image')){
         //Get file name with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
         // Get only file name
            $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
        // Get extension 
            $fileExtension = $request->file('cover_image')->getClientOriginalExtension();
        //file name to store
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExtension;
        //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore); 
        }else{
            $fileNameToStore = 'noimage.jpg';
        }
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();
        return redirect('/posts')->with('success','Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if(auth()->user()->id != $post->user_id){
            return redirect('/posts')->with('error','Unauthorised page');
        }
        return view('posts.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required',
            'cover_image'=>'image|max:1999|nullable'
        ]);
        if($request->hasfile('cover_image')){
         //Get file name with extension
         $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
         //Get File name only
         $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
         //get file extension
         $fileExt = $request->file('cover_image')->getClientOriginalExtension();
         //file name to store
         $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
         //upload file
         $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
        }else{
            $flieNameToStore = 'noimage.jpg';
        }
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->cover_image = $fileNameToStore;
        $post->save();
        return redirect('/posts')->with('success','Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::find($id);
        if(auth()->user()->id != $post->user_id){
            return redirect('/posts')->with('error','Unauthorised page');
        }
        if($post->coveriamge != 'noimage.jpg'){
         Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with("success",'Post Deleted');
    }
}
