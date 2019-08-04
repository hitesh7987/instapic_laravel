@extends('layouts.app')
@section('content')
 <center><h1>Create Post</h1></center>
    {!! Form::open(['action'=>'PostsController@store','method'=>'POST','enctype'=>'multipart/form-data']) !!}
    <div class='form-group'>
        {{ Form::label('title','Title')}}
        {{ Form::text('title','',['class'=>'form-control','placeholder'=>'Title for your Post'])}}
        <br>
        {{ Form::label('body','Content')}}
        {{ Form::textarea('body','',['class'=>'form-control','placeholder'=>'Content of your Post'])}}
        <br>
        {{ Form::file('cover_image')}}
        {{ Form::submit('submit',['class'=>'btn btn-primary'])}}
    </div>
    
    {!! Form::close() !!}
@endsection