<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST"){
	echo "Access Denied";
}
elseif($_SERVER["REQUEST_METHOD"] == "POST"){
	$username = cleanshit($_POST["Name"]);
  $password = cleanshit($_POST["password"]);
   
}
function cleanshit($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function checklogin($username,$password){
	mysql_connect()
}
?>