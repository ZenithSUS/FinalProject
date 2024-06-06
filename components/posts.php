<?php
    include "db.php";
    
    $result = $conn->query("SELECT * FROM posts JOIN users ON posts.author = users.user_id ORDER BY posts.post_id DESC");
    while ($row = $result->fetch_assoc()) {
        echo "<div class='post'>";
        echo "<img src='img/user.png' alt='user'>";
        echo "<a class='title' href='user/currentPost.php?post_id=" . $row['post_id'] . "'><h3>" . $row['title'] . " Posted by " . $row['username'] . " " .$row['created_at']. "</h3></a>";
        echo "<p>" . $row['content'] . "</p>";
        echo "<hr>";
        echo "<a href='comments.php'>comments 0</a>";
        echo "</div>";
    }
?>