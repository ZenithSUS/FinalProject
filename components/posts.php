<?php
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
?>