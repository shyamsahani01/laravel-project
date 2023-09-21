<table>
    <thead>
    <tr>
        <th style="text-align: center;  width: 15%; border: 1px solid black;" >IP Number <p style="color:red"> (10 Digits)</p></th>
        <th style="text-align: center;  width: 25%; border: 1px solid black;" >IP Name <p style="color: red;"> (Only alphabets and space)</p></th>
        <th style="text-align: center;  width: 15%; border: 1px solid black;"><p>No of Days for which wages paid/payable during the month</p></th>
        <th style="text-align: center;  width: 10%; border: 1px solid black;"><p>Total Monthly Wages</p></th>
        <th style="text-align: center;  width: 25%; border: 1px solid black;"><p>Reason Code for Zero workings days(numeric only;provide 0 for all other reasons- Click on the link for referencel)</p></th>
        <th style="text-align: center;  width: 15%; border: 1px solid black;">Last Working Day <p style="color:red">(Format DD/MM/YYYY or DD-MM-YYYY)</p></th>
    </tr>
    </thead>
    <tbody>
    @php $count = 1; $last_working_day = ""; @endphp
    @if(!empty($esi_challan_data))
        @foreach($esi_challan_data as $data)
        @php $last_working_day = "";  @endphp
        @if ( strlen($data->last_working_day) >= 6)
        @php $last_working_day = date('d-m-Y', strtotime($data->last_working_day));  @endphp
        @endif
                    <tr>
                        <td style="text-align: center; border: 1px solid black;">{{ $data->esic_no}}</td>
                        <td style=" border: 1px solid black;">{{ $data->employee_name}}</td>
                        <td style="text-align: center; border: 1px solid black;">{{ $data->payment_days}}</td>
                        <td style="text-align: center; border: 1px solid black;">{{ $data->esi_earnings}}</td>
                        <td style="text-align: center; border: 1px solid black;">{{ $data->workings_day1}}</td>
                        <td style="text-align: center; border: 1px solid black;" > {{ $last_working_day }} </td>
                    </tr>
        @endforeach
    @endif
    </tbody>
</table>
