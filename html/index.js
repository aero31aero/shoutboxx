var container=document.getElementsByClassName('container')[0],
close=document.getElementsByClassName('close')[0],
toggle=document.getElementsByClassName('toggle')[0],
buttons=container.getElementsByTagName('button'),
main=document.getElementById('main'),
sidebar=document.getElementById('sidebar');
searchbar=document.getElementById('searchbar');
prefIn=sidebar.getElementsByTagName('input')[0];
tagHolder=document.getElementById('tags');
refreshTags();



function loadToasterOptions(){
  toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": true,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "100",
  "timeOut": "10000",
  "extendedTimeOut": "0",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
} 
};
loadToasterOptions();
var curuserid=0;

//getXMLHTTPrequest
function getRequest(){
    var request= new XMLHttpRequest();
    return request;
}

//code for showing and hiding buttons on posts
function onPostLoad(){
    
    posts=document.getElementsByClassName('post');
    
    for(i=0;i<posts.length;i++)
    {
        
        posts[i].onmouseover=function(){
            this.classList.add('active');
            
        }
        posts[i].onmouseout=function(){
            this.classList.remove('active');    
        }
    }
    scrollable=document.getElementById('scrollable');
    scrollable.scrollTo(0,0);
}

//function for signup dialog box to open
toggle.onclick=function(){
    container.classList.add('active');
    toggle.innerHTML="";
}

//function for signup dialog box to close
close.onclick=function(){
    container.classList.remove('active');
    //toggle.innerHTML="&#9998;";
    toggle.innerHTML="add";
}

//set sidebar height to window height
sidebar.style.height=window.innerHeight;

//set the posts wrapper height to window height
document.body.onload=function(){
    window.scrollTo(0,0);
    sidebar.style.height=window.innerHeight;
    document.getElementById('wrapper').style.height=window.innerHeight; 
}

//update sidebar and posts wrapper heights on window resize
window.onresize=function(){
    sidebar.style.height=window.innerHeight;
    document.getElementById('wrapper').style.height=window.innerHeight;
}

var idclicked=null;
//for (var i = 0; i < buttons.length; i++) {
//    idclicked=buttons[i].getAttribute('id');
//    //console.log(buttons[i].getElementById('regbutt').toString);
//    
//    buttons[i].onclick=bringmain;
//    
//};
buttons[1].onclick=register;
buttons[0].onclick=login;

function register(){
    var request= getRequest();
    var username=document.getElementById('name').value;
    var bitsid=document.getElementById('bitsid').value;
    var password=document.getElementById('password').value;
    if(validatereg(username,bitsid,password)!="fail"){
  
        var params="backend/register.php?username=" + username +"&password=" + password + "&bitsid=" + bitsid ;
        request.open("POST",params,true);
        request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        request.setRequestHeader("Content-length",params.length);
        request.setRequestHeader("Connection","close");
        request.send();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {                
                if(request.responseText!="fail"){
                    toastr.success('You have been registered as ' + username + '.', 'Registration Successful');
                    container.classList.remove('active');
                    //toggle.innerHTML="&#9998;";
                    toggle.innerHTML="add";               
                    document.getElementById('Username').value=username;
                }
                if(request.responseText=="fail"){
    //                        swal({
    //                          title: "Username Exists",
    //                          text: "I'm sorry but the username you entered is already taken. Please try another username.",
    //                          type: "error",
    //                          confirmButtonText: "Okay!"
    //                        });
                        toastr.error('This username is already taken.', 'Username Taken');
                    }
                }
            }
    };    

}
function validatereg(username,bitsid,password){
       var nameRegex = /^[a-zA-Z\-\d]+$/;
    var bitsidRegex = /(f20)\d{5}/g;
    var validfirstUsername = username.match(nameRegex);
    var validbitsid = bitsid.match(bitsidRegex);
    if(validfirstUsername == null){
//        swal({
//              title: "Oops!",
//              text: "I'm sorry but the username you entered is invalid. Please make sure it contains only alphabets and numbers.",
//              type: "error",
//              confirmButtonText: "Okay!"
//        });
        toastr.error('Please use alphabets and numbers.', 'Username Invalid');
        return "fail";
    }
    if(validbitsid == null || bitsid.length!=8 ){
//        swal({
//              title: "Oops!",
//              text: "I'm sorry but the username you entered is invalid. Please make sure it contains only alphabets and numbers.",
//              type: "error",
//              confirmButtonText: "Okay!"
//        });
        toastr.error('Please enter the ID in the format mentioned.', 'Bits ID Invalid');
        return "fail";
    }
    if(password.length < 8 || password.length > 40){
//        swal({
//             title: "Oops!",
//             text: "I'm sorry but the password you entered is too short. .",
//             type: "error",
//             confirmButtonText: "Okay!"
//        });
        toastr.error('Enter a password between 8 and 40 characters.', 'Password Invalid');
        return "fail";
    }
    
   
    return "shit";
}

