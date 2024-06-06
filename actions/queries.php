<?php
    //Function to register
    function register($username, $email, $password) {
        include "../db.php";
        $sql = "INSERT INTO users (user_id, username, email, password, created_at) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if(!$stmt->prepare($sql)) {
           die("SQL error: " . $conn->error);
            exit();
        } else {
            $user_id = uniqid();
            $created_at = date("Y-m-d H:i:s");
            $stmt->bind_param("sssss", $user_id, $username, $email, $hashed_password, $created_at);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute();
            echo "<script>alert('Registered successfully!')</script>";
            echo "<script>window.location.href = '../login.php';</script>";
        }
    }

    //Function to login
    function login($username, $password) {
        include "../db.php";
        $sql = "SELECT * FROM users WHERE username=? OR email=?";
        $stmt = $conn->prepare($sql);
        if(!$stmt->prepare($sql)) {
            header("Location: ../auth/login.php?error=sqlerror");
            exit();
        } else {
            $stmt->bind_param("ss", $username, $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows === 0) {
                header("Location: ../auth/login.php?error=No user exists in the database");
                exit();
            }
            else {
                $row = $result->fetch_assoc();
                if(password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];
                    header("Location: ../index.php");
                } else {
                    header("Location: ../auth/login.php?error=Incorrect username or password");
                }
                exit();
            }
        }
    }

    function posts() {    
        include "db.php";
    
        $result = $conn->query("SELECT * FROM posts JOIN users ON posts.author = users.user_id ORDER BY posts.post_id DESC");
            while ($row = $result->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<p> <img src='img/user.png' alt='user'> " . $row['username'] . " " .$row['created_at']. "</p>";
                echo "<a class='title' href='user/currentPost.php?post_id=" . $row['post_id'] . "'><h3>" . $row['title'] . "</h3></a>";
                echo "<p>" . $row['content'] . "</p>";
                echo "<hr>";
                echo "<a href='comments.php'>comments 0</a>";
                echo "</div>";
            }
    }
?>