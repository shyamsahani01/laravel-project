
     <table id="datatable" class="table table-striped table-bordered" style="width:100%">
        <thead>
           <tr>
             <th style="text-align: center; width: 15%;border: 1px solid black; font-weight: bold;">Employee ID</th>
             <th style="text-align: center; width: 25%;border: 1px solid black; font-weight: bold;">Account</th>
             <th style="text-align: center; width: 10%;border: 1px solid black; font-weight: bold;">Credit</th>
             <th style="text-align: center; width: 15%;border: 1px solid black; font-weight: bold;">Amount</th>
             <th style="text-align: center; width: 25%;border: 1px solid black; font-weight: bold;">Narration</th>
             <th style="text-align: center; width: 50%;border: 1px solid black; font-weight: bold;">Account,Credit,Amount,Narration</th>
           </tr>
        </thead>
        <tbody>
      @if (count($bank_sheet_data) > 0)
         @php $count = 1; @endphp
          @foreach($bank_sheet_data as $key => $data)
              <tr>
                <td style="text-align: center;border: 1px solid black;">{{ $data->attendance_device_id }}</td>
                <td style="text-align: center;border: 1px solid black;">{{ "'" .$data->bank_ac_no }}</td>
                <td style="text-align: center;border: 1px solid black;">{{ 'C' }}</td>
                <td style="text-align: center;border: 1px solid black;">{{ round($data->net_pay) }}</td>
                <td style="text-align: center;border: 1px solid black;">{{ $data->employee_name }}</td>
                <td style="text-align: center;border: 1px solid black;">{{ $data->bank_ac_no . ",C," . round($data->net_pay) ."," . $data->employee_name }}</td>
              </tr>
          @endforeach
      @else
        <tr>
          <td colspan="7" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
         </tr>
      @endif
  </tbody>
</table>
