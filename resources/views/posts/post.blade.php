@extends('layouts.app')
@section('content')
<center><h1><b> Posts </b></h1></center> 
@if (count($posts) > 0)
      <div class="card">
          <ul class="list-group list-group-flush"> 
               @foreach ($posts as $item)
               <div class="row">
                  <div class="col-md-4 col-sm-4">
                  <img style="width:50%" src="/storage/cover_images/{{$item->cover_image}}">
                  </div>
                  <div class="col-md-8 col-sm-8">
                  <li class="list-group-item"><a href="/posts/{{$item->id}}"><b>{{$item->user->name}} -> {{$item->title}} </b></a><br>
                   <small>Created at :  {{$item->created_at}}</small><br>
                  <small class="card-body">{{$item->body}}</small></li>
               </div>
            </div>
            
                  @endforeach
             </div>
             {{$posts->links()}}
@else
   <h1> No Posts found...</h1>
@endif
    
@endsection