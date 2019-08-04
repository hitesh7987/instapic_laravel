@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    Welcome {{auth()->user()->name}} ! You are logged in. <br><br> 
                @if (count($posts)>0)
                 <table class="table table-striped">
                     <th>Title</th>
                     <th></th>
                @foreach ($posts as $item)
                    <tr>
                    <td><a href="/posts/{{$item->id}}">{{$item->title}}</a></td>
                    <td><a href="/posts/{{$item->id}}/edit" class="btn btn-link">Edit</a>
                    {!! Form::open(['action'=>['PostsController@destroy',$item->id],'method'=>'POST']) !!}
                    {{ Form::hidden('.method','DELETE')}}
                    {{ Form::submit('Delete',['class'=>'btn btn-link'])}}
                    {!! Form::close() !!}                    
                    </td>
                    </tr>
                @endforeach     
                </table>                    
                @endif
                <a href="/posts/create" class="btn btn-primary" style="float:right"> Create Post</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
