const search = () => {
    var input = document.getElementById('searchInput').value
    // Perform search
    performSearch(input)
}

// Array of search results
// Create a arrow function to perform the search
performSearch = (query) => {
    // Create an XMLHttpRequest object
    // XMLHttpRequest is used to make HTTP requests to the server
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var resultsContainer = document.getElementById("search-results");
            var searchValue = document.getElementById('searchInput').value
            // Get the search results in the xhr.responseText
            // ResponseText is a string of HTML getting the contents from the search.php
            resultsContainer.innerHTML = this.responseText;

            // Check if the enter key was pressed
            var enterPressed = resultsContainer.getAttribute("data-enter-pressed");

            // Check if there are results
            var resultsItems = resultsContainer.getElementsByClassName("item");

            
            // Check if the input is empty
            if(searchValue == "" || searchValue == null) {
                resultsContainer.style.display = "none";
            // If the input is not empty
            } else {
                resultsContainer.style.display = "block";
            }

            // If there are results and the enter key was pressed
            if (resultsItems.length >= 0 && enterPressed == "true") {
                // Get the first result and get the user id attribute
                var matchedResults = resultsItems[0].getAttribute("data-user-id");
                // Redirect to the user profile
                window.location.href = "user/profile.php?user_id=" + matchedResults + "";
            }
        }
    };

    // Send the request
    xhr.open("GET", "actions/search/search.php?q=" + query + "", true);
    xhr.send();
}

// Add enter key listener to the search input
document.getElementById("searchInput").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        var input = document.getElementById('searchInput').value;

        //If the input is not empty
        if(input != "" && input != null) {
            // Set the custom attribute enter-pressed to true if the enter key was pressed and there are results
            document.getElementById("search-results").setAttribute("data-enter-pressed", "true");
            performSearch(input);
        }
    }
})

//Add Function to button search
document.getElementById("searchButton").addEventListener("click", () => {
    //Set the custom attribute enter-pressed to true when the search button is clicked
    document.getElementById("search-results").setAttribute("data-enter-pressed", "true");
    search();
});


const searchUser = () => {
    var input = document.getElementById('searchInput').value
    // Perform search
    performSearchUser(input)
}

// Array of search results
// Create a arrow function to perform the search
performSearchUser = (query) => {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var resultsContainer = document.getElementById("search-results");
            var searchValue = document.getElementById('searchInput').value
            // Get the search results in the xhr.responseText
            // ResponseText is a string of HTML getting the contents from the search.php
            resultsContainer.innerHTML = this.responseText;

            // Check if the enter key was pressed
            var enterPressed = resultsContainer.getAttribute("data-enter-pressed");

            // Check if there are results
            var resultsItems = resultsContainer.getElementsByClassName("item");

            
            // Check if the input is empty
            if(searchValue == "" || searchValue == null) {
                resultsContainer.style.display = "none";
            // If the input is not empty
            } else {
                resultsContainer.style.display = "block";
            }

            // If there are results and the enter key was pressed
            if (resultsItems.length >= 0 && enterPressed == "true") {
                // Get the first result and get the user id attribute
                var matchedResults = resultsItems[0].getAttribute("data-user-id");
                // Redirect to the user profile
                window.location.href = "../user/profile.php?user_id=" + matchedResults + "";
            }
        }
    };

    // Send the request
    xhr.open("GET", "../actions/search/searchUser.php?q=" + query + "", true);
    xhr.send();
}

// Add enter key listener to the search input
document.getElementById("searchInput").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        var input = document.getElementById('searchInput').value;
        // Set the custom attribute enter-pressed to true if the enter key was pressed and there are results
        document.getElementById("search-results").setAttribute("data-enter-pressed", "true");
        performSearchUser(input);
    }
})


//Add Function to button search from user folder
document.getElementById("searchButton").addEventListener("click", () => {
    //Set the custom attribute enter-pressed to true when the search button is clicked
    document.getElementById("search-results").setAttribute("data-enter-pressed", "true");
    searchUser();
});



