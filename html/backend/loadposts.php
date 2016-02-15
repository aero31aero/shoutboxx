<?php
//session_start();
require_once 'configuration.php';
$limit=50;
try {   
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    
} catch (Exception $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$userid=mysql_escape_string($_GET['userid']);

$sql = "SELECT tag FROM tags WHERE userid=$userid and isactive=1;";
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
    //exception-handling-for-tags
    if(strcmp($tagarray[$x],"clubs-all")==0){
        
        $sql= $sql . "message LIKE '%dance %' OR ";
        $sql= $sql . "message LIKE '% elas %' OR message like 'elas %' OR ";
        $sql= $sql . "message LIKE '%designers anonymous%' OR ";
        $sql= $sql . "message LIKE '%music club%' OR ";
        $sql= $sql . "message LIKE '%movie club%' OR ";
        $sql= $sql . "message LIKE '%shades club%' OR ";
        $sql= $sql . "message LIKE '%vfx club%' OR ";
        $sql= $sql . "message LIKE '%martial arts club%' OR ";
        $sql= $sql . "message LIKE '%hindi tarang%' OR ";
        $sql= $sql . "message LIKE '%journal club%' OR ";
        $sql= $sql . "message LIKE '%bulls and bears club%' OR ";
        $sql= $sql . "message LIKE '%quiz club%' OR ";
        $sql= $sql . "message LIKE '%dramatics club%' OR ";
    }
    if(strcmp($tagarray[$x],"all-posts")==0){
        
        $sql= $sql . "message LIKE '%' OR ";
        $limit=100;
    }
    
    $sql= $sql . "message LIKE '%". $tagarray[$x] . "%' OR creator LIKE '%". $tagarray[$x] . "%' OR ";
}


//exception-handling-for-tags
    if(strcmp($tagarray[$arrlength-1],"clubs-all")==0){
        
        $sql= $sql . "message LIKE '%dance %' OR ";
        $sql= $sql . "message LIKE '% elas %' OR message like 'elas %' OR ";
        $sql= $sql . "message LIKE '%designers anonymous%' OR ";
        $sql= $sql . "message LIKE '%music club%' OR ";
        $sql= $sql . "message LIKE '%movie club%' OR ";
        $sql= $sql . "message LIKE '%shades club%' OR ";
        $sql= $sql . "message LIKE '%vfx club%' OR ";
        $sql= $sql . "message LIKE '%martial arts club%' OR ";
        $sql= $sql . "message LIKE '%hindi tarang%' OR ";
        $sql= $sql . "message LIKE '%journal club%' OR ";
        $sql= $sql . "message LIKE '%bulls and bears club%' OR ";
        $sql= $sql . "message LIKE '%quiz club%' OR ";
        $sql= $sql . "message LIKE '%dramatics club%' OR ";
    }
if(strcmp($tagarray[$x],"all-posts")==0){
        
        $sql= $sql . "message LIKE '%' OR ";
        $limit=100;
    }
$sql= $sql . "message LIKE '%". $tagarray[$arrlength-1] . "%' OR creator LIKE '%". $tagarray[$arrlength-1] . "%') AND  ";
$sql= $sql . "ismessage=TRUE ORDER BY created_time DESC ";
if($userid!=0){
    $sql = $sql . "LIMIT " . $limit . ";";
}
        //echo $sql;
        
        $result1 =$conn->query($sql);

        $num_row=0;
        $num_row = mysqli_num_rows($result1);

        if( $num_row >=1 ) { 
            //$_SESSION['user_name']=$username;

            while($post_row = mysqli_fetch_array($result1)) {                
                $output=$output. "<li class='post' postid=" . $post_row['postid'] . "><div class='options'><span onclick=\"window.open('https://www.facebook.com/" . $post_row['mid'] . "'); return false;\" title='Open in Facebook'><i class='material-icons'>reply_all</i></span><span class='bookmarks' title='Bookmarks[TODO]' ><i class='material-icons'>bookmark_border</i></span></div><div class='postcontent'><span class='details'><span class='author'>" . $post_row['creator'] . "</span><span class='date'>" . $post_row['created_time'] . "</span></span><div class='message'>" . $post_row['message'] . "</div>";
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
