<?php
    //Function to get heroes
    function getGreeks($conn) {
        //Write query
        $sql = "SELECT * FROM greeks ORDER BY name;";
        //Execute query
        $result = $conn->query($sql);
        //Check if heroes exist
        if($result !== false && $result->num_rows > 0) {
            // Display heroes
            while ($row = $result->fetch_assoc()) {
                //Clean the heroes text
                //Display heroes
                echo "<div class='hero-box'>";
                echo "<img src='img/gods/" . $row['image_url'] . "' alt='" . $row['name'] . "'>";
                echo "<h2>" . $row['name'] . "</h2>";
                echo "</div>";
            }
        }
    }


    //Function to get heroes inside in user folder
    function getGreeksUser($conn) {
        //Write query
        $sql = "SELECT * FROM greeks ORDER BY name;";
        //Execute query
        $result = $conn->query($sql);
        //Check if heroes exist
        if($result !== false && $result->num_rows > 0) {
            // Display heroes
            while ($row = $result->fetch_assoc()) {
                //Clean the heroes text
                //Display heroes
                echo "<div class='hero-box'>";
                echo "<img src='../img/gods/" . $row['image_url'] . "' alt='" . $row['name'] . "'>";
                echo "<h2>" . $row['name'] . "</h2>";
                echo "</div>";
            }
        }
    }
?>