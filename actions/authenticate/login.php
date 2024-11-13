<?php
include("../db.php");
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
$stmt->bind_param("s", $username);

if($stmt->execute()){
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['success'] = "Logged in successfully!";
        $_SESSION['username'] = $user['username'];
        header('Location: ../../index.php');
        exit();
    } else {
        $_SESSION['error'] = "Wrong credentials!";
        header('Location: ../../login.php');
        exit();
    }
}else{
    $_SESSION['error'] = "Wrong Credentials!";
    header('Location: ../../login.php');
}
?>