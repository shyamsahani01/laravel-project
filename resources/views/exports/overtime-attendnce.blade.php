<table>
    <thead>
    <tr>
        <th>S.NO</th>
        <th>Employee</th>
        <th>Employee Name</th>
        <th>Company</th>
        <th>Department</th>
        <th>Shift</th>
        <th>Actual Out Time</th>
        <th>Over Time</th>
        <th>Status</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($attendncedata))
        @foreach($attendncedata as $attdata)
            @if($attdata->status == 'Present')
            @php $datas = Helper::outmissindata($attdata->employee,$startdate,$enddate) @endphp
                @foreach($datas as $key => $checkdata)
                    @if($checkdata->log_type == 'OUT' )
                        @php
                            $fixtime = date('H:i:s',strtotime('2020-10-10 18:30:00'));
                            $actualtime  = date('H:i:s',strtotime($checkdata->time));
                        @endphp
                        @if($fixtime < $actualtime)
                            @php 
                                $start = date_create($fixtime);
                                $end = date_create($actualtime);
                                $overtime = date_diff($start, $end);
                            @endphp
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $checkdata->employee }}</td>
                                <td>{{ $checkdata->employee_name }}</td>
                                <td>{{ $attdata->company }}</td>
                                <td>{{ $attdata->department }}</td>
                                <td>{{ $attdata->shift }}</td>
                                <td>{{ $actualtime }}</td>
                                <td>{{ $overtime->format('%H:%I:%S') }}</td>
                                <td>{{ $attdata->status }}</td>
                                <td>{{ $attdata->attendance_date }}</td>                       
                            </tr>
                        @endif
                    @endif
                @endforeach
            @endif
        @endforeach
    @endif
    </tbody>
</table>