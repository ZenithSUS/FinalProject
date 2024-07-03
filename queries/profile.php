<?php
    //Function to display profile
    function profile($conn, $userId) {
        //Write and Execute Query
        $result = $conn->query("SELECT * FROM users WHERE user_id = '$userId'") 
        or die($conn->error);
            //Get user data using fetch_assoc or fetch associative arrays
            $user = $result->fetch_assoc();
            // Format date
            $date = strtotime($user['joined_at']);
            $date = date('F d, Y', $date);
            $formattedDate = date('F d, Y', strtotime($date));
            // Display profile
            echo "<div class='profile'>";
            //If profile picture exists
            if($user['profile_pic'] == null) {
                echo "<img src='../img/default.jpg' alt='profile'>";
            } else {
                echo "<img src='../img/u/" . $user['profile_pic'] . "' alt='profile'>";
            }
            echo "</div>";
            //Display Profile Info
            $total_friends = getTotalFriends($conn, $userId);
            echo "<div class='profile-info'>
                    <h3>" . $user['username'] . "</h3>
                    <h4> " . "Friends: " . $total_friends ."</h4>
                    <h4>" ."Email: ". $user['email'] . "</h4>
                    <h4>" . "Joined " . $formattedDate . "</h4>";
                    //Checks if user set a Bio
                    if(is_null($user['bio']) || $user['bio'] == "") {
                        echo "<h4>No bio</h4>";
                    } else {
                        echo "<h4>" . "Bio: " . $user['bio'] . "</h4>";
                    }
                    //Display token if the user is the same as the logged in user
                    if($userId == $_SESSION['user_id']) {
                        echo "<h4 class='token'>" . "Token:" . "<p id='token'>" .  $user['token'] . "</p>" . "<button class='copy-btn' id='copy-btn'>Copy</button></h4>";
                    } else {
                        echo "<p id='token' style='display:none'> </p>";
                    }
                    //Display profile settings if user is the same as the logged in user
                    if($userId == $_SESSION['user_id']) {
                    // Display options to edit or delete profile
                    echo "<div class='profile-settings'>
                        <a href='editProfile.php?user_id=" . $user['user_id'] . "'>Edit Account</a>
                        <a href='editPass.php?user_id=" . $user['user_id'] . "'>Change Password</a>
                        <a href='../actions/deleteAcc_act.php' onclick=\"return confirm('Are you sure you want to delete your account?')\">Delete Account</a>
                    </div>";
                    } else {
                        //Get user id
                        $userId = $_SESSION['user_id'];
                        //Get friend id
                        $friendId = $user['user_id'];

                        //Write and Execute Query and check if user is a friend
                        $sql = "SELECT * FROM friends JOIN users ON friends.user_id = users.user_id 
                        WHERE friends.user_id = '$friendId' AND friends.friend_id = '$userId'";
                        $result = $conn->query($sql);
                        // Display options to add or remove friend
                        if($result !== false && $result->num_rows > 0) {
                            echo "<div class='profile-settings'>
                                    <form action='../actions/friend_act.php?user_id=" . $friendId . "' method='POST'>
                                        <button class='removeFriend-btn' id='removeFriend-btn' name='removeFriendForm' onclick=\"return confirm('Are you sure you want to remove this friend?')\">
                                            <p class='removeFriend-text'>Remove Friend</p></button>
                                    </form>
                                </div>";
                        } else {
                            //Check if friend request is pending if the
                            //user is the request reciever
                            if(getFriendRequestStatus($conn, $userId, $friendId) == "waiting") {
                                //Accept friend request button
                                echo "<div class='request-container'>
                                        <div class='profile-settings'>
                                            <form action='../actions/friend_act.php?user_id=" . $friendId . "' method='POST'>
                                                <button class='acceptRequest-btn' id='acceptRequest-btn' name='acceptFriendForm'>
                                                    <p class='acceptRequest-text'>Accept Request</p></button>
                                            </form>
                                        </div>";
                                //Decline friend request button
                                echo "<div class='profile-settings'>
                                        <form action='../actions/friend_act.php?user_id=" . $friendId . "' method='POST'>
                                            <button class='declineRequest-btn' id='cancelRequest-btn' name='declineFriendForm'> 
                                                <p class='declineRequest-text'>Decline Request</p>
                                            </button>
                                        </form>
                                        </div>
                                    </div>";
                            //Check the friend request status
                            //if the user is the request sender
                            } else {
                                //Get friend request status
                                $friendRequestStatus = getFriendRequestStatus($conn, $userId, $friendId);
                                $friendBtnText = "";
                                if($friendRequestStatus == "pending") {
                                    $friendBtnText = "Cancel Request";
                                } else {
                                    $friendBtnText = "Add Friend";
                                }
                                    echo "<div class='profile-settings'>
                                        <form action='../actions/friend_act.php?user_id=" . $_GET['user_id'] . "&status=" . $friendRequestStatus . "' method='POST'>
                                            <button class='addFriend-btn'' id='addFriend-btn' name='friendForm'>
                                                <p class='addFriend-text' name='status'> " . $friendBtnText . "</p>
                                            </button>
                                        </form> 
                                </div>";
                            }
                    }
                }
        echo "</div>";
    }

    //Function to edit profile information
    function editProfile($conn, $userId, $username, $email, $profilePic, $bio) {    
        //Update profile information
        $sql = "UPDATE users SET username = ?, email = ?, profile_pic = ?, bio = ? WHERE user_id = ?";
        //Prepare statement
        $stmt = $conn->prepare($sql);

        //If the BIO field is empty
        if(empty($bio) || $bio == null) {
            $bio = null;
        }
        //Fetch the previous profile information
        $sql2 = "SELECT * FROM users WHERE user_id = ?";
        //Prepare statement
        $stmt2 = $conn->prepare($sql2);
        //Bind parameters
        $stmt2->bind_param("s", $userId);
        //Execute statement
        $stmt2->execute();
        //Get result
        $result2 = $stmt2->get_result();
        //Get user
        $user = $result2->fetch_assoc();

        //File upload settings
        if(isset($_FILES['profile_pic']) && !empty($_FILES['profile_pic']['name'])) {
            //Remove previous profile pic in the folder if it exists
            if(isset($user['profile_pic']) && !is_null($user['profile_pic'])) {
                unlink('../img/u/' . $user['profile_pic']);
            }
            //Get file name
            $fileName = $_FILES['profile_pic']['name'];
            $fileSize = $_FILES['profile_pic']['size'];
            $fileTmpName = $_FILES['profile_pic']['tmp_name'];
            $fileError = $_FILES['profile_pic']['error'];
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
                    //If file size is over 1mb
                    } else {
                        header("Location: ../user/editProfile.php?profileError=File is too big!&user_id=" . $userId);
                        exit();
                    }
                //If there is an error
                } else {
                    header("Location: ../user/editProfile.php?profilError=There was an error uploading your file!&user_id=" . $userId);
                    exit();
                }
            //If file is not allowed   
            } else {
                header("Location: ../user/editProfile.php?profileError=You cannot upload files of this type!&user_id=" . $userId);
                exit();
            }
            //Bind parameters
            $stmt->bind_param("sssss", $username, $email, $fileNameNew, $bio, $userId);

        //If no file is uploaded
        } else {
            //Get the same profile picture
            $sql3 = "SELECT profile_pic FROM users WHERE user_id = ?";
            $stmt3 = $conn->prepare($sql3);
            //Bind parameters
            $stmt3->bind_param("s", $userId);
            //Execute statement
            $stmt3->execute();
            //Get result
            $result3 = $stmt3->get_result();
            $user = $result3->fetch_assoc();
            $profilePic = $user['profile_pic'];
            //Close statement
            $stmt3->close();
            
            //Bind parameters on the information
            $stmt->bind_param("sssss", $username, $email, $profilePic, $bio, $userId);
        }

        //Check for input errors
        if(empty($username) || empty($email)) {
            header("Location: ../user/editProfile.php?user_id=" . $userId . "&error=Please fill in all fields!");
            exit();
        }

        //Check if email is valid
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../user/editProfile.php?user_id=" . $userId . "&email_error=Please enter a valid email!");
            exit();
        }

        //Check if username is valid
        if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            header("Location: ../user/editProfile.php?user_id=" . $userId . "&user_error=Please enter a valid username!");
            exit();
        }

        //Check if email already exists when updating
        $sql4 = "SELECT email FROM users WHERE user_id != ? AND email = ?";
        $stmt4 = $conn->prepare($sql4);
        $stmt4->bind_param("ss", $userId, $email);
        $stmt4->execute();
        $result4 = $stmt4->get_result();
        $rowCount = $result4->num_rows;
        if($rowCount > 0) {
            header("Location: ../user/editProfile.php?user_id=" . $userId . "&email_error=Email already exists!");
            exit();
        }
        //Close statement in email checking
        $stmt4->close();

        //Check if username already exists when updating
        $sql5 = "SELECT username FROM users WHERE user_id != ? AND username = ?";
        $stmt5 = $conn->prepare($sql5);
        $stmt5->bind_param("ss", $userId, $username);
        $stmt5->execute();
        $result5 = $stmt5->get_result();
        $rowCount = $result5->num_rows;
        if($rowCount > 0) {
            header("Location: ../user/editProfile.php?user_id=" . $userId . "&user_error=Username already exists!");
            exit();
        }

        //Close statement in username checking
        $stmt5->close();

        //Execute statement to update profile
        $stmt->execute();

        //Update session username
        $_SESSION['username'] = $username;

        //Close statement to update profile
        $stmt->close();
        //Redirect to profile
        header("Location: ../user/profile.php?user_id=" . $userId);
    }

    //Function to edit password
    function editPass($conn, $userId, $password, $newPassword, $confirmNewPassword) {
        //Check if any of the fields are empty
        if(empty($password) || empty($newPassword) || empty($confirmNewPassword)) {
            header("Location: ../user/editPass.php?user_id=" . $userId . "&error=Please fill in all fields!");
            exit();
        }
        //Get user id
        $sql = "SELECT password FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        //Bind parameters
        $stmt->bind_param("s", $userId);
        //Execute statement
        $stmt->execute();
        //Get result
        $result = $stmt->get_result();
        //Get user
        $user = $result->fetch_assoc();
        $passwordHash = $user['password'];
        //Close statement
        $stmt->close();
        //Check if password is correct
        if(password_verify($password, $passwordHash)) {
            if($newPassword == $confirmNewPassword) {
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql2 = "UPDATE users SET password = ? WHERE user_id = ?";
                $stmt2 = $conn->prepare($sql2);
                //Bind parameters
                $stmt2->bind_param("ss", $newPasswordHash, $userId);
                //Execute statement
                $stmt2->execute();
                //Close statement
                $stmt2->close();
                echo "<script>alert('Password updated successfully!')
                window.location.href = '../user/profile.php?user_id=" . $userId . "'</script>";
                
                exit();
            } else {
                header("Location: ../user/editPass.php?user_id=" . $userId . "&confirm_new_pass_error=Passwords do not match!");
                exit();
            }
        } else {   
            header("Location: ../user/editPass.php?user_id=" . $userId . "&old_pass_error=Incorrect old password!");
            exit();
        }
    }

    //Function to delete account
    function deleteAccount($conn, $userId) {
        //Unbind picture if it exists
        $sql = "SELECT profile_pic FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        //Bind parameters
        $stmt->bind_param("s", $userId);
        //Execute statement
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $picture = $row['profile_pic'];
        if($picture != null) {
            unlink("../img/u/" . $picture);
        }

        //Delete user
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        //Bind parameters
        $stmt->bind_param("s", $userId);
        //Execute statement
        $stmt->execute();

        //Unbind greek picture if it exists
        $sql = "SELECT image_url FROM greeks WHERE creator = ?";
        $stmt = $conn->prepare($sql);
        //Bind parameters
        $stmt->bind_param("s", $userId);
        //Execute statement
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $picture = $row['image_url'];
        if($picture != null) {
            unlink("../img/gods/" . $picture);
        }

        //Delete also the page related to the user
        $sql = "DELETE FROM greeks WHERE creator = ?";
        $stmt = $conn->prepare($sql);
        //Bind parameters
        $stmt->bind_param("s", $userId);
        //Execute statement
        $stmt->execute();


        //Destroy session
        session_unset();
        session_destroy();
        //Destroy cookies
        setcookie("user_id", "", time() - 3600);
        setcookie("username", "", time() - 3600);

        //Close statement
        $stmt->close();

        //Redirect to login page
        echo "<script>
        alert('Account deleted successfully!');
        window.location.href = '../auth/login.php'
        </script>";
    }
?>