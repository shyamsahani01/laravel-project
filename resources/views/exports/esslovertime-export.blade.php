<table>
    <thead>
    <tr>
        <th>S.NO</th>
        <th>Date</th>
        <th>Employee Name</th>
        <th>Company</th>
        <th>Department</th>
        <th>InTime</th>
        <th>Out Time</th>
        <th>OverTime</th>
    </tr>
    </thead>
    <tbody>
    @php $count = 1; @endphp
    @if(!empty($response))
        @foreach(json_decode($response,true) as $data)
            @if($data['Overtime'] > 0)
            @php
              $employee = Helper::Emplopyeedata($data['EMPLOYEECODE']);
              $overtime = $data['Overtime'] /60;
            @endphp
            <tr>
                <td>{{ $count++ }}</td>
                <td>{{ date('d-m-Y',strtotime($data['ATTENDANCEDATE'])) }}</td>
                <td>@if(!empty($employee)) {{ $employee->employee_name }} @endif</td>
                <td>@if(!empty($employee)) {{ $employee->company }} @endif</td>
                <td>@if(!empty($employee)) {{ $employee->department }} @endif</td>
                <td>@if(!empty($data['InTime'])) {{ $data['InTime'] }} @endif</td>
                <td>@if(!empty($data['OutTime'])) {{ $data['OutTime'] }} @endif </td>
                <td>{{ round($overtime,2) }} </td>
            </tr>
            @endif
        @endforeach
    @endif
    </tbody>
</table>










