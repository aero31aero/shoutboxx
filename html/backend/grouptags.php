<?php
require_once 'configuration.php';
 

function getsubtags($maintag){
    try {
   
        $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
        //echo "Connected to $dbname at $dbhost successfully.";
    } catch (Exception $pe) {
        die("Could not connect to the database $dbname :" . $pe->getMessage());
    }

    $sql="";
    $sql1="select subtag from grouptags where maintag='" . $maintag . "';";
    $result =$conn->query($sql1);
    $num_row = mysqli_num_rows($result);
    if( $num_row >=1 ){ 
        return "";
    }
    else{
            while($tag_row = mysqli_fetch_array($result)) {
                $sql= $sql . "message LIKE '%". $tag_row['subtag'] . "%' OR ";   
                echo "HELLO" . $tag_row['subtag'];
            }
    }   
    return $sql;
    
    
}
?>