@extends('admin.layout.app')
@section('content')
<style>
#element:-webkit-full-screen {
	width: 100%;
	height: 100%;
	background-color: pink;
	margin: 0;
}
</style>
    <div class="main-panel">
        <!-- Navbar -->
        <div class="content" >
            <div class="card-header">
                <div class="row" style="margin-left: -32px;">
                    <div class="col-md-8">
                        {{-- <div class="bg-primary p-2 text-white">
                            <h4>PowerBi Login</h4>
                        <span> <b>UserName :- </b> pankaj.kumar@jewelalliance.onmicrosoft.com </span>
                        <span> <b>Password :- </b> Pank#14312312 </span>
                        </div> --}}
                    </div>
                </div>
            </div>
            <button id="go-button" class="btn btn-primary">Enable Full Screen</button>
            <a class="btn btn-primary pull-right" href="{{url('/reports')}}" style="margin-right: 22px">BACK</a>
             <div class="row card container-fluid" id="element">
                <div class="row">
                    <iframe width="100%"  height="541.25" src="https://app.powerbi.com/view?r=eyJrIjoiYjFhZDExODUtYmYxYi00NzFiLWE0ZGQtYjAxYzE4NWYyN2I4IiwidCI6IjdiMTRjNmE3LTE4MTktNDE2NC1iMjEyLTFlZDNlZTQyMzIxOSJ9&pageName=ReportSection" style="min-height:100vh;width:100%" frameborder="0" allowFullScreen="true"></iframe>
                </div>
             </div>
        </div>
        <!-- Footer -->

    </div>

@endsection


@section('footer-scripts')

@endsection
