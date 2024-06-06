let userInput = document.getElementById("username");
let emailInput = document.getElementById("email");

function emailAvailable() {
    let email = emailInput.value;
    if (email) {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "../actions/checkEmail.php?email=" + email, true);
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let response = this.responseText;
                if (response == "true") {
                    document.getElementById("emailError").innerHTML = "Email already exists";
                } else {
                    document.getElementById("emailError").innerHTML = "";
                }
            }
        };
        xhr.send();
    }
}


function userAvailable() {
    let user = userInput.value;
    if (user) {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "../actions/checkUser.php?user=" + user, true);
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let response = this.responseText;
                if (response == "true") {
                    document.getElementById("userError").innerHTML = "Username already exists";
                } else {
                    document.getElementById("userError").innerHTML = "";
                }
            }
        };
        xhr.send();
    }
}