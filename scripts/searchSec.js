

const search = () => {
    var input = document.getElementById('searchInput').value
    // Perform search
    performSearch(input)
}

// Array of search results
performSearch = (query) => {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var resultsContainer = document.getElementById("search-results");
            // Get the search results in the xhr.responseText
            // ResponseText is a string of HTML
            resultsContainer.innerHTML = this.responseText;

            // Check if the enter key was pressed
            var enterPressed = resultsContainer.getAttribute("data-enter-pressed");

            // Check if there are results
            var resultsItems = resultsContainer.getElementsByClassName("item");

            if (resultsItems.length >= 0 && enterPressed == "true") {
                var matchedResults = resultsItems[0].getAttribute("data-user-id");
                window.location.href = "../user/profile.php?user_id=" + matchedResults + "";
            }
        }
    };
    xhr.open("GET", "../actions/search.php?q=" + query + "", true);
    xhr.send();
}

// Add enter key listener
document.getElementById("searchInput").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        var input = document.getElementById('searchInput').value;

        // Set the custom attribute enter-pressed to true
        document.getElementById("search-results").setAttribute("data-enter-pressed", "true");
        performSearch(input);
    }
})