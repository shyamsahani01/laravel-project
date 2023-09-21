<table>
    <thead>
    <tr>
        <th>S.NO</th>
        <th>Employee Name</th>
        <th>Date</th>
        <th>In Time</th>
        <th>Out Time</th>
        <th>Total Working Hours</th>
        {{-- <th>Over Time</th> --}}
    </tr>
    </thead>
    <tbody>
    @if(!empty($records))
            @foreach($records as $key => $res)
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
                    <td>{{ $key+1 }}</td>
                    <td>{{ $employee->employee_name }}</td>
                    <td>{{ date('d-m-Y',strtotime($timedate)) }}</td>
                    <td>{{ $intime }}</td>
                    <td>{{ $outtime }}</td>
                    <td>@if(!empty($outtime)) {{ $hours }} Hours {{ $minut }} Minuts @endif</td>
                    {{-- <td></td> --}}
                </tr>
            @endif
            @endforeach
    @endif
    </tbody>
</table>