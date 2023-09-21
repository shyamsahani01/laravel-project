@extends('admin.layout.app')
@section('content')

    <div class="main-panel">
        <!-- Navbar -->
        <div class="content">
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
                    <iframe width="100%" height="541.25" src="https://app.powerbi.com/view?r=eyJrIjoiOGY0ZmE0MWQtODI3ZS00ZGI5LWE1ZGQtMGFiMjZhNDc4YjJkIiwidCI6IjdiMTRjNmE3LTE4MTktNDE2NC1iMjEyLTFlZDNlZTQyMzIxOSJ9" style="min-height:100vh;width:100%" frameborder="0" allowFullScreen="true"></iframe>
                </div>
             </div>
        </div>
        <!-- Footer -->
{{--         <footer class="footer">
            <div class="container-fluid">
                <nav class="float-left">
                    <ul>
                        <li>
                            <a href="https://www.creative-tim.com">
                                Creative Tim
                            </a>
                        </li>
                        <li>
                            <a href="https://creative-tim.com/presentation">
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="http://blog.creative-tim.com">
                                Blog
                            </a>
                        </li>
                        <li>
                            <a href="https://www.creative-tim.com/license">
                                Licenses
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright float-right">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>, made with <i class="material-icons">favorite</i> by
                    <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a> for a better web.
                </div>
            </div>
        </footer> --}}
    </div>

@endsection


@section('footer-scripts')

@endsection
