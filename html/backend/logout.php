        <?php 
session_start(); 
$_SESSION['userid'] == null; 
session_destroy(); 
echo 'Done';
?>