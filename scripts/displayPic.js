// Get the image attribute using DOM 
var file_input = document.getElementById("file_input");
var profile_pic = document.getElementById("profilePic");

file_input.addEventListener("change", function () {
    if(this.files && this.files[0]) {
        // Create a temporary url
        var url = URL.createObjectURL(this.files[0]);
        // Assign the temporary url to the image
        profile_pic.src = url;
        // Display the image
        profile_pic.style.display = "block";
    }
})