
     <table id="datatable" class="table table-striped table-bordered" style="width:100%">
        <thead>
           <tr>
             <th style="text-align: center; width: 10%;border: 1px solid black; font-weight: bold;">S.No.</th>
             <th style="text-align: center; width: 15%;border: 1px solid black; font-weight: bold;">Employee Code</th>
             <th style="text-align: center; width: 25%;border: 1px solid black; font-weight: bold;">Employee Name</th>
             <th style="text-align: center; width: 15%;border: 1px solid black; font-weight: bold;">Department</th>
             <th style="text-align: center; width: 15%;border: 1px solid black; font-weight: bold;">Designation</th>
             <th style="text-align: center; width: 15%;border: 1px solid black; font-weight: bold;">Company</th>
             <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">In Time</th>
             <th style="text-align: center; width: 20%;border: 1px solid black; font-weight: bold;">Out Time</th>
             <th style="text-align: center; width: 15%;border: 1px solid black; font-weight: bold;">Time Diff</th>
           </tr>
        </thead>
        <tbody>
      @if (count($check_in_data) > 0)
         @php $count_data = 1; @endphp
          @foreach($check_in_data as $key => $data)
              <tr>
                <td style="text-align: center;border: 1px solid black;">{{ $count_data++ }}</td>
                <td style="text-align: center;border: 1px solid black;">{{ $data->employee_id }}</td>
                <td style="text-align: center;border: 1px solid black;">{{ $data->emp_name }}</td>
                <td style="text-align: center;border: 1px solid black;">{{ $data->department }}</td>
                <td style="text-align: center;border: 1px solid black;">{{ $data->designation }}</td>
                <td style="text-align: center;border: 1px solid black;">{{ $data->company }}</td>
                <td style="text-align: center;border: 1px solid black;">{{ date("Y-m-d H:i:s", strtotime($data->in_time) ) }}</td>
                <td style="text-align: center;border: 1px solid black;">@if(isset($data->out_time)){{ date("Y-m-d H:i:s", strtotime($data->out_time) ) }}@endif</td>
                <td style="text-align: center;border: 1px solid black;">
                  @if(isset($data->out_time))
                    @php
                      $time_diff = "";
                      $date_diff = date_diff(date_create($data->out_time), date_create($data->in_time));
                      $time_diff = ( $date_diff->days * 60 * 60 * 24 ) + ($date_diff->h * 60 * 60 ) + ($date_diff->i * 60 ) + + ($date_diff->s);
                    @endphp
                    {{ $time_diff }}
                  @endif
                </td>
              </tr>
          @endforeach
      @else
        <tr>
          <td colspan="8" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
         </tr>
      @endif
  </tbody>
</table>
