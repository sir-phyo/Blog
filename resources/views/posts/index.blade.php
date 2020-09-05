@extends('layouts.app')

@section('content')
<h1>Posts</h1>
     @if(count($posts)>0)
     <div class="card">
       <ul class="list-group list-group-flush">
      @foreach($posts as $post)
      <div class="row">
        <div class="col-md-5">
          <img style="width: 100%" src="/storage/cover_images/{{$post->cover_image}}" alt="">
        </div>
          <div class="col-md-7">
              <div><h3>Comments</h3></div>
                  @foreach($post->cmt as $comment)
              <div style="width: 100%;height: auto;overflow: hidden;margin-bottom: auto" >
                  <span style="line-height: 34px">{{$comment->comment}}</span>
                  @if(!Auth::guest())
                      {!! Form::open(['action' => ['CmtController@destroy',$comment->id],'method' => 'POST', 'style' => 'float: right']) !!}
                      {{Form::hidden('_method','DELETE')}}
                      {{Form::submit('Delete',['class' => 'btn btn-danger','style' => 'float:right'])}}
                      {!! Form::close() !!}
                  @else
                      {!! Form::open(['action' => ['CmtController@destroy',$comment->id],'method' => 'POST', 'style' => 'float: right']) !!}
                      {{Form::hidden('_method','DELETE')}}
                      {{Form::submit('Delete',['class' => 'btn btn-danger','style' => 'float:right'])}}
                      {!! Form::close() !!}
                      <a href="{{ route('posts.show', ['post' => $post, 'commentId' => $comment]) }}" class="btn btn-default" style="float: right">Edit</a>
                  @endif
              </div>
                  @endforeach
          </div>
        <div class="col-md-8 d-flex pt-2 " >
          <h3><a href="/posts/{{$post->id}}" class="pl-3">{{$post->title}}</a></h3>
            @if(Auth::guest())
            <h3><a href="/posts/{{$post->id}}" class=" pl-3">Comment</a></h3>
            @endif
            <small class="pt-2 pl-3">Written on {{$post->created_at}}</small>
        </div>
      </div>

       @endforeach
       </ul>
    </div>
     @else
     @endif
@endsection
