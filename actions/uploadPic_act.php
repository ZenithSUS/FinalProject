<?php
    include "../db.php";
    session_start();
    //Get user id from session
    if(isset($_POST['submit'])) {
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
        //Check if file is allowed
        if(in_array($fileActualExt, $allowed) == true) {
            if($fileError === 0) {
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
                    header("Location: ../auth/uploadProfile.php?error=File is too big!");
                    exit();
                }
            //If there is an error
            } else {
                header("Location: ../auth/uploadProfile.php?error=There was an error uploading your file!");
                exit();
            }
        //If file is not allowed   
        } else {
            header("Location: ../auth/uploadProfile.php?error=You cannot upload files of this type!");
            exit();
        }
    }
?>