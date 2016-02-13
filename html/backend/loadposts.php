<?php
//session_start();
require_once 'configuration.php';

try {   
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    
} catch (Exception $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$userid=mysql_escape_string($_GET['userid']);

$sql = "SELECT tag FROM tags WHERE userid=$userid;";
$output="";
$result =$conn->query($sql);
$tagarray[0]=" ";
$tagcount=0;
$num_row=0;
$num_row = mysqli_num_rows($result);

if( $num_row >=1 ) { 
    //$_SESSION['user_name']=$username;
    
    while($tag_row = mysqli_fetch_array($result)) {
        $tagarray[$tagcount]=$tag_row['tag'];
        //echo $tagarray[$tagcount];
        $tagcount=$tagcount + 1;        
        
    }
   
    
}
else{
   
}  


$sql = "SELECT postid,mid,creator,message,created_time+ interval 30 minute + interval 5 hour as created_time,fullimage FROM posts WHERE (";
$arrlength = count($tagarray);
for($x = 0; $x < $arrlength-1; $x++) {
    $sql= $sql . "message LIKE '%". $tagarray[$x] . "%' OR  ";
}
$sql= $sql . "message LIKE '%". $tagarray[$arrlength-1] . "%') AND  ";
$sql= $sql . "ismessage=TRUE ORDER BY created_time DESC LIMIT 50";
        //echo $sql;
        
        $result1 =$conn->query($sql);

        $num_row=0;
        $num_row = mysqli_num_rows($result1);

        if( $num_row >=1 ) { 
            //$_SESSION['user_name']=$username;

            while($post_row = mysqli_fetch_array($result1)) {                
                $output=$output. "<li class='post' postid=" . $post_row['postid'] . "><div class='options'><span onclick=\"window.open('https://www.facebook.com/" . $post_row['mid'] . "'); return false;\"><i class='material-icons'>reply_all</i></span><span class='bookmarks'><i class='material-icons'>bookmark_border</i></span></div><div class='postcontent'><span class='details'><span class='author'>" . $post_row['creator'] . "</span><span class='date'>" . $post_row['created_time'] . "</span></span><div class='message'>" . $post_row['message'] . "</div>";
                if($post_row['fullimage']!=NULL){
                   /* 
   <img src="thumbnails.jpg" />
</a>*/
                    $output= $output . "<p>" . '<div class="image-link">' . "<img width='460px' src='" . $post_row['fullimage'] . "'/></div></p>";   
                }
                $output= $output . "</div></li>";
                
            }

        }
        else{
          // echo "fail 1";
            
            
            
            
            
        }
 echo $output;

   
		
$conn->close();
?>
