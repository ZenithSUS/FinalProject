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
        $sql = "INSERT INTO users (user_id, username, email, password) VALUES (?, ?, ?, ?)";
        //Prepare statement
        $stmt = $conn->prepare($sql);
        //Check if query is prepared
        if(!$stmt->prepare($sql)) {
            //Close statement
            header("Location: ../auth/register.php?error=sqlerror");
            exit();
        } else {
            //Generate user id
            $user_id = mysqli_real_escape_string($conn, uniqid());
            //Hash password
            $hashed_password = hashPassword($password);
            //Bind parameters and execute query
            $stmt->bind_param("ssss", $user_id, $username, $email, $hashed_password);
            $stmt->execute();

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
?>