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
$lastposttime=mysql_escape_string($_GET['lastposttime']);

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
$sql= $sql . "groups.groupid=posts.groupid AND ismessage=TRUE AND created_time > '$lastposttime' ORDER BY created_time DESC ";
if($userid!=0){
    $sql = $sql . "LIMIT " . $limit . ";";
}
        //echo $sql;
        $result1 =$conn->query($sql);

        $num_row=0;
        $num_row = mysqli_num_rows($result1);

        if( $num_row >=1 ) { 
            echo "success";

        }
        else{
            echo "fail";    
        }
    //echo $sql;
 echo $output;

   
		
$conn->close();
?>