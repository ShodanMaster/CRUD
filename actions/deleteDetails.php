<?php
include "db.php";
session_start();
if(isset($_SESSION['username'])){
    $id = $_POST['delete'];
    
    $stmt = $conn->prepare("SELECT image FROM details WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->bind_result($filePath);
    $stmt->fetch();
    $stmt->close();
    
    $fullPath = '../uploads/' . basename($filePath);
    if ($filePath && file_exists($fullPath)) {
        unlink($fullPath);
    }
    
    $stmt = $conn->prepare("DELETE FROM details WHERE id = ?");
    $stmt->bind_param("s", $id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Record successfully Deleted.";
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['error'] = "Record not inserted.";
        header("Location: ../index.php");
    }
    
    $stmt->close();
    $conn->close();
}else{
    $_SESSION['error'] = "Something went wrong!.";
    header("Location: ../login.php");
}
?>