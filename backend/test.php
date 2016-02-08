<?php
require_once 'configuration.php';
set_time_limit(99999999);
ini_set('memory_limit', "9999M");


 
try {
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
    echo "Connected to $dbname at $dbhost successfully.";
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$sql = "CREATE TABLE test (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
message LONGTEXT(4294967295) NOT NULL,
mid LONGTEXT(4294967295) NOT NULL,
entry_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table test created successfully";
} else {
    echo "Error creating table: " . $conn->error;
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



$url = "https://graph.facebook.com/$groupid/feed/?access_token=$accesstoken";
$numberofpages = 10;
$numberofpagesdone = 0;
a:
	if($numberofpagesdone !== 10){
$json = fetchUrl($url);
$json_a = json_decode($json,TRUE);
foreach($json_a['data'] as $shit)
{
if(array_key_exists('message', $shit)) {

$messageshit = mysql_escape_string($shit['message']);
$midshit = $shit['id'];

$sql = "INSERT INTO test (message, mid)
VALUES ('$messageshit', '$midshit')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
    #echo $shit['message']." name is ".$shit['id'];
}
}

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
		
		$conn->close();
		
	}
?>