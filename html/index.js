var container=document.getElementsByClassName('container')[0],
close=document.getElementsByClassName('close')[0],
toggle=document.getElementsByClassName('toggle')[0],
buttons=container.getElementsByTagName('button'),
main=document.getElementById('main'),
sidebar=document.getElementById('sidebar');
prefIn=sidebar.getElementsByTagName('input')[0];
tagHolder=document.getElementById('tags');
posts=document.getElementsByClassName('post');
refreshTags();
var curuserid=0;

//getXMLHTTPrequest
function getRequest(){
    var request= new XMLHttpRequest();
    return request;
}

//code for showing and hiding buttons on posts
function onPostLoad(){
    console.log("FUNCTION CALLED");
    posts=document.getElementsByClassName('post');
    console.log(posts.length);
    for(i=0;i<posts.length;i++)
    {
        posts[i].onmouseover=function(){
            this.classList.add('active');
            console.log("MOUSE IS HERE");
        }
        posts[i].onmouseout=function(){
            this.classList.remove('active');    
        }
    }
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
    toggle.innerHTML="New";
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
    var params="backend/register.php?username=" + username +"&password=" + password + "&bitsid=" + bitsid ;
    request.open("POST",params,true);
    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    request.setRequestHeader("Content-length",params.length);
    request.setRequestHeader("Connection","close");
    request.send();
    request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {                
                if(request.responseText!="fail"){
                    curuserid=request.responseText;
                    loadposts();
                    bringmain();                    
                }
            }
        };    
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
                    loadtags();
                    loadposts();
                    bringmain();                    
                }
            }
        };
}

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
                    document.getElementById("tags").innerHTML=document.getElementById("tags").innerHTML + request.responseText;
                    console.log(request.responseText);
                    refreshTags();
                    //appendChild(request.responseText);
                                        
                }
            }
        };
}

function loadposts(){
    var request= getRequest();
    
    var params="backend/loadposts.php";
    request.open("GET",params,true);
    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    request.setRequestHeader("Content-length",params.length);
    request.setRequestHeader("Connection","close");
    request.send();   
    request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {                
                if(request.responseText!="fail"){
                    document.getElementById("post_wrapper").innerHTML=document.getElementById("post_wrapper").innerHTML + request.responseText;
                    console.log(request.responseText);
                    //appendChild(request.responseText);
                                        
                }
            }
        };
    onPostLoad();
    console.log(posts.length);
}

    function bringmain(){
        //check validation before executing here
        //alert("moreshit");
        //if(main.getAttribute('id')='regbutt'){
        //    alert('shit happened');
        //}
        main.classList.add('active');
        window.setTimeout(function(){document.getElementById('open_composer').style.display='block';},1000);
            
}


//code to add new tags
  var counter=1;
  prefIn.onkeypress=function(e){
    if(e.keyCode==13)
    {
        var request= getRequest();
        var params="backend/addtag.php?userid="+curuserid+"&tag=" + this.value ;
        request.open("POST",params,true);
        request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        request.setRequestHeader("Content-length",params.length);
        request.setRequestHeader("Connection","close");
        request.send();       
        var newTag=document.createElement('li');
        newTag.setAttribute('index',++counter);
        newTag.innerHTML='<span>&#10005;</span>'+this.value;
        tagHolder.appendChild(newTag);
        refreshTags();
        this.value="";
    }
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
  function refreshTags()
{
  tags=tagHolder.getElementsByTagName('span');
    for(i=0;i<tags.length;i++)
    {
        
//code to remove tags       
        tags[i].onclick=function(){
            console.log("This is removed: " + this.parentNode);
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
  document.getElementById('composer').classList.add('active');
  this.style.display='none';
  document.getElementById('publish_comp').style.display='block';
}
document.getElementById('publish_comp').onmouseup=function(){
  //execute publishing script here 
}
// session management
