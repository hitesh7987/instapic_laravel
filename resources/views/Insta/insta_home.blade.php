@extends('layouts.app')
@section('content')
<script type="text/javascript">     
        function preview_image(input){
            if(input.files && input.files[0]){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#modal_image').attr('src',e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        function func(elem){
        elem.style.display="none";    
        document.forms['myform'].style.display='inline-block';
        }
        function post_comment(ele){
            var data = $(ele).parent().parent().parent().serialize();
            $.post('/insta/post_comment', data,function(){
                 alert('Comment posted.');
                 $(":text").val('');
             });
             
        }
        function load_comments(id,ele){
            alert('loading comments');
            $.ajax({
                url : '/insta/'+id+'/comments'
            }).done(function(data){
                $(ele).parent().html(data);
            }).fail(function(){
                alert('Error loading comments.')
            });
        }
        $(function() {
    $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();

        var url = $(this).attr('href');  
        getArticles(url,this);
    });

    function getArticles(url,ele) {
        $.ajax({
            url : url  
        }).done(function (data) {
            $(ele).parent().parent().parent().html(data);  
        }).fail(function () {
            alert('Comments could not be loaded.');
        });
    }
});
</script>
 <div class="container">    
 <div class="row" style="padding:2%; box-shadow: 3px 3px 20px 8px blue;">
    <div class="col-md-4" style="text-align: center">
    <img class="img-circle" src="/storage/insta_images/{{$profile_image}}" width="150" height="120">
    </div>
    <div class="col-md-8"> 
    
        @if (!Auth::guest())
       <h3>{{Auth::user()->name}}</h3><br>
        @endif
<!--upload profile -->       
 <input type="button" value="Upload ProfilePhoto" class="btn btn-primary btn-lg" onclick="func(this)" />
 {!! Form::open(['name'=>'myform','action'=>'Insta\InstaController@upload_profile','method'=> 'POST','enctype'=>'multipart/form-data','style'=>'display:none']) !!}
 {{ Form::file('insta_image')}}
 <br>
 {{ Form::submit('Upload Photo',['class'=>'btn btn-primary btn-lg'])}}
 {!! Form::close() !!}
 <!--uplaod post --
 <input type="file" id="post_image" style="display:none;"/> -->
 <input type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target=".www"
        value="Post Your Pic" />
         
    </div>
 </div>
 </div>
 <br>
 @if (count($photos)>0)
 @foreach ($photos as $item)
 <div class='container' style="padding:2%; box-shadow: 3px 3px 20px 8px green;">
    <font size=3>
    <div class='row'>
    <div class="col-md-10">
            <img src="/storage/insta_images/{{$item->user->user_profile->profile_photo}}" class="img-circle" style="position:relative; width:5%; height:auto;">
        <b> {{$item->user->name}} </b> has posted a image =><br>
    <code> Uploaded at : {{$item->created_at }}</code>
    </div>
    <div class="col-md-2">
        @if (Auth::user()->id == $item->user->id)
        <a href="/insta/delete/{{$item->id}}" class="btn btn-success btn-lg " style="position:relative; margin-left:30%"><i class="glyphicon glyphicon-trash"></i>    Delete</a>
        @endif
    </div>
    </div>
    <p>{{$item->description}}</p>
    <div style="text-align: center">
    <img src="/storage/insta_images/{{$item->image_name}}" class="img-rounded" width="50%" height="auto">
    </div>
    <br>
    </font>
    <div class="comments" style="border: 1px solid lightblue;">
        <button class="btn btn-link" onclick="load_comments({{$item->id}},this)"> View Comments</button><br>
        @include('Insta\ajax_comments')
        @if ($item->latest_comment)
        <img src="/storage/insta_images/wolf.jpg" class="img-circle" style="width=30px; height:20px;">
        <b> {{$item->latest_comment->user->name}} : </b>{{$item->latest_comment->message}} <br>
        @endif
        </div>
<!-- Post Comment -->
    <div>{!! Form::open(['action'=>'Insta\InstaController@post_comment','method'=>'POST']) !!}
        <div class="row">
            <div class="col-md-10">
                {{ Form::text('photo_comment','',['class'=>'form-control','placeholder'=>'Post a comment..'])}}
                {{ Form::text('photo_id',$item->id,['style'=>'display:none;'])}}
            </div>
            <div class="=col-md-2">
                <input type="button" class="btn btn-primary" onclick="post_comment(this)" value="Post comment">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    
 </div>
@endforeach
 @endif
 {{$photos->links()}}
 <!-- modal -->
 <div class="modal fade www" id="post_modal" role="dialog">
        <div class="modal-dialog modal-lg">
                {!! Form::open(['action'=>'Insta\InstaController@upload_post','method' => 'POST', 'enctype'=>'multipart/form-data']) !!}
                 
            <div class="modal-content" style="padding:8px; box-shadow: 3px 3px 10px 8px pink;">
                <div class="modal-header">
                  {{ Form::file('post_image',['id'=>'post_image','onchange'=>'preview_image(this)'])}}  
                 <img src="" id="modal_image" class="img-rounded" style="width:60%; margin:auto;">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {{ Form::textarea('post_description',null,['class'=>'form-control','placeholder'=>'Say Something about the pic..'])}}
                   </div>
                <div class=:modal-footer style="text-align:right;">
                    {{ Form::submit('Post it !',['class'=>'btn btn-primary btn-lg'])}}
                    {!! Form::close() !!}
                   </div>
            </div>
        </div>
</div>

 
    
@endsection