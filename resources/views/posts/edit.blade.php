@extends('layouts.app')
@section('content')
 <center><h1>Create Post</h1></center>
    {!! Form::open(['action'=>['PostsController@update',$post->id],'method'=>'POST','enctype'=>'multipart/form-data']) !!}
    <div class='form-group'>
        {{ Form::label('title','Title')}}
        {{ Form::text('title',$post->title,['class'=>'form-control','placeholder'=>'Title for your Post'])}}
        <br>
        {{ Form::label('body','Content')}}
        {{ Form::textarea('body',$post->body,['class'=>'form-control','placeholder'=>'Content of your Post'])}}
        <br>
        {{ Form::file('cover_image')}}
        {{ Form::hidden('.method','PUT')}}
        {{ Form::submit('submit',['class'=>'btn btn-primary'])}}
    </div>
    
    {!! Form::close() !!}
@endsection