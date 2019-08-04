@if (count($comments)>0)
@foreach ($comments->reverse() as $comment)
<img src="/storage/insta_images/wolf.jpg" class="img-circle" style="width=30px; height:20px;">
<b> {{$comment->user->name}} : </b>{{$comment->message}} <br>
@endforeach
{{$comments->links()}}    
@endif
