<table>
    <thead>
    <tr>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >S. No.</th>
      <th style="text-align: center; width: 25%;border: 1px solid black;" >Employee No.</th>
      <th style="text-align: center; width: 25%;border: 1px solid black;" >Employee Name</th>
      <th style="text-align: center; width: 25%;border: 1px solid black;" >Company</th>
      <th style="text-align: center; width: 25%;border: 1px solid black;" >Department</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Allocated EL/PL</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Allocated CL</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Allocated CO</th>

      <th style="text-align: center; width: 15%;border: 1px solid black;" >Leader EL/PL</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Leader CL</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Leader CO</th>

      <th style="text-align: center; width: 15%;border: 1px solid black;" >Differnece EL/PL </th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Differnece CL </th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Differnece CO </th>

      <th style="text-align: center; width: 15%;border: 1px solid black;" >Applied EL/PL</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Applied CL</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Applied CO</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Applied LWP</th>

      <th style="text-align: center; width: 15%;border: 1px solid black;" >Current EL/PL </th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Current CL </th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Current CO </th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Current LWP </th>

      <th style="text-align: center; width: 15%;border: 1px solid black;" >Application EL/PL</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Application CL</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Application CO</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Application LWP</th>

      <th style="text-align: center; width: 15%;border: 1px solid black;" >Autual Avail EL/PL </th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Autual Avail CL </th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Autual Avail CO </th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Autual Avail LWP </th>
    </tr>
    </thead>
    <tbody>
    @php $count = 1;  @endphp
    @if(!empty($emp_data))
        @foreach($emp_data as $data)
                    <tr>
                      <td style="text-align: center;border: 1px solid black;" >{{ $count++ }}</td>
                      <td style="border: 1px solid black;">{{ $data->employee}}</td>
                      <td style="border: 1px solid black;">{{ $data->employee_name}}</td>
                      <td style="text-align: center;border: 1px solid black;" >{{ $data->company}}</td>
                      <td style="text-align: center;border: 1px solid black;" >{{ $data->department}}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_leaves_allocated_el_pl'] }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_leaves_allocated_cl'] }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_leaves_allocated_co'] }}</td>

                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_allocated_el_pl_leader'] }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_allocated_cl_leader'] }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_allocated_co_leader'] }}</td>

                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_allocated_el_pl_leader'] - $data->leave_data['total_leaves_allocated_el_pl'] }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_allocated_cl_leader'] - $data->leave_data['total_leaves_allocated_cl'] }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_leaves_allocated_co'] - $data->leave_data['total_leaves_allocated_co'] }}</td>

                      <td style="text-align: center;border: 1px solid black;">{{ abs($data->leave_data['total_applied_el_pl_leader']) }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ abs($data->leave_data['total_applied_cl_leader']) }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ abs($data->leave_data['total_applied_co_leader']) }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ abs($data->leave_data['total_applied_lwp_leader']) }}</td>

                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_applied_el_pl_leader'] + $data->leave_data['total_leaves_allocated_el_pl'] }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_applied_cl_leader'] + $data->leave_data['total_leaves_allocated_cl'] }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_applied_co_leader'] + $data->leave_data['total_leaves_allocated_co'] }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_applied_lwp_leader'] }}</td>

                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_el_pl_application'] }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_cl_application'] }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_co_application'] }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_lwp_application'] }}</td>

                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_leaves_allocated_el_pl'] - $data->leave_data['total_el_pl_application']  }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_leaves_allocated_cl'] - $data->leave_data['total_cl_application'] }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_leaves_allocated_co'] - $data->leave_data['total_co_application'] }}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->leave_data['total_lwp_application'] }}</td>


                    </tr>
        @endforeach
    @endif
    </tbody>
</table>
