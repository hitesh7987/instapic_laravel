@extends('layouts.app')
@section('title', 'Instapic: Friends')
@push('head')
<link rel="stylesheet" href="{{asset('/css/insta.css')}}">
<script src="{{asset('/js/insta.js')}}">
</script>
@endpush
@section('content')
<a href="#" class="btn btn-success btn-lg top-navigation_button"><span>&#8593</span> </a>
<ul style="position: fixed; z-index:50; left:0; list-style-type:none; top:40%">
    <li> <a class="btn btn-primary btn-lg side-button text-left" id = "sidebutton_posts" onmouseover="changetext(this)" onmouseout="reseticon(this)" href="/insta"><span class="glyphicon glyphicon-globe"></span></a></li>
    <br>
    <li> <a class="btn btn-primary btn-lg side-button text-left" id = "sidebutton_friends" onmouseover="changetext(this)" onmouseout="reseticon(this)" href="{{ route('friends',['id'=> Auth::id()]) }}"><span class="glyphicon glyphicon-user"></span></a></li>
    </ul> 
<ul role="tablist" class="nav nav-tabs">
    <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="" onclick="showFriends({{Auth::user()->id}})">Friends</a></li>
    <li class="nav-item"><a data-toggle="tab" href="" onclick="showPendingRequest({{Auth::user()->id}})" >Pending Request</a></li>
    <li class="nav-item"><a data-toggle="tab" href="" onclick="showSentRequest({{Auth::user()->id}})">Sent Request</a></li>
    <li class="nav-item"><a data-toggle="tab" href="" onclick="showPeople({{Auth::user()->id}})">People</a></li>
 </ul> 
   
<div class="tab-content">
        <h1>{{$id}}</h1>
</div>
    
@endsection