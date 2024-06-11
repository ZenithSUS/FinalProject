<?php
    //Function to display profile
    function profile($userId) {
        //Include database
        include "../db.php";
        //Write and Execute Query
        $result = $conn->query("SELECT * FROM users WHERE user_id = '$userId'");
            //Get user data using fetch_assoc or fetch associative arrays
            $user = $result->fetch_assoc();
            // Format date
            $date = strtotime($user['joined_at']);
            $date = date('F d, Y', $date);
            $formattedDate = date('F d, Y', strtotime($date));
            // Display profile
            echo "<div>";
            //If profile picture exists
            if($user['profile_pic'] == null) {
                echo "<img src='../img/default.jpg' alt='profile'>";
            } else {
                echo "<img src='../img/u/" . $user['profile_pic'] . "' alt='profile'>";
            }
            echo "</div>";
            //Display Profile Info
            $total_friends = getTotalFriends($userId);
            echo "<div class='profile-info'>
                    <h3>" . $user['username'] . "</h3>
                    <h4> " . "Friends: " . $total_friends ."</h4>
                    <h4>" ."Email: ". $user['email'] . "</h4>
                    <h4>" . "Joined " . $formattedDate . "</h4>";
                    //Checks if user set a Bio
                    if(is_null($user['bio'])) {
                        echo "<p>No bio</p>";
                    } else {
                        echo "<p>" . $user['bio'] . "</p>";
                    }
                    //Display profile settings if user is the same as the logged in user
                    if($userId == $_SESSION['user_id']) {
                    // Display options to edit or delete profile
                    echo "<div class='profile-settings'>
                        <a href='user/editProfile.php?user_id=" . $user['user_id'] . "'>Edit Profile</a>
                        <a href='user/changePassword.php?user_id=" . $user['user_id'] . "'>Change Password</a>
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
                                    <form action='../actions/Friend_act.php?user_id=" . $friendId . "' method='POST'>
                                        <button class='removeFriend-btn' id='removeFriend-btn' name='removeFriendForm' onclick=\"return confirm('Are you sure you want to remove this friend?')\">
                                            <p class='removeFriend-text'>Remove Friend</p></button>
                                    </form>
                                </div>";
                        } else {
                            //Check if friend request is pending if the
                            //user is the request reciever
                            if(getFriendRequestStatus($userId, $friendId) == "waiting") {
                                //Accept friend request button
                                echo "<div class='request-container'>
                                        <div class='profile-settings'>
                                            <form action='../actions/Friend_act.php?user_id=" . $friendId . "' method='POST'>
                                                <button class='acceptRequest-btn' id='acceptRequest-btn' name='acceptFriendForm'>
                                                    <p class='acceptRequest-text'>Accept Request</p></button>
                                            </form>
                                        </div>";
                                //Decline friend request button
                                echo "<div class='profile-settings'>
                                        <form action='../actions/Friend_act.php?user_id=" . $friendId . "' method='POST'>
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
                                $friendRequestStatus = getFriendRequestStatus($userId, $friendId);
                                $friendBtnText = "";
                                if($friendRequestStatus == "pending") {
                                    $friendBtnText = "Pending";
                                } else {
                                    $friendBtnText = "Add Friend";
                                }
                                    echo "<div class='profile-settings'>
                                        <form action='../actions/Friend_act.php?user_id=" . $_GET['user_id'] . "&status=" . $friendRequestStatus . "' method='POST'>
                                            <button class='addFriend-btn'' id='addFriend-btn' name='friendForm'>
                                                <p class='addFriend-text' name='status'> " . $friendBtnText . "</p>
                                            </button>
                                        </form> 
                                </div>";
                            }
                    }
                }
        echo "</div>";
        //Close connection
        $conn->close();
    }
?>