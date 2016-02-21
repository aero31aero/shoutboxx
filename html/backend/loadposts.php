<?php
//session_start();
require_once 'configuration.php';
//require_once 'grouptags.php';
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
$sql = "SELECT postid,mid,creator,message,created_time+ interval 30 minute + interval 5 hour as created_time,fullimage,groupname FROM posts,groups WHERE (";
$arrlength = count($tagarray);
for($x = 0; $x < $arrlength-1; $x++) {
    //exception-handling-for-tags
    if(strcmp(substr($tagarray[$x], -4),"-all")==0){
        $sql1="select subtag from grouptags where maintag='" . $tagarray[$x] . "';";
        $result =$conn->query($sql1);
        $num_row = mysqli_num_rows($result);
        if( $num_row ==0 ){            
        }
        else{
                while($tag_row2 = mysqli_fetch_array($result)) {
                    $sql= $sql . "message LIKE '% ". $tag_row2['subtag'] . " %' OR "; 
                    $sql= $sql . "message LIKE '". $tag_row2['subtag'] . " %' OR ";
                }
        }   

    }
    if(strcmp($tagarray[$x],"all-posts")==0){
        
        $sql= $sql . "message LIKE '%' OR ";
        $limit=100;
    }
    
    $sql= $sql . "message LIKE '%". $tagarray[$x] . "%' OR creator LIKE '%". $tagarray[$x] . "%' OR ";
}


//exception-handling-for-tags
    if(strcmp(substr($tagarray[$arrlength-1], -4),"-all")==0){
        $sql1="select subtag from grouptags where maintag='" . $tagarray[$arrlength-1] . "';";
        $result =$conn->query($sql1);
        $num_row = mysqli_num_rows($result);
        if( $num_row ==0 ){            
        }
        else{
                while($tag_row2 = mysqli_fetch_array($result)) {
                    $sql= $sql . "message LIKE '% ". $tag_row2['subtag'] . " %' OR ";   
                    $sql= $sql . "message LIKE '". $tag_row2['subtag'] . " %' OR ";  
                }
        } 
    }
    if(strcmp($tagarray[$arrlength-1],"all-posts")==0){
        
        $sql= $sql . "message LIKE '%' OR ";
        $limit=100;
    }
$sql= $sql . "message LIKE '%". $tagarray[$arrlength-1] . "%' OR creator LIKE '%". $tagarray[$arrlength-1] . "%') AND ";


$sql5 = "SELECT * FROM usergroups WHERE userid='$userid' AND isactive=1;";
$result5 =$conn->query($sql5);
$num_row5 = mysqli_num_rows($result5);
if( $num_row5 >=1 ){
    $sql = $sql . "(";
    while($post_row5 = mysqli_fetch_array($result5)) {
        $sql = $sql . "groups.groupid=" . $post_row5['groupid'] . " OR ";
    }
    $sql=substr($sql, 0, -4);
    $sql = $sql . ") AND ";
}
if( $num_row5 ==0 ){
    $sql = $sql . " userid=0 AND ";
}
$sql= $sql . "groups.groupid=posts.groupid AND ismessage=TRUE ORDER BY created_time DESC ";
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
                $getpostid = explode("_",$post_row['mid']);
                $output=$output. "<li class='post' postid=" . $post_row['postid'] . " created_time='" . $post_row['created_time'] . "'><div class='tooltip options'><span onclick=\"window.open('https://www.facebook.com/groups/" . $getpostid[0] . "/permalink/". $getpostid[1] . "','_blank'); return false;\" title='Open in Facebook'><i class='material-icons'>reply_all</i></span></div><div class='postcontent'><span class='details'><span class='author'>" . $post_row['creator'] . "</span><span class='date'>" . $post_row['created_time'] . "</span><span class='group'>" . $post_row['groupname'] . "</span></span><div class='message'>" . $post_row['message'] . "</div>";
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
    //echo $sql;
 echo $output;

   
		
$conn->close();

/*<!--$sql = "SELECT postid,mid,creator,message,created_time+ interval 30 minute + interval 5 hour as created_time,fullimage FROM posts WHERE (";
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
    }-->*/



?>