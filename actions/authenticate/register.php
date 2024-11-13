<?php
include('../db.php');
@session_start();

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

$stmt = $conn->prepare("INSERT INTO users(username, password) VALUES(?, ?);");
$stmt->bind_param("ss",$username, $password);

if($stmt->execute()){
    
    $_SESSION['success'] = "Registered Successfully! Please Login.";

    header("Location: ../../login.php");
    exit();
}else{
    $_SESSION['error'] = "Something Wnet Wrong";
    header("Location: ../../login.php");
}
// echo $username. '/n'.$password;exit;

?>