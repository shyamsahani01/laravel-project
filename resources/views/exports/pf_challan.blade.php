<table>
    <thead>
    <tr>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >UAN</th>
      <th style="text-align: center; width: 25%;border: 1px solid black;" >Member Name</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Gross Wages</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >EPF Wages</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >EPS Wages</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >EDLI Wages</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >EPF <br>Contribution remitted</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >EPS <br>Contribution remitted</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >EPF and EPS <br> Diff Remitted</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >NCP Days</th>
      <th style="text-align: center; width: 15%;border: 1px solid black;" >Refund of <br> Advances </th>
    </tr>
    </thead>
    <tbody>
    @php $count = 1;  @endphp
    @if(!empty($pf_challan_data))
        @foreach($pf_challan_data as $data)
                    <tr>
                      <td style="text-align: center;border: 1px solid black;" >{{ "'".$data->uan_number}}</td>
                      <td style="border: 1px solid black;">{{ $data->employee_name}}</td>
                      <td style="text-align: center;border: 1px solid black;" >{{ $data->gross_pay}}</td>
                      <td style="text-align: center;border: 1px solid black;" >{{ $data->amount1}}</td>
                      <td style="text-align: center;border: 1px solid black;">{{ $data->amount2 }}</td>
                      <td style="text-align: center;border: 1px solid black;" >{{ $data->amount3}}</td>
                      <td style="text-align: center;border: 1px solid black;" >{{ $data->pf}}</td>
                      <td style="text-align: center;border: 1px solid black;" >{{ $data->eps}}</td>
                      <td style="text-align: center;border: 1px solid black;" >{{ $data->epsepf}}</td>
                      <td style="text-align: center;border: 1px solid black;" >{{ $data->leave_without_pay}}</td>
                      <td style="text-align: center;border: 1px solid black;" >{{ 0 }}</td>
                    </tr>
        @endforeach
    @endif
    </tbody>
</table>
