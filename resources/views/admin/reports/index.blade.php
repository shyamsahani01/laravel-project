@extends('admin.layout.app')
@section('content')

    <div class="main-panel">
        <!-- Navbar -->
        <div class="content">
             <div class="row card container-fluid">
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <!-- <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <a href="{{ url('/reports/purchase-reports') }}">
                        <div class="card bg-primary" style="margin-bottom: 10px;">
                            <div class="card-header p-3 pt-2 ">
                            <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                <i class="fa fa-shopping-cart" style="color:white;font-size: 30px;padding-top: 23px;"></i>
                            </div>
                            <div class="text-end pt-1 pull-right">
                                <h4 class="mb-0" style="color: white;font-size: 22px;">Purchase Reports</h4>
                            </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                            {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than lask week</p> --}}
                            </div>
                        </div>
                      </a>
                    </div> -->
                    <!-- <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                      <a href="{{ url('/reports/sales-eports') }}">
                        <div class="card bg-success">
                            <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="fa fa-user" style="color:white;font-size: 30px;padding-top: 23px;"></i>
                            </div>
                            <div class="text-end pt-1 pull-right">
                                <h4 class="mb-0" style="color: white;font-size: 22px;">Sales Reports</h4>
                            </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                            {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than lask month</p> --}}
                            </div>
                        </div>
                      </a>
                    </div> -->
                    <!-- <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                     <a href="{{ url('/reports/crm-reports') }}">
                            <div class="card bg-info">
                                <div class="card-header p-3 pt-2">
                                <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="fa fa-user" style="color:white;font-size: 30px;padding-top: 23px;"></i>
                                </div>
                                <div class="text-end pt-1 pull-right">
                                    <h4 class="mb-0" style="color: white;font-size: 22px;">CRM Reports</h4>
                                </div>
                                </div>
                                <hr class="dark horizontal my-0">
                                <div class="card-footer p-3">
                                {{-- <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> than yesterday</p> --}}
                                </div>
                            </div>
                     </a>
                    </div> -->
                    <div class="col-xl-3 col-sm-6">
                      <a href="{{ url('/reports/hr-reports') }}">
                        <div class="card bg-info">
                            <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="fa fa-user" style="color:white;font-size: 30px;padding-top: 23px;"></i>
                            </div>
                            <div class="text-end pt-1 pull-right">
                                <h4 class="mb-0" style="color: white;font-size: 22px;padding-bottom: 25px;">HR Reports</h4>
                            </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                            {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+5% </span>than yesterday</p> --}}
                            </div>
                        </div>
                      </a>
                    </div>
                     <div class="col-xl-3 col-sm-6">
                      <a href="{{ url('/reports/hr-reports-process') }}">
                        <div class="card bg-success">
                            <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="fa fa-user" style="color:white;font-size: 30px;padding-top: 23px;"></i>
                            </div>
                            <!-- <div class="text-end pt-1 pull-right">
                                <h4 class="mb-0" style="color: white;font-size: 22px;">HR Reports In Process</h4>
                            </div> -->
                            <div class="text-end pt-1 pull-right">
                                <h4 class="mb-0" style="color: white;font-size: 22px;margin-left: 97px;">Payroll Reports</h4>
                            </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3">
                            {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+5% </span>than yesterday</p> --}}
                            </div>
                        </div>
                      </a>
                    </div>

                    {{-- <div class="col-md-6">
                        <form method="POST" action="{{ url('file-import') }}" enctype="multipart/form-data">
                            @csrf
                         <input type="file" class="form-control" name="file">
                         <button type="submit" class="btn btn-primary">Uploade</button>
                        </form>
                    </div> --}}
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
