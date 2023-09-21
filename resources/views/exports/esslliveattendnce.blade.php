<table>
    <thead>
    <tr>
        <th>S.NO</th>
        <th>Date</th>
        <th>Time</th>
        <th>Employee Name</th>
        <th>UserId</th>
    </tr>
    </thead>
    <tbody>
    @php $count = 1; @endphp    
    @if(!empty($response))
        @foreach(json_decode($response,true) as $data)
        @php 
         $timedate = substr($data['LogDate'], 0, strpos($data['LogDate'], '.'));
         $time = date('H:i:s', strtotime($timedate)); 
        @endphp
            <tr>
                <td>{{ $count++ }}</td>
                <td>{{ date('d-m-Y',strtotime($data['LogDate'])) }}</td>
                <td>{{ $time }}</td>
                <td>@if(!empty($data['EmployeeName'])) {{ $data['EmployeeName'] }} @endif</td>
                <td>@if(!empty($data['UserId'])) {{ $data['UserId'] }} @else N/A @endif</td>
               
            </tr>
        @endforeach
    @endif
    </tbody>
</table>