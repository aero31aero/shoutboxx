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

$num_row=0;
$num_row = mysqli_num_rows($result);

if( $num_row >=1 ) { 
    //$_SESSION['user_name']=$username;
    
    while($tag_row = mysqli_fetch_array($result)) {
        
        $sql = "SELECT postid,mid,creator,message,created_time,fullimage FROM posts WHERE message LIKE '%". $tag_row['tag'] . "%' AND ismessage=TRUE;";
        //echo $sql;
        
        $result1 =$conn->query($sql);

        $num_row=0;
        $num_row = mysqli_num_rows($result1);

        if( $num_row >=1 ) { 
            //$_SESSION['user_name']=$username;

            while($post_row = mysqli_fetch_array($result1)) {                
                $output=$output. "<li class='post' postid=" . $post_row['postid'] . "><div class='options'><span onclick=\"window.open('https://www.facebook.com/" . $post_row['mid'] . "'); return false;\"><i class='material-icons'>reply_all</i></span><span class='bookmarks'><i class='material-icons'>bookmark_border</i></span></div><div class='postcontent'><h3>" . $post_row['creator'] . $post_row['created_time'] . "</h3><p>" . $post_row['message'] . "</p><p><img src='" . $post_row['fullimage'] . "'/></p></div></li>";
            }

        }
        else{
          // echo "fail 1";
            
            
            
            
            
        } 
        
    }
    echo $output;
    
}
else{
   $sql = "SELECT postid,creator,message,created_time FROM posts;";
             //echo $sql;

            $result2 =$conn->query($sql);

            $num_row=0;
            $num_row = mysqli_num_rows($result2);

            if( $num_row >=1 ) { 
                //$_SESSION['user_name']=$username;

                while($post_row = mysqli_fetch_array($result2)) {                
                    $output=$output. "<li class='post' postid=" . $post_row['postid'] . "><div class='options'><span onclick=\"window.open('https://www.facebook.com/" . $post_row['mid'] . "'); return false;\"><i class='material-icons'>reply_all</i></span><span class='bookmarks'><i class='material-icons'>bookmark_border</i></span></div><div class='postcontent'><h3>" . $post_row['creator'] . $post_row['created_time'] . "</h3><p>" . $post_row['message'] . "</p></div></li>";
                }

            }
            else{
               //echo "fail 1";

            } 
}      
   
		
$conn->close();
?>