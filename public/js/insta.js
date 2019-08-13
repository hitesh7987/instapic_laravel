//////Scrolling function of navbar
    $(document).ready(function(){
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
    });
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