// Search Function to Mobile
const MobileSearch = () => {
    var input = document.getElementById('searchInput-mobile').value
    // Perform search
    performMobileSearch(input);
}

// Array of search results
// Create a arrow function to perform the search
performMobileSearch = (query) => {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var resultsContainer = document.getElementById("search-results-mobile");
            var searchValue = document.getElementById('searchInput-mobile').value
            // Get the search results in the xhr.responseText
            // ResponseText is a string of HTML getting the contents from the search.php
            resultsContainer.innerHTML = this.responseText;

            // Check if the enter key was pressed
            var enterPressed = resultsContainer.getAttribute("data-enter-pressed");

            // Check if there are results
            var resultsItems = resultsContainer.getElementsByClassName("item");

            // Check if the input is empty
            if(searchValue == "" || searchValue == null) {
                resultsContainer.style.display = "none";
            // If the input is not empty
            } else {
                resultsContainer.style.display = "block";
            }

            // If there are results and the enter key was pressed
            if (resultsItems.length >= 0 && enterPressed == "true") {
                // Get the first result and get the user id attribute
                var matchedResults = resultsItems[0].getAttribute("data-user-id");
                // Redirect to the user profile
                window.location.href = "user/profile.php?user_id=" + matchedResults + "";
            }
        }
    };

    // Send the request
    xhr.open("GET", "actions/search/search.php?q=" + query + "", true);
    xhr.send();
}

// Add enter key listener to the search input Mobile
document.getElementById("searchInput-mobile").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        var input = document.getElementById('searchInput-mobile').value;

        // Set the custom attribute enter-pressed to true
        document.getElementById("search-results-mobile").setAttribute("data-enter-pressed", "true");
        performMobileSearch(input);
    }
})


// Search Function to Mobile in the user folders
const MobileSearchUser = () => {
    var input = document.getElementById('searchInput-mobile').value
    // Perform search
    performMobileSearchUser(input)
}

performMobileSearchUser = (query) => {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var resultsContainer = document.getElementById("search-results-mobile");
            var searchValue = document.getElementById('searchInput-mobile').value
            // Get the search results in the xhr.responseText
            // ResponseText is a string of HTML getting the contents from the search.php
            resultsContainer.innerHTML = this.responseText;

            // Check if the enter key was pressed   
            var enterPressed = resultsContainer.getAttribute("data-enter-pressed");

            // Check if there are results
            var resultsItems = resultsContainer.getElementsByClassName("item");

            // Check if the input is empty
            if(searchValue == "" || searchValue == null) {
                resultsContainer.style.display = "none";
            // If the input is not empty
            } else {
                resultsContainer.style.display = "block";
            }

            // If there are results and the enter key was pressed
            if (resultsItems.length >= 0 && enterPressed == "true") {
                // Get the first result and get the user id attribute
                var matchedResults = resultsItems[0].getAttribute("data-user-id");
                // Redirect to the user profile
                window.location.href = "../user/profile.php?user_id=" + matchedResults + "";
            }
        }
    };

    // Send the request
    xhr.open("GET", "../actions/search/searchUser.php?q=" + query + "", true);
    xhr.send();
}

// Add enter key listener to the search input Mobile in the user folders
document.getElementById("searchInput-mobile").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        var input = document.getElementById('searchInput-mobile').value;

        // Set the custom attribute enter-pressed to true
        document.getElementById("search-results-mobile").setAttribute("data-enter-pressed", "true");
        performMoblieSearchUser(input);
    }
})


//Add Function to button search mobile
document.getElementById("searchButton-mobile").addEventListener("click", () => {
    //Set the custom attribute enter-pressed to true when the search button is clicked
    document.getElementById("search-results-mobile").setAttribute("data-enter-pressed", "true");
    MobileSearchUser();
});