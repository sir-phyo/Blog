<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post1;
use App\Http\Requests\Posts\StoreRequest;
use DB;

class PostsController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth',['except'=>['index','show']]);
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts =  Post1::all();
//        $posts = DB::select('SELECT * FROM post1s');
        $posts = Post1::all();
        return view('posts.index',['posts' => $posts]);
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
    public function store(StoreRequest $request)
    {
      // $this->validate($request,
      //       ['title'=>'required',
      //       'body'=>'required',
      //       'cover_image'=>'image|nullable|max:1999'
      //     ]);
      // dd($request->title);
          if($request->hasFile('cover_image')){
            //get file name with extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get just filename
            $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
            //get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$filenameToStore);
          }else{
            $filenameToStore='noimage.jpg';
          }

            $post=new Post1;
            $post->title= $request->input('title');
            $post->body= $request->input('body');
            $post->user_id= auth()->user()->id;
            $post->cover_image=$filenameToStore;
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
        $post = Post1::findOrFail($id);
        $comment = $post->cmt()->where('id', request('commentId'))->first();
        return view('posts.show', compact('post', 'comment'));
//        return view('posts.show', ['post' => $post, 'comment' => $comment ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post1 $post)
    {
      // $post = Post1::find($id);
      if(auth()->user()->id !== $post->user_id){
      return redirect('/posts')->with('error','Unauthorized Page');
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
      $this->validate($request,
            ['title'=>'required',
            'body'=>'required',
            'cover_image'=>'image|nullable|max:1999'
          ]);
          if($request->hasFile('cover_image')){
            //get file name with extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get just filename
            $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
            //get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$filenameToStore);
          }

            $post=Post1::find($id);
            $post->title= $request->input('title');
            $post->body= $request->input('body');
            if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','Unauthorized Page');
          }
            if($request->hasFile('cover_image')){
              $post->cover_image=$filenameToStore;
            }
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
        $post=Post1::find($id);
        if(auth()->user()->id !== $post->user_id){
        return redirect('/posts')->with('error','Unauthorized Page');
      }
      if($post->cover_image != 'noimage.jpg'){
        Storage::delete('/public/storage/'.$post->cover_image);
      }
        $post->delete();
        return redirect('/posts')->with('success','Post Removed');
    }
}
