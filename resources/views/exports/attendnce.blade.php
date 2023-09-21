<table>
    <thead>
    <tr>
        <th>S.NO</th>
        <th>Employee</th>
        <th>Employee Name</th>
        <th>Company</th>
        <th>Department</th>
        <th>Shift</th>
        <th>Status</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @php $count = 1; @endphp    
    @if(!empty($attendncedata))
        @foreach($attendncedata as $missing)
                    <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $missing->employee }}</td>
                            <td>{{ $missing->employee_name }}</td>
                            <td>{{ $missing->company }}</td>
                            <td>{{ $missing->department }}</td>
                            <td>{{ $missing->shift }}</td>
                            <td>{{ $missing->status }}</td>
                            <td>{{ $missing->attendance_date }}</td>
                    </tr>
        @endforeach
    @endif
    </tbody>
</table>