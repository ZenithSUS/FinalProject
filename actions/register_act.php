<?php
    //Include db connection
    include "../db.php";
    //Iniaties a session
    session_start();

    //Get form data by POST method
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    //Get the captcha information
    $secret = "6LdTPAMqAAAAAHO4REJfwlXjhCT9C-aKWgnQYMCR";
    $response = $_POST['g-recaptcha-response'];
    $remote_ip = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify";

    //Verify captcha
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}&remoteip={$remote_ip}");
    $response_data = json_decode($verify);

    //Check if form is submitted
    if(isset($_POST['submit'])) {
        //Check if fields are empty
        if(empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
            header("Location: ../auth/register.php?error=Fill all the fields&username=".$username."&email=".$email);
            exit();
        }

        //Check if email and username are valid
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            header("Location: ../auth/register.php?emailError=invalidmail&username=".$username);
            exit();
        }
        //Check if email is valid
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../auth/register.php?emailError=invalidmail&username=".$username);
            exit();
        }
        //Check if username is valid using only letters and numbers
        else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            header("Location: ../auth/register.php?userError=invalidusername&email=".$email);
            exit();
        }
        //Check if password less than 8
        else if(strlen($password) < 8) {
            header("Location: ../auth/register.php?passError=Password must be at least 8 characters&username=".$username."&email=".$email);
            exit();
        }
        //Check if passwords are equal
        else if($password !== $confirm_password) {
            header("Location: ../auth/register.php?passError=Password did not match&username=".$username."&email=".$email);
            exit();
        }
        //Check if captcha is responded
        if(!$response_data->success) {
            header("Location: ../auth/register.php?captchaError=Please verify that you are not a robot&username=".$username."&email=".$email);
            exit();
        }
        else {
            //Check if username or email already exists
            $sql = "SELECT username FROM users WHERE username=?";
            $sql2 = "SELECT email FROM users WHERE email=?";

            //Prepare statements
            $stmt = $conn->prepare($sql);
            $stmt2 = $conn->prepare($sql2);

            //Checks if username or email already exists
            if(!$stmt->prepare($sql) || !$stmt2->prepare($sql2)) {
                header("Location: ../register.php?error=sqlerror");
                exit();
            }
            else {
                //Bind parameters and execute queries
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                $stmt2->bind_param("s", $email);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                
                //Check if username or email already exists
                if($result->num_rows > 0 || $result2->num_rows > 0) {
                    if($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        if($row['username'] === $username) {
                            header("Location: ../auth/register.php?userError=User aleady exists&username=".$username."&email=".$email);
                        }
                    } 
                    if($result2->num_rows > 0) {
                        $row = $result2->fetch_assoc();
                        if($row['email'] === $email) {
                            header("Location: ../auth/register.php?emailError=Email aleady exists&username=".$username."&email=".$email);
                        }
                    }
                    exit();
                } else {
                    //Register user
                    include "../queries/auth.php";
                    //Call function register
                    register($conn, $username, $email, $password);
                    exit();
                }
            }
            //Close statements
            $stmt->close();
            
        }
    }
?>