function onpasspress(e){
    if(e.keyCode === 13){
            login();
        }

        return false;
}
function login(){
    var request= getRequest();  
    var username=document.getElementById('Username').value;    
    var password=document.getElementById('Password').value;
    var params="backend/login.php?username=" + username + "&password=" + password;   
    request.open("GET",params,true);
    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    request.setRequestHeader("Content-length",params.length);
    request.setRequestHeader("Connection","close");
    request.send();   
    request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {                
                if(request.responseText!="fail"){
                    
                    curuserid=request.responseText;
                    //setusercookie(request.responseText);
                    loadtags();
                    bringmain();                    
                    loadposts();
                    toastr.success('You have been logged in as ' + username + '.', 'Authentication Successful');
                }
                else{
                    toastr.error('Please check your username and password.', 'Authentication Failed');
                }
            } 
        };
}
/*function setusercookie(var userid){
    document.cookie="userid=" + userid;
}
function killusercookie(){
    document.cookie="userid=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    location.reload;
}
    if (document.cookie.indexOf("userid") >= 0) {

        alert("Welcome");
        bringman();
    }
    else {

    }*/
    
function loadtags(){
    var request= getRequest();
    
    var params="backend/loadtags.php?userid=" + curuserid;
    request.open("GET",params,true);
    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    request.setRequestHeader("Content-length",params.length);
    request.setRequestHeader("Connection","close");
    request.send();   
    request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {                
                if(request.responseText!="fail"){
                    document.getElementById("tags").innerHTML=request.responseText;
                    //console.log(request.responseText);
                    refreshTags();
                    //appendChild(request.responseText);
                                        
                }
            }
        };
}

function loadposts(){
    var request= getRequest();
    
    var params="backend/loadposts.php?userid=" + curuserid;
    request.open("GET",params,true);
    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    request.setRequestHeader("Content-length",params.length);
    request.setRequestHeader("Connection","close");
    request.send();   
    request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {                
                if(request.responseText!="fail"){
                    document.getElementById("post_wrapper").innerHTML=request.responseText;
                    onPostLoad();
                    popUps();
                    //appendChild(request.responseText);
                                        
                }
            }
        };
    
}
function loadallposts(){
    
    var request= getRequest();
        var params="backend/addtag.php?userid="+curuserid+"&tag=all-posts" ;
        var valueoftag=this.value;
        this.value="";
        //alert(valueoftag);
        request.open("POST",params,true);
        request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        request.setRequestHeader("Content-length",params.length);
        request.setRequestHeader("Connection","close");
        request.send();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {                
                if(request.responseText!="fail"){                    
                    console.log(request.responseText+" HELLO");
                    loadtags();
                    loadposts();
                    toastr.success('Remove the \'all-posts\' tag when done.', 'Showing All Posts');
                }
            }
        };
    
}
var $popped=null;
var images=document.getElementsByClassName('image-link');
/*for(i=0;i<images.length;i++)
    {
        images[i].onclick=function(){
            zoomed=document.createElement('div');
            zoomed.backgroundImage='url('+this.src+')';
            zoomed.classList.add('popUp');
            zoomed.style.left=this.clientLeft;
            zoomed.style.top=this.clientTop;
            zoomed.style.height=this.clientHeight;
            zoomed.style.width=this.clientW;
        }
    }*/

function popUps(){
    $('.image-link>img').click(function(){
    $popped=$(this);
    $zoomed=$(this).clone();
    $zoomed.addClass('popUp');
    $zoomed.removeClass('image-link');
    $(this).css({opacity:0});
    $zoomed.css({
        top:$(this).offset().top,
        left:$(this).offset().left,
        height:$(this).height(),
        width:$(this).width()
    });
        $('body').append($zoomed);
        h=window.innerHeight-100;
        $zoomed.css({height:h+'px',width:(h/($(this).height()/$(this).width()))+'px'});
        $zoomed.addClass('final');
        $('#main').addClass('inactive');
        $('#closePop').show(100);
        $('#overlay').css({display:'block'});
    });
};
$('#closePop').click(function(){
    $('.popUp').remove();
    $('#main').removeClass('inactive');
    $popped.css({opacity:1});
    $('#overlay').css({display:'none'});
    $('#closePop').hide();
});

function bringmain(){
    //check validation before executing here
    //alert("moreshit");
    //if(main.getAttribute('id')='regbutt'){
    //    alert('shit happened');
    //}
    main.classList.add('active');
    window.setTimeout(function(){document.getElementById('open_composer').style.display='block';
                                document.getElementById('button_drawer').style.display='block';},1000);
            
}


