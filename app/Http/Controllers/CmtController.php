<?php

namespace App\Http\Controllers;

use App\Cmt;
use Illuminate\Http\Request;
use DB;

class CmtController extends Controller
{
    public function index()
    {
        //$posts =  Post1::all();
        $comments = DB::select('SELECT * FROM cmts');
        return view('posts.index')->with('comments',$comments);
    }

    public function show($id)
    {
        $comment = Cmt::findOrFail($id);
        return view('posts.show')->with('comment',$comment);
    }

    public function store(Request $request)
    {
//        dd( request('post_id'));
        $this->validate($request,
                  ['comment'=>'required']);
        $comment=new Cmt;
        $comment->comment= $request->input('comment');
        $comment->post_id= request('post_id');
        $comment->save();

//        Cmt::create([
//            'comment' => request('comment'),
//            'post_id' => request('post_id')
//        ]);

//        $request->request->add(['sss' => bcrypt(request('password')]);
//        Cmt::create( request(['comment', 'post_id']) );

        return redirect('/posts')->with('success','Commented');
    }
    public function update(Request $request,$id){
        $this->validate($request,
            ['comment'=>'required']);
        $comment = Cmt::findOrFail($id);
        $comment->comment= $request->input('comment');
       // $comment->post_id= request('post_id');
        $comment->save();

        return redirect('/posts')->with('success','Comment Updated');
    }
    public function destroy(Request $request,$id){
        $comment = Cmt::findOrFail($id);
        $comment->delete();
        return redirect('/posts')->with('success','Comment Removed');

    }
}
