<table>
    <thead>
    <tr>
        <th style="text-align: center; width: 5%; height: 15%; border: 1px solid black;" >S No.</th>
        <th style="text-align: center; width: 15%; border: 1px solid black;">ESI NO.</th>
        <th style="text-align: center; width: 25%; border: 1px solid black;">Name of Member</th>
        <th style="text-align: center; width: 13%; border: 1px solid black;">Days Worked</th>
        <th style="text-align: center; width: 13%; border: 1px solid black;">ESI Earnings</th>
        <th style="text-align: center; width: 20%; border: 1px solid black;" >ESI Contribution</th>
    </tr>
    </thead>
    <tbody>
    @php 
        $count = 1; 
        $total_esi_earnings = 0; 
        $total_esi_contribution = 0; 
        $employer_contribution = 0; 
        $total = 0;
    @endphp    

    @if(!empty($esi_statement_data))
        @foreach($esi_statement_data as $data)
                        @php $total_esi_earnings = $total_esi_earnings + $data->esi_earnings; 
                           $total_esi_contribution = $total_esi_contribution + $data->esi_contribution; 
                        @endphp
                    <tr>
                        <td style="text-align: center;border: 1px solid black;">{{ $count++ }}</td>
                        <td style="text-align: center;border: 1px solid black;">{{ $data->esic_no}}</td>
                        <td style="border: 1px solid black;">{{ $data->employee_name}}</td>
                        <td style="text-align: center;border: 1px solid black;">{{ $data->payment_days}}</td>
                        <td style="text-align: center;border: 1px solid black;">{{ $data->esi_earnings}}</td>
                        <td style="text-align: center;border: 1px solid black;" >{{ $data->esi_contribution}}</td>
                    </tr>
        @endforeach
    @endif

    @php 
        $employer_contribution = round ( ( $total_esi_earnings * 3.25 )/ 100 ); 
        $total = $total_esi_contribution + $employer_contribution;
    @endphp  

                    <tr align= center>
				      <th colspan="3" style="text-align: right;border: 1px solid black;">Total</th>
					  <td style="text-align: center;border: 1px solid black;"></td>
					  <td style="text-align: center;border: 1px solid black;"><b>{{ $total_esi_earnings }}</b></td>
					  <td style="text-align: center;border: 1px solid black;"><b>{{ $total_esi_contribution }}</b></td>
				    </tr>

                    
                    <tr align= center>
				      <td  colspan="3" style="text-align: center;border: 1px solid black;">Employee Contribution</td>
					  <td style="text-align: center;border: 1px solid black;"><b>{{ $total_esi_contribution }}</b></td>
				    </tr>
                    <tr align= center>
				      <td  colspan="3" style="text-align: center;border: 1px solid black;">Employer Contribution</td>
					  <td style="text-align: center;border: 1px solid black;"><b>{{ $employer_contribution }}</b></td>
				    </tr>
                    <tr align= center>
				      <td  colspan="3" style="text-align: center;border: 1px solid black;">Total</td>
					  <td style="text-align: center;border: 1px solid black;"><b>{{ $total }} </b></td>
				    </tr>
    </tbody>
    
</table>