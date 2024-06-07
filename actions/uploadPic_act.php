<?php
    include "../db.php";
    session_start();
    //Get user id from session
    if(isset($_POST['submit'])) {
        //Get file info
        $profilePic = $_FILES['profilePic'];
        $fileName = $_FILES['profilePic']['name'];
        $fileSize = $_FILES['profilePic']['size'];
        $fileTmpName = $_FILES['profilePic']['tmp_name'];
        $fileError = $_FILES['profilePic']['error'];
        $fileType = $_FILES['profilePic']['type'];
        $fileExt = explode('.', $fileName);
        //Get file extension
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png');
        if(in_array($fileActualExt, $allowed) == true) {
            if($fileError === 0) {
                if($fileSize < 1000000) {
                    //Generate unique file name
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    //File destination
                    $fileDestination = '../img/u/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);

                    //Update database
                    $sql = "UPDATE users SET profile_pic = ? WHERE user_id = ?";
                    //Bind parameters
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $fileNameNew, $_SESSION['user_id']);
                    //Execute statement
                    $stmt->execute();
                    header("Location: ../index.php");
                    exit();
                } else {
                    header("Location: ../auth/uploadProfile.php?error=File is too big!");
                    exit();
                }
            } else {
                header("Location: ../auth/uploadProfile.php?error=There was an error uploading your file!");
                exit();
            }   
        } else {
            header("Location: ../auth/uploadProfile.php?error=You cannot upload files of this type!");
            exit();
        }
    }
?>