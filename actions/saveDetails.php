<?php

session_start();
include "db.php";
if(isset($_SESSION['username'])){

    $name = $_POST["name"];
    $targetDir = "../uploads/";

    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $fileName = uniqid('img_', true) . '.' . $imageFileType;
    $filePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $filePath)) {
        $stmt = $conn->prepare("INSERT INTO details (name, image) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $fileName);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Record successfully inserted.";
            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['error'] = "Record not inserted.";
            header("Location: ../index.php");
        }
    }
    else{
        $_SESSION['error'] = "File not inserted.";
        header("Location: ../index.php");

    }
}else{
    $_SESSION['error'] = "Something went wrong!.";
    header("Location: ../login.php");
}
$stmt->close();
$conn->close();
?>