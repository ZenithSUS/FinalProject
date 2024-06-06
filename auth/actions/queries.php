<?php
    //Function to register
    function register($username, $email, $password) {
        include "../../db.php";
        $sql = "INSERT INTO users (user_id, username, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if(!$stmt->prepare($sql)) {
           die("SQL error: " . $conn->error);
            exit();
        } else {
            $user_id = uniqid();
            $stmt->bind_param("ssss", $user_id, $username, $email, $hashed_password);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute();
            echo "<script>alert('Registered successfully!')</script>";
            echo "<script>window.location.href = '../login.php';</script>";
        }
    }

    //Function to login
    function login($username, $password) {
        include "../../db.php";
        $sql = "SELECT * FROM users WHERE username=? OR email=?";
        $stmt = $conn->prepare($sql);
        if(!$stmt->prepare($sql)) {
            header("Location: ../login.php?error=sqlerror");
            exit();
        } else {
            $stmt->bind_param("ss", $username, $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows === 0) {
                header("Location: ../login.php?error=No user exists in the database");
                exit();
            }
            else {
                $row = $result->fetch_assoc();
                if(password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];
                    header("Location: ../../index.php");
                } else {
                    header("Location: ../login.php?error=Incorrect username or password");
                }
                exit();
            }
        }
    }

    function posts($user_id) {

    }
?>