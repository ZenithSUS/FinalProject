<?php
    //Function to login
    function login($conn, $username, $password) {
        //Write query and prepare statement
        $sql = "SELECT * FROM users WHERE username=? OR email=?";
        $stmt = $conn->prepare($sql);
        //Check if query is prepared
        if(!$stmt->prepare($sql)) {
            header("Location: ../auth/login.php?error=sqlerror");
            exit();
        //Else bind parameters and execute
        } else {
            //Bind parameters
            $stmt->bind_param("ss", $username, $username);
            //Execute query
            $stmt->execute();
            //Get result
            $result = $stmt->get_result();
            //Check if user exists
            if($result->num_rows === 0) {
                header("Location: ../auth/login.php?error=No user exists in the database");
                exit();
            }
            //Else check if password is correct
            else {
                $row = $result->fetch_assoc();
                //Check if password is correct
                if(verifyPassword($password, $row['password'])) {
                    //Set session variables
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['last_activity'] = time();
                    $_SESSION['expires'] = 3600;

                    // Set cookies
                    setcookie("user_id", $row['user_id'], time() + $_SESSION['expires'] , "/");
                    setcookie("username", $row['username'], time() + $_SESSION['expires'], "/");
                    header("Location: ../index.php");
                //Else password is incorrect
                } else {
                    //Close statement
                    $stmt->close();
                    
                    header("Location: ../auth/login.php?error=Incorrect username or password");
                }
                //Exit if password is incorrect
                exit();
            }
        }
    }

    //Function to register
    function register($conn, $username, $email, $password) {
        //Write query and prepare statement
        $sql = "INSERT INTO users (user_id, username, email, password, token) VALUES (UUID(), ?, ?, ?, ?)";
        //Prepare statement
        $stmt = $conn->prepare($sql);
        //Check if query is prepared
        if(!$stmt->prepare($sql)) {
            //Close statement
            header("Location: ../auth/register.php?error=sqlerror");
            exit();
        } else {
            
            //Hash password
            $hashed_password = hashPassword($password);
            $token = bin2hex(random_bytes(16));
            //Bind parameters and execute query
            $stmt->bind_param("ssss", $username, $email, $hashed_password, $token);
            $stmt->execute();

            //After Registering the account get the user id
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];

            //Call insertDefaultPages function
            insertDefaultPages($conn, $user_id);

            //Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['last_activity'] = time();
            $_SESSION['expires'] = 3600;

            //Set cookies
            setcookie("user_id", $user_id, time() + $_SESSION['expires'] , "/");
            setcookie("username", $username, time() + $_SESSION['expires'], "/");

            //Close statement
            $stmt->close();
            echo "<script>alert('Registered successfully!')</script>";
            echo "<script>window.location.href = '../auth/uploadProfile.php';</script>";
        }
    }

    //Function to insert default group pages
    function insertDefaultPages($conn, $user_id) {
        //Write query
        $sql = "SELECT * FROM greeks WHERE creator = 'Default'";
        $result = $conn->query($sql);

        if($result !== false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sql = "INSERT INTO user_groups (id, user_id, greek_id) VALUES (UUID(), ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $user_id, $row['greek_id']);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    //Function to hash password
    function hashPassword($password) {
        //Hash password
        return password_hash($password, PASSWORD_DEFAULT);
    }

    //Function to verify password
    function verifyPassword($password, $hashed_password) {
        //Check if password is correct
        return password_verify($password, $hashed_password);
    }

    //Function to check either the email or username exists when recovering password
    function checkEmailOrUsername($conn, $emailOrUsername) {
        //Write query
        $sql = "SELECT * FROM users WHERE email = '$emailOrUsername' OR username = '$emailOrUsername'";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            header("Location: ../auth/recoverAcc.php");
        } else {
            header("Location: ../auth/forgot.php?error=No user exists in the database");
            exit();
        }
    }

    //Function to reset password
    function resetPassword($conn, $token, $newPassword, $confirmNewPassword) {
        //Check if any of the fields are empty
        if(empty($newPassword) || empty($confirmNewPassword)) {
            header("Location: ../auth/recoverAcc.php?error=Please fill in all fields!");
            exit();
        }

        //Check the token
        $sql = "SELECT * FROM users WHERE token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 0) {
            header("Location: ../auth/recoverAcc.php?tokenError=Invalid token");
            exit();
        }

        if($newPassword == $confirmNewPassword) {
            //Write query
            $sql = "UPDATE users SET password = ? WHERE token = ?";
            //Prepare statement
            $stmt = $conn->prepare($sql);
            //Hash password
            $hashed_password = hashPassword($newPassword);
            //Bind parameters
            $stmt->bind_param("ss", $hashed_password, $token);
            //Execute statement
            $stmt->execute();
            //Close statement
            $stmt->close();
            echo "<script>alert('Password updated successfully!')
            window.location.href = '../auth/login.php';</script>";
        } else {
            header("Location: ../auth/recoverAcc.php?cpasswordError=Passwords do not match");
            exit();
        }
    }
?>