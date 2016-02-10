<?php
require_once 'configuration.php';
set_time_limit(99999999);
ini_set('memory_limit', "9999M");


 
try {
   # $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    echo "Connected to $dbname at $dbhost successfully.";
} catch (Exception $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
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



$url = "https://graph.facebook.com/$groupid/feed/?access_token=$accesstoken&fields=id,from,created_time,message,message_tags,type,story,status_type";
$numberofpages = 10;
$numberofpagesdone = 0;
a:
	if($numberofpagesdone !== 10){
$json = fetchUrl($url);
echo "Her 3";
$json_a = json_decode($json,TRUE);
echo "Her 4";
foreach($json_a['data'] as $shit)
{
    if(array_key_exists('message', $shit) || array_key_exists('story',$shit)) {
        if(array_key_exists('message', $shit)){
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
        $json_b = json_decode($shit,TRUE);
        $creatorname='';
        $creatorid='';
            $creatorname = $shit['from']['name'];
            $creatorid = $shit['from']['id'];
            echo "\n SOMETHING SHIT WILL FOLLOW: " . $creatorname . $creatorid . "\n\n\n";
        
        echo "Her 5";
        $sql = "INSERT INTO posts (message, mid,created_time,creator,creatorid,typeofpost,ismessage)
        VALUES ('$messageshit', '$midshit', '$createdtime' ,'$creatorname','$creatorid','$typeshit','$ismessage')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        echo $shit['message']." name is ".$shit['id'];
    }
}
echo "Her 6";
$i = 0;
foreach($json_a['paging'] as $shit2)
{
	if($i == 1) {

    $url = $shit2;
		$numberofpagesdone+=1;
	}
	else{
		$i+=1;
	}
}
		#$url = $shit2['next'];
		#echo $url;
goto a;
	}
	else{
		
		#$conn->close();
		
	}
?>
