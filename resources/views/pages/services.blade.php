@extends('layout.layout1')
@section('content')
<center><h1>This is service page </h1></center>
    @if (count($service)>0)
    <ul class='list-group'>
    @foreach ($service as $item)
        <li class='list-group-item'>{{$item}}</li>
    @endforeach
    </ul>
    @endif
@endsection