<table>
    <thead>
    <tr>
        <th>S.NO</th>
        <th>Employee</th>
        <th>Employee Name</th>
        <th>Company</th>
        <th>Department</th>
        <th>Shift</th>
        <th>Log Type</th>
        <th>Status</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($attendncedata))
        @foreach($attendncedata as $missing)
            @if($missing->status == 'Absent')
            @php $datas = Helper::outmissindata($missing->employee,$startdate,$enddate) @endphp
                @foreach($datas as $key => $checkdata)
                    <tr>
                        @if($checkdata->log_type != 'OUT' && $checkdata->log_type == 'IN')
                            <td>{{ $key+1 }}</td>
                            <td>{{ $missing->employee }}</td>
                            <td>{{ $missing->employee_name }}</td>
                            <td>{{ $missing->company }}</td>
                            <td>{{ $missing->department }}</td>
                            <td>{{ $missing->shift }}</td>
                            <td>{{ $checkdata->log_type }}</td>
                            <td>{{ $missing->status }}</td>
                            <td>{{ $missing->attendance_date }}</td>    
                        @endif
                    </tr>
                @endforeach
            @endif
        @endforeach
    @endif
    </tbody>
</table>