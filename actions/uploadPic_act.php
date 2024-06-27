<?php
    include "../db.php";
    session_start();
    //If the form with picture is submitted
    if(isset($_POST['picSubmit'])) {
        //Get Bio from form
        $bio = $_POST['bio'];
        //Get file information
        $profilePic = $_FILES['profilePic'];
        $fileName = $_FILES['profilePic']['name'];
        $fileSize = $_FILES['profilePic']['size'];
        $fileTmpName = $_FILES['profilePic']['tmp_name'];
        $fileError = $_FILES['profilePic']['error'];
        $fileType = $_FILES['profilePic']['type'];
        $fileExt = explode('.', $fileName);
        //Get file extension
        $fileActualExt = strtolower(end($fileExt));
        //Allowed extensions
        $allowed = array('jpg', 'jpeg', 'png');
        //Check if file is allowed and if there is no error
        if(in_array($fileActualExt, $allowed) == true) {
            if($fileError === UPLOAD_ERR_OK && $fileSize > 0) {
                //Check file size is under 1mb
                if($fileSize < 1000000) {
                    //Generate unique file name
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    //File destination
                    $fileDestination = '../img/u/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);

                    //Update database
                    $sql = "UPDATE users SET profile_pic = ?, bio = ? WHERE user_id = ?";
                    //Bind parameters
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sss", $fileNameNew, $bio, $_SESSION['user_id']);
                    //Execute statement
                    $stmt->execute();
                    //Close statement
                    $stmt->close();
                    header("Location: ../index.php");
                    exit();
                //If file size is over 1mb
                } else {
                    header("Location: ../auth/uploadProfile.php?profileError=File is too big!");
                    exit();
                }
            //If there is an error
            } else {
                header("Location: ../auth/uploadProfile.php?profileError=There was an error uploading your file!");
                exit();
            }
        //If file is not allowed   
        } else {
            header("Location: ../auth/uploadProfile.php?profileError=You cannot upload files of this type!");
            exit();
        }
    }

    //If the form without picture is submitted
    if(isset($_POST['noPicSubmit'])) {
        header("Location: ../index.php");
        exit();
    }

    //If no form is submitted
    if(!isset($_POST['picSubmit']) && !isset($_POST['noPicSubmit'])) {
        if(!isset($_SESSION['user_id'])) {
            header("Location: ../auth/login.php");
        } else {
            header("Location: ../auth/uploadProfile.php");
            exit();
        }
    }
?>