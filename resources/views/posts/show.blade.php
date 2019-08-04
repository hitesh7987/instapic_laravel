@extends('layouts.app')
@section('content')
    <table align="center" class="table table-striped">
        <tr>
        <th>Title  </th>
        <th>{{$post->title}}</th>
        </tr>
        <tr>
            <td>Created By  </td>
        <td>{{$post->created_at}}</td>
        </tr>
        <tr>
            <td>Content  </td>
        <td>{{$post->body}}</td>
        </tr>
        <tr>
            <td>Cover Image  </td>
        <td><img style="width:50%" src="/storage/cover_images/{{$post->cover_image}}">}</td>
        </tr>
        <tr>
            <td></td>
            <td>
                <a href="/posts" class="btn btn-primary">Go back </a>
                @if(!Auth::guest())                    
                @if(Auth::user()->id == $post->user_id)
                
                <a href ="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit </a>
                {!! Form::open(['action'=>['PostsController@destroy', $post->id],'method'=>'POST','style'=>'float:right']) !!}
                {{ Form::hidden('.method','DELETE')}}
                {{ Form::submit('Delete',['class'=> 'btn btn-danger'])}}
                {!! Form::close() !!}
                @endif
                @endif
            </td>
        </tr>
    </table>
@endsection