//code to add new tags
  var counter=1;
  prefIn.onkeypress=function(e){
    if(e.keyCode==13)
    {
        var request= getRequest();
        var params="backend/addtag.php?userid="+curuserid+"&tag=" + this.value ;
        var valueoftag=this.value;
        this.value="";
        //alert(valueoftag);
        request.open("POST",params,true);
        request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        request.setRequestHeader("Content-length",params.length);
        request.setRequestHeader("Connection","close");
        request.send();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {                
                if(request.responseText!="fail"){                    
                    console.log(request.responseText+" HELLO");
                    loadtags();
                    loadposts(); 
                    toastr.success('Added new tag \'' + valueoftag +'\'.', 'Tag Added');
                }
            }
        };
//        var newTag=document.createElement('li');
//        newTag.setAttribute('index',++counter);
//        tagHolder.appendChild(newTag);
//        newTag.innerHTML='<span>&#10005;</span>'+this.value;
//        refreshTags();
//        this.value="";                                        
    }
  }
  
  
  //code to implement search
  searchbar.onkeypress=function(e){
    
        var request= getRequest();
      console.log(this.value);
      var params="backend/loadposts.php?userid=" + curuserid;
      if(this.value.length>1){
            params="backend/searchposts.php?query=" + this.value ;
      }
        //var valueoftag=this.value;
        //this.value="";
        //alert(valueoftag);
        request.open("POST",params,true);
        request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        request.setRequestHeader("Content-length",params.length);
        request.setRequestHeader("Connection","close");
        request.send();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {                
                if(request.responseText!="fail"){                    
                    //console.log(request.responseText+" HELLO");
                    document.getElementById("post_wrapper").innerHTML=request.responseText;
                    onPostLoad();
                    popUps();                  
                }
            }
        };
      
  }
  
  var bookmarks=document.getElementsByClassName('bookmarks');
  for(i=0;i<bookmarks.length;i++)
      {
              bookmarks[i].onclick=function(){
              console.log("Clicked here: " + i);
              this.classList.toggle('active');
              if(this.classList.contains('active'))
                  this.getElementsByTagName('i')[0].innerHTML='bookmark';
              else
                  this.getElementsByTagName('i')[0].innerHTML='bookmark_border';
          }
      }
function refreshTags(){
  tags=tagHolder.getElementsByTagName('span');
    for(i=0;i<tags.length;i++)
    {
        
//code to remove tags       
        tags[i].onclick=function(){
            
            console.log("This is removed: " + this.parentElement.getAttribute('tagid'));
            var request= getRequest();
            var params="backend/removetag.php?userid=" + curuserid +"&tagid=" + this.parentElement.getAttribute('tagid');
            request.open("GET",params,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.setRequestHeader("Content-length",params.length);
            request.setRequestHeader("Connection","close");
            request.send();   
            request.onreadystatechange = function() {
                    if (request.readyState == 4 && request.status == 200) {                
                        if(request.responseText!="fail"){
                            console.log(request.responseText);
                            //appendChild(request.responseText);
                            loadposts();
                            toastr.success('Tag has been removed.', 'Tag Removed');
                        }
                    }
                };
            this.parentNode.parentNode.removeChild(this.parentNode);
        } 
    }
}

document.getElementById('close_composer').onclick=function(){
  document.getElementById('composer').classList.remove('active');
  var button=document.getElementById('compose_button');
  document.getElementById('publish_comp').style.display='none';
  document.getElementById('open_composer').style.display='block';

}

document.getElementById('open_composer').onmouseup=function(){
    //  document.getElementById('composer').classList.add('active');
    //  this.style.display='none';
    //  document.getElementById('publish_comp').style.display='block';
    swal({
          title: "How can we improve?",
          type: "input",
            inputType: "text",
          showCancelButton: true,
          closeOnConfirm: true,
          animation: "slide-from-bottom",
          "confirmButtonColor": "#0097a7",
          inputPlaceholder: "Write your suggestions here..."
    },
    function(inputValue){
      if (inputValue === false) return false;

      if (inputValue === "") {
            swal.showInputError("You need to write something!");
            return false
      }
      var request=getRequest();
      var params="backend/feedback.php?userid=" + curuserid +"&feedback=" + inputValue;
        request.open("GET",params,true);
        request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        request.setRequestHeader("Content-length",params.length);
        request.setRequestHeader("Connection","close");
        request.send();   
        request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {     

                        toastr.success('Thanks for your feedback!', 'Feedback Submitted');


                }
            };
    });
}
document.getElementById('publish_comp').onmouseup=function(){
  //execute publishing script here 
}

function logout(){
    console.log("sdf");
    var request= getRequest();
    
    var params="backend/logout.php?userid="+curuserid;
    request.open("GET",params,true);
    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    request.setRequestHeader("Content-length",params.length);
    request.setRequestHeader("Connection","close");
    request.send();   
    request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {                
                if(request.responseText="Done"){
                   //alert("Logged out");
                    location.reload();
                }
            }
    }
}

// session management