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
    for(i=0;i<posts.length;i++)
        {
            posts[i].onmouseover=function(){
                this.classList.add('active');
            }
            posts[i].onmouseout=function(){
                this.classList.remove('active');    
            }
        }
  toggle.onclick=function(){
    container.classList.add('active');
    toggle.innerHTML="";
  }
  close.onclick=function(){
    container.classList.remove('active');
    toggle.innerHTML="&#9998;";
  }
  sidebar.style.height=window.innerHeight;
  document.body.onload=function(){window.scrollTo(0,0);
                                  sidebar.style.height=window.innerHeight;
    document.getElementById('wrapper').style.height=window.innerHeight;
                                 }
  window.onresize=function(){
    sidebar.style.height=window.innerHeight;
    document.getElementById('wrapper').style.height=window.innerHeight;
      
  }
  for (var i = 0; i < buttons.length; i++) {
    buttons[i].onclick=bringmain;
  };
  document.getElementsByTagName('form').onsubmit=bringmain;
    function bringmain(){
      //check validation before executing here
      main.classList.add('active');
        window.setTimeout(function(){document.getElementById('open_composer').style.display='block';},1000);
    }
  var counter=1;
  prefIn.onkeypress=function(e){
    if(e.keyCode==13)
    {
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
        tags[i].onclick=function(){
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