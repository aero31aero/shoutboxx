

<html>
<head>
  <title>Shoutboxx Crawler</title>
  
</head>
<link rel="stylesheet" type="text/css" href="index.css">
<script> </script>
<body>
<div class="container">
  <div class="card"></div>
  <div class="card">
    <h1 class="title">Login</h1>
    
      <div class="input-container">
        <input type="text" id="Username" required="required"/>
        <label for="Username">Username</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="password" id="Password" required="required"/>
        <label for="Password">Password</label>
        <div class="bar"></div>
      </div>
      <div class="button-container">
        <button><span>Go</span></button>
      </div>
      <div class="footer"><a href="#">Forgot your password?</a></div>
    
  </div>
  <div class="card alt">
    <div class="toggle">New</div>
    <h1 class="title">Register
      <div class="close"></div>
    </h1>
    
      <div class="input-container">
        <input type="text" id="name" required="required"/>
        <label for="Name">Name</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="text" id="bitsid" required="required"/>
        <label for="BITS Id">BITS Id</label>
        <div class="bar"></div>
      </div>
      <div class="input-container">
        <input type="password" id="password" required="required"/>
        <label for="Password">Password</label>
        <div class="bar"></div>
      </div>
      <div class="button-container">
        <button id='regbutt'><span>Register</span></button>
      </div>
    
  </div>
</div>
<div id="main"> 
  <div id='wrapper'>
  <div id='search_wrapper'><input id='searchbar' placeholder="Search"/></div>
  <div id='scrollable'> 
  <div id='post_wrapper'>
          
  </div>
  </div>
  <div id='compose'>
    <div class="composer" id='composer'>
      <div class='header'>New Post<span id='close_composer'>&#10005;</span></div>
      <div class="direct"><span>Direct:</span><input/></div>
      <textarea></textarea>
      <div class="extras"></div>
    </div>
    <div class="button inactive material-icons" id='open_composer'>insert_drive_file</div>
    <div class="button inactive material-icons" id='publish_comp'>send</div>
  </div>  
  </div>
  <div id='sidebar'>
  <h3>Filters</h3>
    <div id="tags">
    </div>
    <div class='input_wrapper'>
      <input placeholder="Search Preferences"/>
    </div>
  </div>
</div>
</body>
    
<script type="text/javascript" src="jquery.min.js"> 
</script>
<script type="text/javascript" src="index.js"> 
</script>
    <script><?php session_start(); 
if($_SESSION['userid']){
echo 'var curuser="' . $_SESSION['userid'] . '";';
}?>
if(curuser!= undefined || usernameshit!= null){
        main.classList.add('active');
        window.setTimeout(function(){document.getElementById('open_composer').style.display='block';},1000);
    
    // code to log out
        <?php session_start(); $_SESSION['userid'] == null; session_destroy(); ?>
    //
         alert("Welcome " + curuser);

}
        
    </script>
</html>
