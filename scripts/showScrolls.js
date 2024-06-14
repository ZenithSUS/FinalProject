const otherScroll = document.getElementById("other-scroll");

window.mouseover = function () {
    scrollFunction();
};

// Show Scroll if the mouse is place on the content
function scrollFunction() {
   otherScroll.style.scroll = "visible";
}