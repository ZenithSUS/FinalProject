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
            // ResponseText is a string of HTML getting the contents from the searchPages.php
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
                var matchedResults = resultsItems[0].getAttribute("data-greek-id");
                // Redirect to the user profile
                window.location.href = "heroes.php?greek_id=" + matchedResults + "";
            }
        }
    };

    // Send the request
    xhr.open("GET", "actions/search/searchPages.php?q=" + query + "", true);
    xhr.send();
}

// Add enter key listener to the search input
document.getElementById("searchInput").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        var input = document.getElementById('searchInput').value;

        // Set the custom attribute enter-pressed to true
        document.getElementById("search-results").setAttribute("data-enter-pressed", "true");
        performSearch(input);
    }
})

//Add Function to button search
document.getElementById("searchButton").addEventListener("click", () => {
    //Set the custom attribute enter-pressed to true when the search button is clicked
    document.getElementById("search-results").setAttribute("data-enter-pressed", "true");
    search();
});

// Add search function to Perform search in the user folders
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
                var matchedResults = resultsItems[0].getAttribute("data-greek-id");
                // Redirect to the user profile
                window.location.href = "../heroes.php?greek_id=" + matchedResults + "";
            }
        }
    };

    // Send the request
    xhr.open("GET", "../actions/search/searchPagesUser.php?q=" + query + "", true);
    xhr.send();
}

// Add enter key listener to the search input
document.getElementById("searchInput").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        var input = document.getElementById('searchInput').value;

        // Set the custom attribute enter-pressed to true
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
    performMobileSearch(input)
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
                var matchedResults = resultsItems[0].getAttribute("data-greek-id");
                // Redirect to the user profile
                window.location.href = "heroes.php?greek_id=" + matchedResults + "";
            }
        }
    };

    // Send the request
    xhr.open("GET", "actions/search/searchPages.php?q=" + query + "", true);
    xhr.send();
}

// Add enter key listener to the search input
document.getElementById("searchInput-mobile").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        var input = document.getElementById('searchInput-mobile').value;

        // Set the custom attribute enter-pressed to true
        document.getElementById("search-results-mobile").setAttribute("data-enter-pressed", "true");
        performMobileSearch(input);
    }
})



//Add Function to button search mobile
document.getElementById("searchButton-mobile").addEventListener("click", () => {
    //Set the custom attribute enter-pressed to true when the search button is clicked
    document.getElementById("search-results-mobile").setAttribute("data-enter-pressed", "true");
    MobileSearch();
});


// Search Function to Mobile
const MobileSearchUser = () => {
    var input = document.getElementById('searchInput-mobile').value
    // Perform search
    performMobileSearchUser(input)
}

// Array of search results
// Create a arrow function to perform the search
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
                var matchedResults = resultsItems[0].getAttribute("data-greek-id");
                // Redirect to the user profile
                window.location.href = "../heroes.php?greek_id=" + matchedResults + "";
            }
        }
    };

    // Send the request
    xhr.open("GET", "../actions/search/searchPagesUser.php?q=" + query + "", true);
    xhr.send();
}

// Add enter key listener to the search input
document.getElementById("searchInput-mobile").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        var input = document.getElementById('searchInput-mobile').value;

        // Set the custom attribute enter-pressed to true
        document.getElementById("search-results-mobile").setAttribute("data-enter-pressed", "true");
        performMobileSearchUser(input);
    }
})



//Add Function to button search mobile from user folder
document.getElementById("searchButton-mobile").addEventListener("click", () => {
    //Set the custom attribute enter-pressed to true when the search button is clicked
    document.getElementById("search-results-mobile").setAttribute("data-enter-pressed", "true");
    MobileSearchUser();
});