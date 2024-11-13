<?php
include "db.php";
session_start();

if(isset($_SESSION['username'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $targetDir = "../uploads/";

    // Step 1: Retrieve the current image file path from the database
    $stmt = $conn->prepare("SELECT image FROM details WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($currentImage);
    $stmt->fetch();
    $stmt->close();

    // Step 2: Check if a new image is uploaded
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        // New image uploaded, process it
        // Step 2.1: Delete the old image if it exists
        if ($currentImage && file_exists($targetDir . $currentImage)) {
            unlink($targetDir . $currentImage);  // Delete the old file
        }

        // Step 2.2: Process the new image
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $newFileName = uniqid('img_', true) . '.' . $imageFileType;
        $filePath = $targetDir . $newFileName;

        // Step 2.3: Move the uploaded file to the uploads directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $filePath)) {
            $filePathToUse = $newFileName;
        } else {
            $_SESSION['error'] = "Failed to upload the new file.";
            header("Location: ../index.php");
            exit();
        }
    } else {
        // No new file uploaded, keep the old file
        $filePathToUse = $currentImage;
    }

    // Step 3: Update the name and image in the database
    $stmt = $conn->prepare("UPDATE details SET name = ?, image = ? WHERE id = ?");
    $stmt->bind_param('ssi', $name, $filePathToUse, $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Record successfully updated.";
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to update record in the database.";
        header("Location: ../index.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}else{
    $_SESSION['error'] = "Something went wrong!.";
    header("Location: ../login.php");
}
?>
