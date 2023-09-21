<table>
    <thead>
    <tr>
        <th>S.NO</th>
        <th>Date</th>
        <th>Employee Code</th>
        <th>Employee Name</th>
        <th>Department</th>
        <th>Shift</th>
        <th>Company</th>
        <th>InTime</th>
        <th>Out Time</th>
        <th>Total Working Hour</th>
    </tr>
    </thead>
    <tbody>
    @php $count = 1; @endphp
    @if(!empty($response))
        @foreach($response as $res)
          @php
           $res = (array) $res;
          @endphp
            @php
             $timedate = substr($res['intime'], 0, strpos($res['intime'], '.'));
             $outdate = substr($res['outime'], 0, strpos($res['outime'], '.'));
             $intime  = date('H:i:s',strtotime($timedate));
             $outtime  = !empty($res['outime']) ? date('H:i:s',strtotime($outdate)) : '';
             $start_date = new DateTime($intime);
             $end_date = new DateTime($outtime);
             $interval = $start_date->diff($end_date);
             $hours   = $interval->format('%h');
             $minut   = $interval->format('%i');
             $employee = Helper::EmployeeData($res['userid']);
            @endphp
            <tr>
                <td>{{ $count++ }}</td>
                <td>{{ date('d-m-Y',strtotime($res['logdate'])) }}</td>
                <td>@if(!empty($employee)) {{ $employee->employee }} @endif</td>
                <td>@if(!empty($employee)) {{ $employee->employee_name }} @endif</td>
                <td>@if(!empty($employee)) {{ $employee->department }} @endif</td>
                <td>@if(!empty($employee)) {{ $employee->default_shift }} @endif</td>
                <td>@if(!empty($employee)) {{ $employee->company }} @endif</td>
                <td>{{ $intime }}</td>
                <td>{{ $outtime }}</td>
                <td>@if(!empty($outtime)) {{ $hours }} Hours {{ $minut }} Minuts @endif</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
