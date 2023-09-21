/* Get into full screen */
function GoInFullscreen(element) {
    if(element.requestFullscreen)
        element.requestFullscreen();
    else if(element.mozRequestFullScreen)
        element.mozRequestFullScreen();
    else if(element.webkitRequestFullscreen)
        element.webkitRequestFullscreen();
    else if(element.msRequestFullscreen)
        element.msRequestFullscreen();
}

/* Get out of full screen */
function GoOutFullscreen() {
    if(document.exitFullscreen)
        document.exitFullscreen();
        
    else if(document.mozCancelFullScreen)
        document.mozCancelFullScreen();
    else if(document.webkitExitFullscreen)
        document.webkitExitFullscreen();
    else if(document.msExitFullscreen)
        document.msExitFullscreen();
}

/* Is currently in full screen or not */
function IsFullScreenCurrently() {
    var full_screen_element = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement || null;
    
    // If no element is in full-screen
    if(full_screen_element === null)
        return false;
    else
        return true;
}

$("#go-button").on("click", function () {
    if (IsFullScreenCurrently()) GoOutFullscreen();
    else GoInFullscreen($("#element").get(0));
});

$(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange', function() {
    if(IsFullScreenCurrently()) {
        $("#go-button").hide();
        $("#go-button").text("Disable Full Screen");
    }
    else {
        $("#go-button").text('Enable Full Screen');
        $("#go-button").attr("style", "display:block !important; margin-top: -39px; margin-right: 355px;");
    }
});