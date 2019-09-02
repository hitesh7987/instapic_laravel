<?php

namespace App\Http\Controllers\Insta;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;
use App\Models\Photo_comment;
use App\Models\UserProfile;
use App\User;
use App\Models\Relationship;

class InstaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /////////////INSTA HOME//////////////
    public function home(){
        $photos = Photo::orderBy('updated_at','desc')->paginate();
        $image = 'noimage.jpg';
        if(null != (auth()->user()->user_profile)){
            $image = auth()->user()->user_profile->profile_photo;
            return view('Insta/insta_home')->with('profile_image',$image)->with('photos',$photos);
        }
        else{
            return view('Insta/insta_home')->with('profile_image',$image)->with('photos',$photos);
        }
    }
    public function upload_profile(Request $request){
        $this->validate($request,[
            'insta_image' => 'image|max:1999|nullable',
        ]);
        if($request->hasFile('insta_image')){
            //storing image
            $fileNameWithExt = $request->file('insta_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
            $fileExt = $request->file('insta_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            $path = $request->file('insta_image')->storeAs('public/insta_images',$fileNameToStore);
            //checking for description of image
            $description = ' ';
            if($request->has('description')){
               $description = $request->input('description');  
            } 
            
            ///saving it to database
            $photo = new Photo;
            $photo->user_id = auth()->user()->id;
            $photo->description = $description;
            $photo->image_name = $fileNameToStore;
            $photo->save();
            //making it profile photo
            if(null != (auth()->user()->user_profile)){
            $profile = auth()->user()->user_profile;
            $profile->user_id = auth()->user()->id;
            $profile->profile_photo = $fileNameToStore;
            $profile->save();
           }
           else{
            $profile = new UserProfile;
            $profile->user_id = auth()->user()->id;
            $profile->profile_photo = $fileNameToStore;
            $profile->save();
           }
            
            return redirect('/insta')->with('success',''.$request->file('insta_image')->getClientOriginalName().' is now your profile photo.');
        }
        else{
            return redirect('/insta')->with('error','You have not selected any image.');
        };
    }
    public function upload_post(Request $request){
        $this->validate($request,[
            'post_image'=> 'image|max:1999|required',
        ]);
        $fileNameWithExt=$request->file('post_image')->getClientOriginalName();
        $fileName=pathinfo($fileNameWithExt,PATHINFO_FILENAME);
        $fileExt= $request->file('post_image')->getClientOriginalExtension();
        $fileNameToStore= $fileName.'_'.time().'.'.$fileExt;
        $path = $request->file('post_image')->storeAs('public/insta_images',$fileNameToStore);
            //checking for description of image
            $description = ' ';
            if($request->has('post_description')){
               $description = $request->input('post_description');  
            } 
        $photo = new Photo;
        $photo->user_id = auth()->user()->id;
        $photo->description = $description;
        $photo->image_name = $fileNameToStore;
        $photo->save();
        
        return redirect('/insta')->with('success','Post uploaded.');
    }
    public function delete_post($id){
        $photo = Photo::find($id);
        if((auth()->user()->id) == $photo->user->id){
            Storage::delete('/public/insta_images/'.$photo->image_name);
            $photo->delete();
            return redirect('/insta')->with('success','Post deleted.');
        }else{
            return redirect('/insta')->with('error','Sorry it can not be deletd.');
        }
    }
    public function post_comment(Request $request){
        if(!auth()->guest()){
        $comment = new Photo_comment;
        $comment->user_id = auth()->user()->id;
        $comment->photo_id = $request->input('photo_id');
        $comment->message = $request->input('photo_comment');
        $comment->save();
        return 'success';
        //return redirect('/insta')->with('success','Comment posted successfuly.');
        }
    }
    public function photo_comment($photo_id){
        $comments = Photo_comment::where('photo_id',$photo_id)->orderBy('updated_at','desc')->paginate(3);
        return view('Insta\comments')->with('comments',$comments)->render();
    }
/////////INSTA FRIENDS//////////////
    public function friends($id){
        return view('Insta/insta_friends')->with('id',$id);
    }
    public function view_friends($id){
       return view('Insta/test')->render();
    }
    public function view_pendingRequest($id){

    }
    public function view_sentRequest($id){

    }
    public function view_people($id){
        $users = User::where('id','!=', auth()->id())->get();
        return view('Insta\test')->with('users', $users)->render();
   
    }
    public function sendRequest(Request $request){
        $relation = new Relationship;
        $relation->sender = auth()->user()->id;
        $relation->receiver = $request->input('receiver_id');
        $relation->status = 1;
        $relation->action_userid = auth()->user()->id;
        $relation->save();
        return 'success';
     //   return redirect('/insta'.'/'. auth()->user()->id .'/friends')->with('success', 'Request sent.');
    }
}
