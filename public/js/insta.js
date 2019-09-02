//////Sending friend request
function sendRequest(id, ele){
    $(".loader").css("display","block");
    var data =$(ele).parent().serialize();
    $.ajax({
        type : "POST",
        url : '/insta/sendRequest',
        data : data, 
    }).done(function(data){
        $(".loader").css("display","none");
        alert("Request sent");
    }).fail(function(){
        $(".loader").css("display","none");
        alert("Error while sending request.");
    });
   
}
//////Showing Friends
function showPeople(id){
    $.ajax({
        url : '/insta/'+id+'/view_people'
    }).done(function(data){
        $(".tab-content").html(data);
    }).fail(function(){
        alert("Can't show you them right now..")
    });
}
function showPendingRequest(id){
$.ajax({
    url : '/insta/'+id+'/view_pendingRequest'
}).done(function(data){
    $(".tab-content").html(data);
}).fail(function(){
    alert("Error showing pending request..")
});
}

function showSentRequest(id){
    $.ajax({
        url : '/insta/'+id+'/view_sentRequest'
    }).done(function(data){
        $(".tab-content").html(data);
    }).fail(function(){
        alert("Error loading sent request..")
    });
}

function showFriends(id){
    alert(id);
    $.ajax({
        url : '/insta/'+id+'/view_friends'
    }).done(function(data){
        $(".tab-content").html(data);
    }).fail(function(){
        alert("Error loading your friends..")
    });

}

//////Scrolling function of navbar
    $(document).ready(function(){
        if(document.title == "Instapic: Home"){
        var fixme = $('#fixme').offset().top;
        $(window).scroll(function(){
            var currscroll = $(window).scrollTop();
            if (currscroll >= fixme){
            //alert('if..'+currscroll+' ... '+ fixme);
                $('#fixme').css({
                    background : 'white',
                    position : 'fixed',
                    top : '0'
                });
            }
            else{          
                $('#fixme').css({
                    position : 'static'
                });
            }
        });
    }
    });
/////side button hovering function
    function reseticon(obj){
       // var obj = document.getElementById(elem.id);
        if(obj.id == "sidebutton_posts"){
            obj.innerHTML = "<span class='glyphicon glyphicon-globe'></span>";
        }
        if(obj.id == "sidebutton_friends"){
            obj.innerHTML = "<span class='glyphicon glyphicon-user'></span>";
        }
    }
    function changetext(obj){
      //  var obj = document.getElementById(elem.id);
      if(obj.id == "sidebutton_friends"){
        obj.innerHTML = "<span class='glyphicon glyphicon-user'></span>"+"  Friends";
    }  
      if(obj.id == "sidebutton_posts"){
            obj.innerHTML = "<span class='glyphicon glyphicon-globe'></span>"+"  Posts";
        }
       
    }
////preview image for post your pic function
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
//////Post comment........
    function post_comment(ele){
        var data = $(ele).parent().parent().parent().serialize();
        $.post('/insta/post_comment', data,function(){
             alert('Comment posted.');
             $(":text").val('');
         });
         
    }
/////Load comments......
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