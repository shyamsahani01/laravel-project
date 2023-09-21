@php
        $all_employees = 0;
        $excluded_employees = $employees1->employees1;
        $all_gross_pay = 0;
        $all_employees =  $all_employees + $excluded_employees;
@endphp
@if(!empty($gross_pay))
        @foreach($gross_pay as $data)
                @php
                    $all_gross_pay = $all_gross_pay + $data->gross_pay;
                @endphp
        @endforeach
    @endif
<table>
    <thead>
        <tr>
            <th style="text-align: center;width: 15%;height: 30%; border: 1px solid black;" >S No. <br>(1)</th>
            <th style="text-align: center;width: 15%; border: 1px solid black;" >UAN <br>(2)</th>
            <th style="text-align: center;width: 25%; border: 1px solid black;" >Name of Member <br>(3)</th>
            <th style="text-align: center;width: 15%; border: 1px solid black;" >Employee PF Earnings <br>(4)</th>
            <th style="text-align: center;width: 15%; border: 1px solid black;" >Contribution EPF <br>(5)</th>
            <th style="text-align: center;width: 15%; border: 1px solid black;" >Employer EPF Difference <br>(6)</th>
            <th style="text-align: center;width: 15%; border: 1px solid black;" >Contribution Pension 8.33% <br>(7)</th>
        </tr>
    </thead>
    <tbody>
    @php
        $count = 1;
        $total_amount = 0; $total_pf = 0; $total_eps = 0; $total_epsepf = 0;
        $pfepsepf = 0;
        $amountcalculate = 0;
        $allamount = 0;
        $total_eps_scheme_not_applicable = 0;
        $total_for_pension_wages = 0;
        $edli_wages = 0;
    @endphp
    @if(!empty($pf_statement_data))
        @foreach($pf_statement_data as $data)
                      @php $total_amount = $total_amount + $data->amount;
                           $total_pf = $total_pf + $data->pf;
                           $total_eps =  $total_eps + $data->eps;
                           $total_epsepf = $total_epsepf + $data->epsepf;
                           $all_employees++;
                           @endphp
                @if($data->eps_scheme_not_applicable == 1)
                    @php
                        $total_eps_scheme_not_applicable = $total_eps_scheme_not_applicable + $data->amount;
                    @endphp
                @endif
                    <tr>
                            <td  style="text-align: center; border: 1px solid black;">{{ $count++ }}</td>

                            <td  style="text-align: center; border: 1px solid black;" >{{ "'".$data->uan_number}}</td>

                            <td style=" border: 1px solid black;" >{{ $data->employee_name}}</td>
                            <td style="text-align: center; border: 1px solid black;">{{ $data->amount}}</td>
                            <td style="text-align: center; border: 1px solid black;">{{ $data->pf}}</td>
                            <td style="text-align: center; border: 1px solid black;" >{{ $data->epsepf}}</td>
                            <td style="text-align: center; border: 1px solid black;">{{ $data->eps}}</td>
                    </tr>
        @endforeach
    @endif
    round(sum(pf+epsepf+eps+((amount*0.50000)/100)+((amount*0.50000)/100))) grandtotal
    @php
        $pfepsepf = $total_pf + $total_eps;
        $amountcalculate = round( $total_amount * 0.5000/100 );
        $allamount = $total_pf + $total_eps + $total_epsepf + ( $amountcalculate ) + ( $amountcalculate  );
        $total_for_pension_wages = $total_amount - $total_eps_scheme_not_applicable;
    @endphp
                    <tr>
                            <td  colspan="3" style="text-align: right;  border: 1px solid black;" >Total</td>
                            <td  style="text-align: center;  border: 1px solid black;">{{ $total_amount }}</td>
                            <td  style="text-align: center;  border: 1px solid black;">{{ $total_pf }}</td>
                            <td  style="text-align: center;  border: 1px solid black;">{{ $total_epsepf }}</td>
                            <td style="text-align: center;  border: 1px solid black;" >{{ $total_eps }}</td>
                    </tr>
                    <tr align= center>
                        <th colspan="3" style="text-align: right;  border: 1px solid black;">Account No:01</th>
                            <td colspan="2" style="text-align: left;font-weight: bold;  border: 1px solid black;">(Column Nos.5+6)</td>
                            <td style="font-weight: bold; text-align: center;  border: 1px solid black;">= </td>
                            <td style="text-align: center;  border: 1px solid black; " ><b>{{ $pfepsepf }}</b></td>';
                    </tr>
                    <tr align= center>
                        <th colspan="3" style="text-align: right;  border: 1px solid black;">Account No:02</th>
                        <td colspan="2" style="text-align: left;font-weight: bold;  border: 1px solid black;">(0.50000% of Column Nos.4)</td>
                        <td style="font-weight: bold; text-align: center;  border: 1px solid black;">=</td>
                        <td  style="text-align: center;  border: 1px solid black;"  ><b>{{ $amountcalculate }}</b></td>
                    </tr>
                    <tr align= center>
                        <th colspan="3" style="text-align: right;  border: 1px solid black;">Account No:10</th>
                        <td colspan="2" style="text-align: left;font-weight: bold;  border: 1px solid black;">(Column Nos.7)</td>
                        <td style="font-weight: bold; text-align: center;  border: 1px solid black;">=</td>
                        <td style="text-align: center;  border: 1px solid black;" ><b>{{ $total_epsepf }}</b></td>
                    </tr>
                    <tr align= center>
                        <th style="text-align: left;  border: 1px solid black;">EDLI Wages :</th>
                        <td  style="text-align: center;  border: 1px solid black;" ><b>{{ $total_amount }}</b></td>
                        <th style="text-align: right;  border: 1px solid black;">Account No:21</th>
                        <td colspan="2" style="text-align: left;font-weight: bold;  border: 1px solid black;">EDLI Wages * 0.50000%</td>
                        <td style="font-weight: bold; text-align: center;  border: 1px solid black;">=</td>
                        <td  style="text-align: center;  border: 1px solid black;" ><b>{{ $amountcalculate }}</b></td>
                    </tr>
                    <tr align= center>
                        <th style="text-align: left;  border: 1px solid black;">Pension Wages :</th>
                        <td  style="text-align: center;  border: 1px solid black;"  ><b>{{ $total_for_pension_wages }}</b></td>
                        <th style="text-align: right;  border: 1px solid black;">Account No:22</th>
                        <td colspan="2" style="text-align: left;font-weight: bold;  border: 1px solid black;">EDLI Wages * 0.00000%</td>
                        <td style="font-weight: bold; text-align: center;  border: 1px solid black;">=</td>
                        <td style="font-weight: bold; text-align: center;  border: 1px solid black;"></td>
                    </tr>
                    <tr align= center>
                        <th colspan="3" style="text-align: right;  border: 1px solid black;">Total</th>
                        <td colspan="3" style="border: 1px solid black;" ></td>
                        <td  style="text-align: center;  border: 1px solid black;" ><b> {{ $allamount }} </b></td>
                    </tr>
                    <tr align= center>
                        <th colspan="3" style="text-align: left;  border: 1px solid black;">Total No. of Employees in the Month :</th>
                        <td style="text-align: center;  border: 1px solid black;" ><b>{{ $all_employees }}</b></td>
                    </tr>
                    <tr align= center>
                        <th colspan="3" style="text-align: left;  border: 1px solid black;">No. of Excluded Employee :</th>
                        <td style="text-align: center;  border: 1px solid black;" ><b>{{ $excluded_employees }}</b></td>
                    </tr>
                    <tr align= center>
                        <th colspan="3" style="text-align: left;  border: 1px solid black;">Gross Wages of Excluded Employee :</th>
                        <td style="text-align: center;  border: 1px solid black;" ><b>{{ $all_gross_pay }}</b></td>
                    </tr>
    </tbody>
</table>
