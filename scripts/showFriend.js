// Get the request button
const requestBtn = document.querySelector(".request-view-btn");

// Add click event listener to the request button
requestBtn.addEventListener("click", () => {
    // Get the request box
    const requestBox = document.querySelector(".request-box");

    // Toggle the visibility of the request box
    requestBox.classList.toggle("hidden");
    // Change the text of the button
    requestBtn.innerHTML = requestBox.classList.contains("hidden") ? "View Requests" : "Hide Requests";
})

const friendBtn = document.querySelector(".friends-view-btn");

// Add click event listener to the request button
friendBtn.addEventListener("click", () => {
    // Get the request box
    const friendBox = document.querySelector(".friends-mobile-box");

    // Toggle the visibility of the request box
    friendBox.classList.toggle("hidden");
    // Change the text of the button
    friendBtn.innerHTML = friendBox.classList.contains("hidden") ? "View Friends" : "Hide Friends";
})