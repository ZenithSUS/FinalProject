// Get all buttons and input elements
const replyBtn = document.querySelectorAll(".replyBtn");
const replyInput = document.querySelectorAll(".replyInput");

// Add click event listener to each button
replyBtn.forEach((btn) => {
    btn.addEventListener("click", () => {
        // Get the parent element then the ancestor parent of the button and the 
        //next sibling element then the next sibling by class name
        btn.parentElement.parentElement.nextElementSibling.nextElementSibling.classList.toggle("hidden");

        // Change the text of the button
        // Using ternary operator and decleration of variable
        btn.innerHTML = btn.innerHTML === "Reply" ? "Cancel" : "Reply";
      
        //Get all reply boxes
        //Close other reply boxes if other reply boxes are open
        replyBtn.forEach((otherBtn) => {
            // Check if the other button is not the current button and the next sibling is not hidden
            // If it is not the current button and the next sibling is not hidden, close it
            if (otherBtn !== btn) {
                // Add the hidden class to the next sibling element then the next sibling by class name
                otherBtn.parentElement.parentElement.nextElementSibling.nextElementSibling.classList.add("hidden");
                otherBtn.innerHTML = "Reply";

                // Remove the value of the replyInput element
                replyInput.forEach((input) => {
                    input.value = "";
                })
            }
        });

    });
})