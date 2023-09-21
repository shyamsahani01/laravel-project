@extends('admin.layout.app')
@section('content')

    <div class="main-panel">
        <!-- Navbar -->
        <div class="content">
            <div class="card-header">
                <div class="row" style="margin-left: -32px;">
                    <div class="col-md-8">
                        <!-- {{-- <div class="bg-primary p-2 text-white">
                            <h4>PowerBi Login</h4>
                        <span> <b>UserName :- </b> pankaj.kumar@jewelalliance.onmicrosoft.com </span>
                        <span> <b>Password :- </b> Pank#14312312 </span>
                        </div> --}} -->
                    </div>
                </div>
            </div>
            <button id="go-button-hrp-report" class="btn btn-primary go-button-hrp">Enable Full Screen</button>
            <a class="btn btn-primary pull-right" href="{{url('/reports')}}" style="margin-right: 22px">BacK</a>
             <div class="row card container-fluid" id="element">
                <div class="row">
                    <iframe width="100%" id="go-button-hrp-report-iframe" height="541.25" src="https://app.powerbi.com/view?r=eyJrIjoiMjdhNzM2NDYtY2NjZS00MWUxLTg0NTgtNTAwMzBhNDdmMGZhIiwidCI6IjdiMTRjNmE3LTE4MTktNDE2NC1iMjEyLTFlZDNlZTQyMzIxOSJ9" style="min-height:100vh;width:100%" frameborder="0" allowFullScreen="true"></iframe>
                </div>
             </div>
        </div>
        <!-- Footer -->

    </div>

@endsection


@section('footer-scripts')

<script>

$("#go-button-hrp-report").on('click', function() {
    if(IsFullScreenCurrently())
        GoOutFullscreen();
    else
        GoInFullscreen($("#go-button-hrp-report-iframe").get(0));
});


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

$(".go-button").on('click', function() {
    if(IsFullScreenCurrently())
        GoOutFullscreen();
    else
        GoInFullscreen($(".element").get(0));
});

$(".go-button-sale").on('click', function() {
    if(IsFullScreenCurrently())
        GoOutFullscreen();
    else
        GoInFullscreen($(".element-sale").get(0));
});

$(".go-button-crm").on('click', function() {
    if(IsFullScreenCurrently())
        GoOutFullscreen();
    else
        GoInFullscreen($(".element-crm").get(0));
});$(".go-button-hr").on('click', function() {
    if(IsFullScreenCurrently())
        GoOutFullscreen();
    else
        GoInFullscreen($(".element-hr").get(0));
});
$(".go-button-hrp").on('click', function() {
    if(IsFullScreenCurrently())
        GoOutFullscreen();
    else
        GoInFullscreen($(".element-hrp").get(0));
});

$(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange', function() {
    if(IsFullScreenCurrently()) {
        $(".go-button").hide();
        $(".go-button").text('Disable Full Screen');
    }
    else {
        $(".go-button").text('');
        $(".go-button").attr("style", "display:block !important; margin-top: -39px; margin-right: 34px;");
    }
});

$(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange', function() {
    if(IsFullScreenCurrently()) {
        $(".go-button-sale").hide();
        $(".go-button-sale").text('Disable Full Screen');
    }
    else {
        $(".go-button-sale").text('');
        $(".go-button-sale").attr("style", "display:block !important; margin-top: -39px; margin-right: 34px;");
    }
});
$(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange', function() {
    if(IsFullScreenCurrently()) {
        $(".go-button-crm").hide();
        $(".go-button-crm").text('Disable Full Screen');
    }
    else {
        $(".go-button-crm").text('');
        $(".go-button-crm").attr("style", "display:block !important; margin-top: -39px; margin-right: 34px;");
    }
});
$(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange', function() {
    if(IsFullScreenCurrently()) {
        $(".go-button-hr").hide();
        $(".go-button-hr").text('Disable Full Screen');
    }
    else {
        $(".go-button-hr").text('');
        $(".go-button-hr").attr("style", "display:block !important; margin-top: -39px; margin-right: 34px;");
    }
});
$(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange', function() {
    if(IsFullScreenCurrently()) {
        $(".go-button-hrp").hide();
        $(".go-button-hrp").text('Disable Full Screen');
    }
    else {
        $(".go-button-hrp").text('');
        $(".go-button-hrp").attr("style", "display:block !important; margin-top: -39px; margin-right: 34px;");
    }
});
</script>


@endsection
