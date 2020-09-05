@extends('layouts.app')

@section('content')


<a href="/posts" class="btn btn-default">Go Back</a>
<h1>{{$post->title}}</h1>
<div class="row">
  <div class="col-md-10">
    <img style="width: 75%" src="/storage/cover_images/{{$post->cover_image}}" alt="">
  </div>
</div>
<p>{{$post->body}}</p>
<hr>
<small>Written on {{$post->created_at}}</small>
<hr>


@if(!Auth::guest())
  @if(Auth::user()->id == $post->user_id)
<a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
{!! Form::open(['action' => ['PostsController@destroy',$post->id],'method' => 'POST','class' => 'pull-right']) !!}
    {{Form::hidden('_method','DELETE')}}
    {{Form::submit('Delete',['class' => 'btn btn-danger'])}}
{!! Form::close() !!}
@endif
@else
    @if($comment)
        {!! Form::open(['action' => ['CmtController@update',$comment->id],'method' => 'POST','enctype'=> 'multipart/form-data']) !!}
        @method('PATCh')
    @else
        {!! Form::open(['action' => 'CmtController@store','method' => 'POST', 'enctype'=> 'multipart/form-data']) !!}
    @endif
    <div class="form-group">
        {{Form::label('comment','Comment')}}
        {{Form::textarea('comment', $comment->comment?? '',['class' => 'form-control','placeholder' => 'Comment'])}}
        <input type="hidden" name="post_id" value="{{ $post->id }}" >
    </div>

    {{Form::submit('Submit',['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endif
@endsection

