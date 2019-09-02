<div style=" display:flex;">
    <ul class="friend-list" style="color: blue; width : 100%; list-style : none; box-shadow : 0 0 10px 1px blue;">
        @foreach ($users as $user)
        <li>
            <div class="d-flex justify-content-between" style="padding:10px">
                <div>
                    @if (!empty($user->user_profile->profile_photo))
                    <img src="/storage/insta_images/{{$user->user_profile->profile_photo}}" height="60px" width="60px" style="border-radius : 50%;">                
                    @else
                    <img src="/storage/insta_images/noimage.jpg" height="60px" width="60px" style="border-radius : 50%;">       
                    @endif
                    <h3 style="display : inline;">&nbsp {{$user->name}}</h3>
                </div>
                {!! Form::open(['action' => 'Insta\InstaController@sendRequest', 'method'=>'POST'])!!}
            <input type="text" style="display : none" name="receiver_id" value="{{$user->id }}">
                <input type="button" class ="btn btn-primary" onclick="sendRequest({{$user->id}}, this)" value="Send Request">
            {!! Form::close() !!}
            </div>
        </li>  
        @endforeach       
    </ul>
</div>