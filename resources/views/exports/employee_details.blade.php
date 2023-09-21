<div>
    <div class=row>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div>
                <ul style="list-style: none;font-size: 14px;color: black;margin-top: 20px;">
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Employee </th>
                        <td style="min-width: 20px;display: inline-block;">:</td>
                        <td>@if(isset($emp_details_data->employee)){{ $emp_details_data->employee }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Employee Name </th>
                        <td style="min-width: 20px;display: inline-block;">:</td>
                        <td>@if(isset($emp_details_data->employee_name)){{ $emp_details_data->employee_name }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Date Of Birth </th>
                        <td style="min-width: 20px;display: inline-block;">:</td>
                        <td>@if(isset($emp_details_data->date_of_birth)){{ $emp_details_data->date_of_birth }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Date Of Joining </th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->date_of_joining)){{ $emp_details_data->date_of_joining }}@endif</td>
                    </li>

                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Phone Number </th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->cell_number)){{ $emp_details_data->cell_number }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Marital Status </th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->marital_status)){{ $emp_details_data->marital_status }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Aadhar Card Number </th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->aadhar_card_no)){{ $emp_details_data->aadhar_card_no }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">PAN Number </th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->pan_number)){{ $emp_details_data->pan_number }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Permanent Address </th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->permanent_address)){{ $emp_details_data->permanent_address }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Father Name </th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->father_name)){{ $emp_details_data->father_name }}@endif</td>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div style="border-left: 1px solid black;">
                <ul style="list-style: none;font-size: 14px;color: black;margin-top: 20px;">
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Attendance Device ID </th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->attendance_device_id)){{ $emp_details_data->attendance_device_id }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Designation </th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->designation)){{ $emp_details_data->designation }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Occupation</th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->occupation)){{ $emp_details_data->occupation }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Department</th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->department)){{ $emp_details_data->department }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Grade </th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->grade)){{ $emp_details_data->grade }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Branch</th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->branch)){{ $emp_details_data->branch }}@endif</td>
                    </li>
                    <!-- <li style="margin-bottom: 4px;">
        <th style="min-width: 150px;display: inline-block;">Salary Structure ID</th>
        <th style="min-width: 20px;display: inline-block;">:</th>
        <td>@if(isset($emp_details_data->salary_structure_id)){{ $emp_details_data->salary_structure_id }}@endif</td>
      </li> -->
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Bank Name</th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->bank_name_new)){{ $emp_details_data->bank_name_new }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">Bank Account Number</th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->bank_ac_no)){{ $emp_details_data->bank_ac_no }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">IFSC Code</th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->ifsc_code)){{ $emp_details_data->ifsc_code }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">UAN Number</th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->provident_fund_account)){{ $emp_details_data->provident_fund_account }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">ESIC Number</th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->esic_no)){{ $emp_details_data->esic_no }}@endif</td>
                    </li>
                    <li style="margin-bottom: 4px;">
                        <th style="min-width: 150px;display: inline-block;">ESIC Exit Date</th>
                        <th style="min-width: 20px;display: inline-block;">:</th>
                        <td>@if(isset($emp_details_data->esic_exit_date)){{ $emp_details_data->esic_exit_date }}@endif</td>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
