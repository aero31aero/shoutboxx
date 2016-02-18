<?php
require_once 'configuration.php';
set_time_limit(900000);
ini_set('memory_limit', "9999M");
//echo "Script to download group posts. Please be patient. <br>";

 
try {
   # $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    //echo "Connected to $dbname at $dbhost successfully.";
} catch (Exception $pe) {
    //die("Could not connect to the database $dbname :" . $pe->getMessage());
}


function fetchUrl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 40);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}



$url = "https://graph.facebook.com/$groupid/feed/?access_token=$accesstoken&fields=id,from,created_time,message,message_tags,type,story,status_type,full_picture";
//echo $url . '</br>';
$numberofpages = 3;
$numberofpagesdone = 0;
while($numberofpagesdone != $numberofpages){
    $json = fetchUrl($url);
    $json_a = json_decode($json,TRUE);
    foreach($json_a['data'] as $shit)
    {
        if(array_key_exists('message', $shit) || array_key_exists('story',$shit)) {
            if(array_key_exists('message', $shit)){
                $shit['message']=str_replace("\n" , "<br>" , $shit['message'] );
                $messageshit = mysql_escape_string($shit['message']);
                $ismessage = true;
            }
            else if(array_key_exists('story', $shit)){
                $messageshit = mysql_escape_string($shit['story']);
                $ismessage = false;
            }
            $midshit = $shit['id'];
            $typeshit = $shit['type'];
            $createdtime = $shit['created_time'];
            $fullimage = $shit['full_picture'];
            $creatorname='';
            $creatorid='';
                $creatorname = $shit['from']['name'];
                $creatorid = $shit['from']['id'];
                //echo "\n SOMETHING SHIT WILL FOLLOW: " . $creatorname . $creatorid . "\n\n\n";

           // echo "Her 5";

    $sql = "SELECT * FROM posts WHERE mid='$midshit';";
    $result =$conn->query($sql);
    $num_row = mysqli_num_rows($result);
    if( $num_row >=1 ) { 

    }
    else{
            $sql = "INSERT INTO posts (message, mid,created_time,creator,creatorid,typeofpost,ismessage,fullimage)
            VALUES ('$messageshit', '$midshit', '$createdtime' ,'$creatorname','$creatorid','$typeshit','$ismessage','$fullimage')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully for post created by " . $creatorname . ".<br>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            //echo $shit['message']." name is ".$shit['id'];


            //echo "Her 6";
            $i = 0;
            foreach($json_a['paging'] as $shit2)
            {
                if($i == 1) {

                $url = $shit2;


                }
                else{
                    $i+=1;
                }
            }
                    #$url = $shit2['next'];
                    #echo $url;
        }
        }
        else{

            #$conn->close();

        }
    }
    $numberofpagesdone+=1;
}
$conn-->close();
?>
