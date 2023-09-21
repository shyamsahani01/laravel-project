<table id="new-datatable" class="table-responsive table-bordered table"  style="width:100%">
  <thead>
    <tr style="text-align: center;color: black;">
      <th>S.No.</th>
      <th>Employee Code</th>
      <th>Employee Name</th>
      <th>ESSL Code</th>
      <th>Date</th>
      <th>In Time</th>
      <th>Out Time</th>
      <th>Actual Total Working Hrs</th>
      <th>Actual OT Hrs</th>
      <th>Actual Less Hrs</th>
      <th>Actual Access Hrs</th>
      <th>Total Working Hrs</th>
      <th>OT Include</th>
      <th>OT Hrs</th>
      <th>Less Hrs</th>
      <th>Access Hrs</th>
      <th>Monthly Salary</th>
      <th>Per Day Salary</th>
      <th>Per Hour Salary</th>
      <th>Modified OT Hours</th>
      <th>Final OT Amount</th>
     </tr>
  </thead>
  <tbody>
    @if (count($ot_lesshours_data) > 0)
      @php $count = 1 @endphp
      @foreach($ot_lesshours_data as $key => $data)
      <tr  style="text-align: center;color: black;">
        <td>{{ $count++  }}</td>
        <td>{{ $data->employee  }}</td>
        <td>{{ $data->employee_name  }}</td>
        <td>{{ $data->attendance_device_id  }}</td>
        <td>{{ date("Y-m-d, D", strtotime($data->date) ) }}</td>
        <td>{{ date("H:i:s", strtotime($data->in_time) ) }}</td>
        <td>{{ date("H:i:s", strtotime($data->out_time) )  }}</td>
        <td>{{ $data->total_hours }}</td>
        <td>{{ $data->ot_hours }}</td>
        <td>{{ $data->less_hours }}</td>
        <td>{{ $data->access_hours }}</td>
        <td>{{ $data->total_hours_round }}</td>
        <td>{{ ($data->ot_includes == 1 ) ? "Yes" : "No" }}</td>
        <td>{{ $data->ot_hours_round }}</td>
        <td>{{ $data->less_hours_round }}</td>
        <td>{{ $data->access_hours_round }}</td>
        <td>{{ $data->gross_monthly_salary }}</td>
        <td >{{ round($data->per_day_salary) }}</td>
        <td class="per_hour_salary">{{ round($data->per_hour_salary) }}</td>
        <td class="user_modified_hour">
          {{ $data->final_ot_hour }}
        </td>
        <td class="final_amount">{{ round($data->final_ot_hour_salary) }}</td>
      </tr>
 @endforeach
  @else
    <tr>
      <td colspan="18" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
     </tr>
  @endif
  </tbody>
</table>
