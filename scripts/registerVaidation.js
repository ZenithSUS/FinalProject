// Get inputs using DOM
let userInput = document.getElementById("username");
let emailInput = document.getElementById("email");

// Function to check if email is available
function emailAvailable() {
    let email = emailInput.value;
    // if email is not empty
    if (email) {
        // create an XMLHttpRequest object
        let xhr = new XMLHttpRequest();
        // open the request
        xhr.open("GET", "../actions/checkEmail.php?email=" + email, true);
        // on ready state change
        xhr.onreadystatechange = function () {
            // if response is ready and status is 200
            if (this.readyState == 4 && this.status == 200) {
                let response = this.responseText;
                // if email already exists
                if (response == "true") {
                    document.getElementById("emailError").innerHTML = "Email already exists";
                } else {
                    document.getElementById("emailError").innerHTML = "";
                }
            }
        };
        // send the request
        xhr.send();
    }
}


// Function to check if username is available
function userAvailable() {
    let user = userInput.value;
    // if username is not empty
    if (user) {
        let xhr = new XMLHttpRequest();
        // open the request
        xhr.open("GET", "../actions/checkUser.php?user=" + user, true);
        // on ready state change
        xhr.onreadystatechange = function () {
            // if response is ready and status is 200
            if (this.readyState == 4 && this.status == 200) {
                let response = this.responseText;
                // if username already exists
                if (response == "true") {
                    document.getElementById("userError").innerHTML = "Username already exists";
                } else {
                    document.getElementById("userError").innerHTML = "";
                }
            }
        };
        // send the request
        xhr.send();
    }
}