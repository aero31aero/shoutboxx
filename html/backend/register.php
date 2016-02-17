<?php
require_once 'configuration.php';
 
try {
   
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    //echo "Connected to $dbname at $dbhost successfully.";
} catch (Exception $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$username=mysql_escape_string($_GET['username']);
$password=mysql_escape_string($_GET['password']);
$bitsid=mysql_escape_string($_GET['bitsid']);
//if($username=='' || $password='' || $bitsid='' || $username==NULL || $password=NULL || $bitsid==NULL){ 
//echo 'fail';
//}
//else {
$sql = "SELECT * FROM users WHERE username='$username';";
$result =$conn->query($sql);
$num_row = mysqli_num_rows($result);
if( $num_row >=1 ){ 
    echo "fail";
}
else{
    $sql = "INSERT INTO users (username,password,bitsid) 
    VALUES ( '$username' , '$password', '$bitsid' );";
    //echo $sql . "<br>";
    if ($conn->query($sql) === TRUE) {
        $sql = "SELECT * FROM users WHERE username='$username';";
        $result =$conn->query($sql);
        $num_row=1;
        $user_row = mysqli_fetch_array($result);
        $num_row = mysqli_num_rows($result);
        if( $num_row >=1 ) { 
            //$_SESSION['user_name']=$username;
            echo $user_row['userid'];
	    $useridforlog = $user_row['userid'];
	    $sql = "INSERT INTO logs (userid,message) 
            VALUES ( '$useridforlog' , 'REGISTER' );";
    	    //echo $sql . "<br>";
            $conn->query($sql);
            $sql = "INSERT INTO tags (userid,tag,isactive) VALUES ( $useridforlog , 'clubs-all', 1 );";
            $conn->query($sql);
            $sql = "INSERT INTO tags (userid,tag,isactive) VALUES ( $useridforlog , 'pearl', 1 );";
            $conn->query($sql);
            $sql = "INSERT INTO tags (userid,tag,isactive) VALUES ( $useridforlog , 'movie screen', 1 );";
            $conn->query($sql);
            $sql = "INSERT INTO tags (userid,tag,isactive) VALUES ( $useridforlog , 'swd', 1 );";
            $conn->query($sql);
            $sql = "INSERT INTO tags (userid,tag,isactive) VALUES ( $useridforlog , 'workshop', 1 );";
            $conn->query($sql);
            $sql = "INSERT INTO tags (userid,tag,isactive) VALUES ( $useridforlog , 'induction', 1 );";
            $conn->query($sql);
            
        }
        else{
            echo "fail";
        } 
    } else {
        echo "fail";
    }
}  

//    }
        
   
		
$conn->close();
?>
