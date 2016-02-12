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


$sql = "SELECT postid,mid,creator,message,created_time,fullimage FROM posts WHERE (";
$arrlength = count($tagarray);
for($x = 0; $x < $arrlength-1; $x++) {
    $sql= $sql . "message LIKE '%". $tagarray[$x] . "%' OR  ";
}
$sql= $sql . "message LIKE '%". $tagarray[$arrlength-1] . "%') AND  ";
$sql= $sql . "ismessage=TRUE ORDER BY created_time DESC";
        //echo $sql;
        
        $result1 =$conn->query($sql);

        $num_row=0;
        $num_row = mysqli_num_rows($result1);

        if( $num_row >=1 ) { 
            //$_SESSION['user_name']=$username;

            while($post_row = mysqli_fetch_array($result1)) {                
                $output=$output. "<li class='post' postid=" . $post_row['postid'] . "><div class='options'><span onclick=\"window.open('https://www.facebook.com/" . $post_row['mid'] . "'); return false;\"><i class='material-icons'>reply_all</i></span><span class='bookmarks'><i class='material-icons'>bookmark_border</i></span></div><div class='postcontent'><h3>" . $post_row['creator'] . $post_row['created_time'] . "</h3><p>" . $post_row['message'] . "</p>";
                if($post_row['fullimage']!=NULL){
                    $output= $output . "<p><img width='460px' src='" . $post_row['fullimage'] . "'/></p>";   
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