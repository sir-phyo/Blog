@extends('layouts.app')

@section('content')
    <h1>Comment Posts</h1>
    {!! Form::open(['action' => 'CommentController@store','method' => 'POST', 'enctype'=> 'multipart/form-data']) !!}

    <div class="form-group">
        {{Form::label('comment','Comment')}}
        {{Form::textarea('comment', '',['class' => 'form-control','placeholder' => 'Comment'])}}
    </div>

    {{Form::submit('Submit',['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
