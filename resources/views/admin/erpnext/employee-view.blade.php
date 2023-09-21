@extends('admin.layout.app')

@section('content')
    <div class="main-panel">
        @includeif('admin.layout.navbar')
        <div class="content">
            {{-- @includeif('admin.erpnext.filters') --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ $title }}</h4>
                            <p class="card-category"> All Api Record Data</p>
                            <a href="{{ url('checkin-export/'.$employee->employee) }}" class="btn btn-success btn pull-right" style="margin-top:-43px;"><i class="fa fa-plus"></i> Exoprt Data</a>
                        </div>
                        <div class="card-body">
                            <h4>Employee Details</h4>
                        <div class="form-group row">
                            
                            <div class="form-group col-md-3">
                                <b>Employee Name</b> : <a href="https://erp.pinkcityindia.com/app/employee/{{ $employee->employee }}" target="_blanck"> {{ $employee->employee_name }} </a>
                            </div>

                            <div class="form-group col-md-3">
                                <b>Company </b> : {{ $employee->company }}
                            </div>

                            <div class="form-group col-md-3">
                                <b>Department </b> : {{ $employee->department }}
                            </div>

                            <div class="form-group col-md-3">
                                <b>Joiniing Date </b> : {{ date('d-m-Y',strtotime($employee->date_of_joining)) }}
                            </div>
                        
                        </div>
                        <hr style="border: solid;" />
                        <h4>Employee Attendence Data ( {{ date('M') }} )</h4>
                            <table id="example-test" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Intime</th>
                                        <th>Outtime</th>
                                        <th>Total Working Hour</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($records as $res)
                                    @if($res->userid == $employee->employee_number)
                                        @php
                                            $timedate = substr($res->intime, 0, strpos($res->intime, '.'));
                                            $outdate = substr($res->outime, 0, strpos($res->outime, '.'));
                                            $intime  = date('H:i:s',strtotime($timedate));
                                            $outtime  = !empty($res->outime) ? date('H:i:s',strtotime($outdate)) : '';    
                                            $start_date = new DateTime($intime);
                                            $end_date = new DateTime($outtime);
                                            $interval = $start_date->diff($end_date);
                                            $hours   = $interval->format('%h');
                                            $minut   = $interval->format('%i');
                                        @endphp
                                        <tr>
                                            <td>{{ date('d-m-Y',strtotime($timedate)) }}</td>
                                            <td>{{ $intime }}</td>
                                            <td>{{ $outtime }}</td>
                                            <td>@if(!empty($outtime)) {{ $hours }} Hours {{ $minut }} Minuts @endif</td>
                                        </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('footer-scripts')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example-test').DataTable();
    } );
</script>

@endsection




