@extends('admin.layout.app')
@section('content')
<style>
.content {
    margin-top: 9px !important;
}
.text {
    display: none !important;
}
</style>
<div class="main-panel">
        <!-- Navbar -->
        <!-- End Navbar -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="card">

                            <div class="card-body" style="">
                                <div class="row">
                                    @if(auth()->user()->role == 'superadmin')

                                    <div class="col-md-4" style="background-color: #eee; border: 1px solid;">
                                        <h3 class="font-weight-bold" style="font-size: 1.25rem;text-align: center;color: black;">CRM Dashboard</h3>
                                        <button id="go-button" class="btn btn-primary fa fa-expand pull-right go-button-crm" style="margin-top: -39px;"></button>
                                        <!-- <embed type="text/html" class="element-crm" height="210" width="100%" src="https://app.powerbi.com/view?r=eyJrIjoiM2MzODJhNjgtMGY5YS00MTVkLWE3NmYtMzU4ZTk1NTZhNDI3IiwidCI6IjdiMTRjNmE3LTE4MTktNDE2NC1iMjEyLTFlZDNlZTQyMzIxOSJ9&pageName=ReportSection34a62c40ffdd69b2564c" width="500" height="800"> -->
                                        <embed type="text/html" class="element-crm" height="210" width="100%" src="https://app.powerbi.com/view?r=eyJrIjoiNTJhODMwMDgtZDJmNS00OWRlLTk4M2EtZTg2Y2JlYzQ2ZjljIiwidCI6IjdiMTRjNmE3LTE4MTktNDE2NC1iMjEyLTFlZDNlZTQyMzIxOSJ9" width="500" height="800">
                                        <!-- <embed type="text/html" class="element-crm" height="210" width="100%" src="https://app.powerbi.com/view?r=eyJrIjoiNDRkZGY4NDUtNDk5Yy00YTc5LWI0MTctYzg1OGFkZTI2MjEzIiwidCI6IjdiMTRjNmE3LTE4MTktNDE2NC1iMjEyLTFlZDNlZTQyMzIxOSJ9" width="500" height="800"> -->
                                    </div>


                                    <!-- <div class="col-md-4" style="background-color: #eee; border: 1px solid;">
                                        <h3 class="font-weight-bold" style="font-size: 1.25rem;text-align: center;color: black;"">Sales Report</h3>
                                        <button id="go-button" class="btn btn-primary fa fa-expand pull-right go-button-sale" style="margin-top: -39px;"></button>
                                        <embed  type="text/html" class="element-sale" height="210" width="100%" src="https://app.powerbi.com/view?r=eyJrIjoiOGY0ZmE0MWQtODI3ZS00ZGI5LWE1ZGQtMGFiMjZhNDc4YjJkIiwidCI6IjdiMTRjNmE3LTE4MTktNDE2NC1iMjEyLTFlZDNlZTQyMzIxOSJ9" width="500" height="800">
                                    </div> -->

                                    <div class="col-md-4" style="background-color: #eee; border: 1px solid;">
                                        <h3 class="font-weight-bold" style="font-size: 1.25rem;text-align: center;color: black;">Sales Dashboard</h3>
                                        <button id="go-button1" class="btn btn-primary fa fa-expand pull-right go-button-sale" style="margin-top: -39px;"></button>
                                        <embed  type="text/html" class="element-sale" height="210" width="100%" src="https://app.powerbi.com/view?r=eyJrIjoiYzMwZDYwMjctOTQ0MS00YWVjLTliNmUtZmI4OTY0MDI4YTFlIiwidCI6IjdiMTRjNmE3LTE4MTktNDE2NC1iMjEyLTFlZDNlZTQyMzIxOSJ9" width="500" height="800">
                                    </div>
                                    <div class="col-md-4" style="background-color: #eee; border: 1px solid;">
                                        <h3 class="font-weight-bold" style="font-size: 1.25rem;text-align: center;color: black;">Purchase Report-In Process</h3>
                                        <button id="go-button2" class="btn btn-primary fa fa-expand pull-right go-button" style="margin-top: -39px;"></button>
                                        <embed type="text/html" class="element" height="210" width="100%" style="span.text display:none;" src="https://app.powerbi.com/view?r=eyJrIjoiYjFhZDExODUtYmYxYi00NzFiLWE0ZGQtYjAxYzE4NWYyN2I4IiwidCI6IjdiMTRjNmE3LTE4MTktNDE2NC1iMjEyLTFlZDNlZTQyMzIxOSJ9&pageName=ReportSection" width="500" height="800">
                                    </div>
                                    @endif

                                    <!-- @if(auth()->user()->role == 'superadmin' || auth()->user()->role == 'attendance')
                                    <div class="col-md-6" style="background-color: #eee; border: 1px solid;">
                                        <h3 class="font-weight-bold">HR Report</h3>
                                        <button id="go-button" class="btn btn-primary fa fa-expand pull-right go-button-hr" style="margin-top: -39px; margin-right: 34px;"></button>
                                        <embed type="text/html" class="element-hr" height="210" width="100%" src="https://app.powerbi.com/view?r=eyJrIjoiNDVkNGQ5MDMtNGYyMS00NDk3LTg5YmMtYzI4MDNjMjU0MTA2IiwidCI6IjdiMTRjNmE3LTE4MTktNDE2NC1iMjEyLTFlZDNlZTQyMzIxOSJ9&pageName=ReportSection" width="500" height="800">
                                        </div>
                                    @endif -->

                                    @if(auth()->user()->role == 'superadmin' || auth()->user()->role == 'attendance')
                                     <div class="col-md-4" style="background-color: #eee; border: 1px solid;">
                                        <h3 class="font-weight-bold" style="font-size: 1.25rem;text-align: center;color: black;">HRM Dashboard</h3>
                                        <button id="go-button3" class="btn btn-primary fa fa-expand pull-right go-button-hr" style="margin-top: -39px;"></button>
                                        <!-- <embed type="text/html" class="element-hr" height="210" width="100%" src="https://app.powerbi.com/view?r=eyJrIjoiN2IzZjUwMTQtNGIzZi00ZDVhLTkwM2QtNDc1NmY2NzlhYzI2IiwidCI6IjdiMTRjNmE3LTE4MTktNDE2NC1iMjEyLTFlZDNlZTQyMzIxOSJ9&pageName=ReportSection"  width="500" height="800"> -->
                                        <!-- <embed type="text/html" class="element-hr" height="210" width="100%" src="https://app.powerbi.com/view?r=eyJrIjoiNjZmZTcyOGEtNjNkOC00ZDRjLWE3MDgtMDRkZmU0MzliODAzIiwidCI6IjdiMTRjNmE3LTE4MTktNDE2NC1iMjEyLTFlZDNlZTQyMzIxOSJ9"  width="500" height="800"> -->
                                        <embed type="text/html" class="element-hr" height="210" width="100%" src="https://app.powerbi.com/view?r=eyJrIjoiYmZhOWM0ZTctYTI1Yy00NmQ4LTlmMjYtMjQ0NTYzY2VkZDAwIiwidCI6IjdiMTRjNmE3LTE4MTktNDE2NC1iMjEyLTFlZDNlZTQyMzIxOSJ9"  width="500" height="800">
                                    </div>
                                    @endif

                                    @if(auth()->user()->role == 'superadmin' || auth()->user()->role == 'attendance')
                                     <div class="col-md-4" style="background-color: #eee; border: 1px solid;">
                                        <h3 class="font-weight-bold" style="font-size: 1.25rem;text-align: center;color: black;">Payroll Dashboard</h3>
                                        <button id="go-button4" class="btn btn-primary fa fa-expand pull-right go-button-hr-payroll" style="margin-top: -39px;"></button>
                                        <embed type="text/html" class="element-hr-payroll" height="210" width="100%" src="https://app.powerbi.com/view?r=eyJrIjoiMjdhNzM2NDYtY2NjZS00MWUxLTg0NTgtNTAwMzBhNDdmMGZhIiwidCI6IjdiMTRjNmE3LTE4MTktNDE2NC1iMjEyLTFlZDNlZTQyMzIxOSJ9"  width="500" height="800">
                                    </div>
                                    @endif


                                    @if(auth()->user()->role == 'superadmin' )
                                     <div class="col-md-4" style="background-color: #eee; border: 1px solid;">
                                        <h3 class="font-weight-bold" style="font-size: 1.25rem;text-align: center;color: black;">HR and Payroll Dashboard</h3>
                                        <!-- <h6> ID :: itsupport@pinkcityjewels.in, PW :: pink@925</h6> -->
                                        <button id="go-button5" class="btn btn-primary fa fa-expand pull-right go-button-hr-and-payroll" style="margin-top: -39px;"></button>
                                        <!-- <embed type="text/html" class="element-hr-and-payroll" height="210" width="100%" src="https://app.powerbi.com/reportEmbed?reportId=978ca307-0d4f-49d1-a290-62b7dc092dd2&autoAuth=true&ctid=7b14c6a7-1819-4164-b212-1ed3ee423219"  > -->
                                        <!-- <iframe title="HR and Payroll" height="210" width="100%" class="element-hr-and-payroll" src="https://app.powerbi.com/reportEmbed?reportId=f90fe030-f88f-46f0-a93f-c420c127038c&autoAuth=true&ctid=7b14c6a7-1819-4164-b212-1ed3ee423219" frameborder="0" allowFullScreen="true"></iframe> -->
                                        <iframe title="HR and Payroll" height="210" width="100%" class="element-hr-and-payroll" src="https://app.powerbi.com/view?r=eyJrIjoiMjA0NTRlMDItMWJlZS00NzE4LWE4ZDktOWFlMTVhYjE4MWUzIiwidCI6IjdiMTRjNmE3LTE4MTktNDE2NC1iMjEyLTFlZDNlZTQyMzIxOSJ9" frameborder="0" allowFullScreen="true"></iframe>
                                    </div>
                                    @endif

                                    @if(auth()->user()->role == 'superadmin' )
                                     <div class="col-md-4" style="background-color: #eee; border: 1px solid;">
                                        <h3 class="font-weight-bold" style="font-size: 1.25rem;text-align: center;color: black;">Water Consumption Dashboard</h3>
                                        <button id="go-button6" class="btn btn-primary fa fa-expand pull-right go-button-water" style="margin-top: -39px;"></button>
                                        <embed type="text/html" class="element-water" height="210" width="100%" src="https://app.powerbi.com/view?r=eyJrIjoiYzc5NWU3MDUtOTVkNi00MzZlLWE3YjYtYTAxNTY5NjljOWYxIiwidCI6IjdiMTRjNmE3LTE4MTktNDE2NC1iMjEyLTFlZDNlZTQyMzIxOSJ9"  width="500" height="800">
                                    </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>


                </div>

            </div>
        </div>


        <!-- Footer -->
    </div>



@endsection


@section('footer-scripts')

<script>
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
$(".go-button-hr-payroll").on('click', function() {
    if(IsFullScreenCurrently())
        GoOutFullscreen();
    else
        GoInFullscreen($(".element-hr-payroll").get(0));
});

$(".go-button-hr-and-payroll").on('click', function() {
    if(IsFullScreenCurrently())
        GoOutFullscreen();
    else
        GoInFullscreen($(".element-hr-and-payroll").get(0));
    // window.open("https://app.powerbi.com/reportEmbed?reportId=f90fe030-f88f-46f0-a93f-c420c127038c&autoAuth=true&ctid=7b14c6a7-1819-4164-b212-1ed3ee423219", '_blank');
});

$(".go-button-water").on('click', function() {
    if(IsFullScreenCurrently())
        GoOutFullscreen();
    else
        GoInFullscreen($(".element-water").get(0));
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
        $(".go-button-hr-payroll").hide();
        $(".go-button-hr-payroll").text('Disable Full Screen');
    }
    else {
        $(".go-button-hr-payroll").text('');
        $(".go-button-hr-payroll").attr("style", "display:block !important; margin-top: -39px; margin-right: 34px;");
    }
});
</script>


@endsection
