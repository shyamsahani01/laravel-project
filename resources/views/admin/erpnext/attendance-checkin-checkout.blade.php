@extends('admin.layout.app')

@section('content')
    <div class="main-panel">
        @includeif('admin.layout.navbar')
        <div class="content">
            @includeif('admin.erpnext.filters')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ $title }}</h4>
                            <p class="card-category"> All Stock Ledger Listing</p>
                            {{-- <a href="{{ url('add-user') }}" class="btn btn-success btn-sm pull-right" style="margin-top:-43px;"><i class="fa fa-plus"></i> Add User</a> --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>S.NO.</th>
                                            <th>Employee Code</th>
                                            <th>Employee Name</th>
                                            <th>Log Type</th>
                                            <th>Device Id</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($attendnces) > 0)
                                           @php $count = 1 @endphp
                                            @foreach($attendnces as $attendnce)
                                                <tr>
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ $attendnce->employee}}</td>
                                                    <td>{{ $attendnce->employee_name }}</td>
                                                    <td class="text-success" style="font-weight: 900;">{{ $attendnce->log_type}}</td>
                                                    <td>{{ $attendnce->device_id}}</td>
                                                    <td>{{ date('d-m-Y',strtotime($attendnce->time)) }}</td>
                                                    <td>{{ date('H:i:s',strtotime($attendnce->time)) }}</td>
                                                    <td><a href="https://erp.pinkcityindia.com/app/employee-checkin/{{ $attendnce->name }}" class="btn btn-success" target="_blanck">View</a></td>
                                                </tr>
                                            @endforeach
                                        @else
                                          <tr>
                                            <td colspan="10" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
                                           </tr>
                                        @endif

                                    </tbody>
                                </table>
                                <div class="pagination pull-right">
                                    {{ $attendnces->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <footer class="footer">
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
