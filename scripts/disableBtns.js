// Disable comment button
function disableCommentBtn() {
    document.getElementById("commentBtn").style.display = "none";

    //Change Comment Title When Comment is Submitted
    document.getElementById("commentTitle").innerHTML = "Commenting...";
}


// Disable Post button
function disablePostBtn() {
    document.getElementById("postBtn").style.display = "none";
    document.getElementById("backBtn").style.display = "none";

    //Change Post Title When Post is Submitted
    document.getElementById("postTitle").innerHTML = "Posting...";
}

