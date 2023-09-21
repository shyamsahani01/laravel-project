<div class="container-fluid card">
  @if(request()->segment(1) == 'stockladger')
  <div class="x_title">
      <h2>{{ $title }}</h2>
      <div class="clearfix"></div>
   </div>
  <form method="GET" id="filter_form" action="{{ url('/stockladger') }}">
  <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}" >
  <div class="x_content">
     <div class="row">
        <div class="col-md-2 col-sm-12  form-group">
           <input type="text" placeholder="Search Item Code" name="ItemCode" class="form-control" value="{{ $data['ItemCode'] }}">
        </div>
        <div class="col-md-4 col-sm-12  form-group">
          <select class="form-control" name="companyName" id="companyName">
             <option value="">Select Company</option>
             <option value="Pinkcity Jewelhouse Private Ltd-Mahapura" @if ($data['companyName'] == 'Pinkcity Jewelhouse Private Ltd-Mahapura') selected @endif>Pinkcity Jewelhouse Private Ltd-Mahapura</option>
             <option value="Pinkcity Jewelhouse Private Limited- Unit 1" @if ($data['companyName'] == 'Pinkcity Jewelhouse Private Limited- Unit 1') selected @endif>Pinkcity Jewelhouse Private Limited- Unit 1</option>
             <option value="Pinkcity Jewelhouse Private Limited-Unit 2" @if ($data['companyName']== 'Pinkcity Jewelhouse Private Limited-Unit 2') selected @endif>Pinkcity Jewelhouse Private Limited-Unit 2</option>
          </select>
        </div>
        <div class="col-md-2 col-sm-12  form-group">
           <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
              <input placeholder="Select date" type="date" name="start_date"
                 value="{{ $data['start_date'] }}" class="form-control">
           </div>
        </div>
        <div class="col-md-2 col-sm-12  form-group">
           <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
              <input placeholder="Select date" name="end_date" type="date"
                 value="{{ $data['end_date'] }}" class="form-control">
           </div>
        </div>
        {{-- <div class="col-md-3">
               <?php
               //$listImages = [];
               ?>
               @foreach ($stockdatas as $key => $itemResult)
                   @php
                       array_push($listImages, $itemResult['item_group']);
                   @endphp
               @endforeach
               @php
                   $filteredLists = array_unique($listImages);
               @endphp
               <select class="form-control" name="itemGroup" id="itemGroup">
                   <option value="">Select All </option>
                   @if (!empty($filteredLists))
                       @foreach ($filteredLists as $key => $item)
                           <option name="{{ $item }}" @if ($data['itemGroup'] == $item) selected @endif>{{ $item }}
                           </option>
                       @endforeach
                   @endif
               </select>
           </div> --}}
           <div class="col-md-2 col-sm-6">
                 <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
                 <button type="button" class="btn btn-danger"><a href="{{ url('/stockladger') }}" style="color: white;"  ><i class="fa fa-refresh"></i></a></button>
                 <button  type="button" class="btn btn-info"><a href="{{ url('stocks-export') }}" style="color: white;" ><i class="fa fa-file-excel-o"></i></a></button>
           </div>
     </div>
  </div>
</form>
   @endif

    @if(request()->segment(1) == 'item-montering')
    <form method="GET" action="{{ url('/item-montering') }}">
        <div class="row">
            <div class="col-md-3">
                <select class="form-control" name="companyName" id="companyName">
                    <option value="">Select Company</option>
                    <option value="Pinkcity Jewelhouse Private Ltd-Mahapura" @if ($data['companyName'] == 'Pinkcity Jewelhouse Private Ltd-Mahapura') selected @endif>Pinkcity Jewelhouse Private Ltd-Mahapura</option>
                    <option value="Pinkcity Jewelhouse Private Limited- Unit 1" @if ($data['companyName'] == 'Pinkcity Jewelhouse Private Limited- Unit 1') selected @endif>Pinkcity Jewelhouse Private Limited- Unit 1</option>
                    <option value="Pinkcity Jewelhouse Private Limited-Unit 2" @if ($data['companyName']== 'Pinkcity Jewelhouse Private Limited-Unit 2') selected @endif>Pinkcity Jewelhouse Private Limited-Unit 2</option>
                    {{-- <option value="Pinkcity Jewelhouse Private Limited-Testing Purpose" @if($data['companyName'] == 'Pinkcity Jewelhouse Private Limited-Testing Purpose') selected @endif>Pinkcity Jewelhouse Private Limited-Testing Purpose</option>
                    <option value="Pinkcity Jewelhouse Private Limited" @if ($data['companyName'] == 'Pinkcity Jewelhouse Private Limited') selected @endif>Pinkcity Jewelhouse Private Limited</option> --}}

                </select>
            </div>
            <div class="col-md-3">
                <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                    <input placeholder="Select date" type="date" name="start_date"
                        value="{{ $data['start_date'] }}" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                    <input placeholder="Select date" name="end_date" type="date"
                        value="{{ $data['end_date'] }}" class="form-control">
                </div>
            </div>
            <?php

            ?>
            <div class="col-md-3">
                <?php
                $listImages = [];
                ?>
                @foreach ($stockdatas as $key => $itemResult)
                    @php
                        array_push($listImages, $itemResult['item_group']);
                    @endphp
                @endforeach
                @php
                    $filteredLists = array_unique($listImages);
                @endphp
                <select class="form-control" name="itemGroup" id="itemGroup">
                    <option value="">Select All </option>
                    @if (!empty($filteredLists))
                        @foreach ($filteredLists as $key => $item)
                            <option name="{{ $item }}" @if ($data['itemGroup'] == $item) selected @endif>{{ $item }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="footer-button">
            <button type="submit" class="btn btn-primary">Apply</button>
            <a href="{{ url('/item-montering') }}" class="btn btn-danger" style="color: white;">Reset</a>
            </div>
        </div>
    </form>
    @endif


    @if(request()->segment(1) == 'purchaseorder')
       <div class="x_title">
          <h2>{{ $title }}</h2>
          <div class="clearfix"></div>
       </div>
        <form method="GET" action="{{ url('/item-montering') }}">
      <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}" >
          <div class="x_content">
             <div class="row">
               <div class="col-md-2 col-sm-12  form-group">
                   <select class="form-control" name="companyName" id="companyName">
                      <option value="">Select Company</option>
                      <option value="Pinkcity Jewelhouse Private Ltd-Mahapura" @if ($data['companyName'] == 'Pinkcity Jewelhouse Private Ltd-Mahapura') selected @endif>Pinkcity Jewelhouse Private Ltd-Mahapura</option>
                      <option value="Pinkcity Jewelhouse Private Limited- Unit 1" @if ($data['companyName'] == 'Pinkcity Jewelhouse Private Limited- Unit 1') selected @endif>Pinkcity Jewelhouse Private Limited- Unit 1</option>
                      <option value="Pinkcity Jewelhouse Private Limited-Unit 2" @if ($data['companyName']== 'Pinkcity Jewelhouse Private Limited-Unit 2') selected @endif>Pinkcity Jewelhouse Private Limited-Unit 2</option>
                  </select>
                </div>
                <div class="col-md-2 col-sm-12  form-group">
                  <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                     <input placeholder="Select date" type="date" name="start_date"
                        value="{{ $data['start_date'] }}" class="form-control">
                  </div>
               </div>
               <div class="col-md-2 col-sm-12  form-group">
                  <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                    <input placeholder="Select date" name="end_date" type="date"
                        value="{{ $data['end_date'] }}" class="form-control">
                  </div>
               </div>
               <div class="col-md-2 col-sm-12  form-group">
                <select class="form-control" name="suppliername" id="suppliername">
                   <option value="">Select Suppliers</option>
                   @if (!empty($suppliers))
                   @foreach ($suppliers as $key => $supplier)
                   <option name="{{ $supplier }}" @if ($data['suppliername'] == $supplier) selected @endif>{{ $supplier }}
                   </option>
                   @endforeach
                   @endif
                </select>
             </div>
             <div class="col-md-2 col-sm-12  form-group">
               <select class="form-control" name="status" id="status">
                   <option value="">Select Status</option>
                   @if (!empty($status))
                   @foreach ($status as $key => $statu)
                   <option name="{{ $statu }}" @if ($data['status'] == $statu) selected @endif>{{ $statu }}
                   </option>
                   @endforeach
                   @endif
                </select>
             </div>
             <div class="col-md-2 col-sm-6">
                <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
                <button class="btn btn-danger" type="button"><a href="{{ url('/purchaseorder') }}" style="color: white;" ><i class="fa fa-refresh"></i></a></a></button>
             </div>
             </div>
           </div>
    </form>
   @endif


    @if(request()->segment(1) == 'salesorder')
    <form method="GET" action="{{ url('/salesorder') }}">
        <div class="row">
            <div class="col-md-3">
                <select class="form-control" name="companyName" id="companyName">
                    <option value="">Select Company</option>
                    <option value="Pinkcity Jewelhouse Private Ltd-Mahapura" @if ($data['companyName'] == 'Pinkcity Jewelhouse Private Ltd-Mahapura') selected @endif>Pinkcity Jewelhouse Private Ltd-Mahapura</option>
                    <option value="Pinkcity Jewelhouse Private Limited- Unit 1" @if ($data['companyName'] == 'Pinkcity Jewelhouse Private Limited- Unit 1') selected @endif>Pinkcity Jewelhouse Private Limited- Unit 1</option>
                    <option value="Pinkcity Jewelhouse Private Limited-Unit 2" @if ($data['companyName']== 'Pinkcity Jewelhouse Private Limited-Unit 2') selected @endif>Pinkcity Jewelhouse Private Limited-Unit 2</option>
                    <option value="Pinkcity Jewelhouse Private Limited-Testing Purpose" @if($data['companyName'] == 'Pinkcity Jewelhouse Private Limited-Testing Purpose') selected @endif>Pinkcity Jewelhouse Private Limited-Testing Purpose</option>
                    <option value="Pinkcity Jewelhouse Private Limited" @if ($data['companyName'] == 'Pinkcity Jewelhouse Private Limited') selected @endif>Pinkcity Jewelhouse Private Limited</option>
                </select>
            </div>
            <div class="col-md-3">
                <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                    <input placeholder="Select date" type="date" name="start_date"
                        value="{{ $data['start_date'] }}" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                    <input placeholder="Select date" name="end_date" type="date"
                        value="{{ $data['end_date'] }}" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="footer-button">
                <button type="submit" class="btn btn-primary">Apply</button>
                <a href="{{ url('/salesorder') }}" class="btn btn-danger">Reset</a>
                </div>
            </div>
        </div>
    </form>
    @endif

    @if(request()->segment(1) == 'attendance-checkin-checkout')
    <form method="GET" action="{{ url('/attendance-checkin-checkout') }}">
        <div class="row">
            <div class="col-md-3">
                <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                    <input placeholder="Employee Code" type="text" name="employee_code" value="{{ request()->employee_code }}" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                    <input placeholder="Employee Name" type="text" name="employee_name" value="{{ request()->employee_name }}" class="form-control">
                </div>
            </div>

            <div class="col-md-3">
                <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                    <input placeholder="Select date" type="date" name="start_date"
                        value="{{ request()->start_date }}" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                    <input placeholder="Select date" name="end_date" type="date"
                        value="{{ request()->end_date }}" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="footer-button">
                <button type="submit" class="btn btn-primary">Apply</button>
                <a href="{{ url('/attendance-checkin-checkout') }}" class="btn btn-danger">Reset</a>
                </div>
            </div>
        </div>
    </form>
    @endif


    @if(request()->segment(1) == 'attendance' && request()->segment(2) != 'essl')
    <?php
    $export_data = request()->export_data;
    if(request()->export_data == 'all' || empty(request()->export_data) ) {
      $export_data = "all";
    } ?>
    @php
    $url = url('attendnce-export?employee_code='.request()->employee_code.'&employee_name='.request()->employee_name.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&status='.request()->status.'&shift='.request()->shift.'&company='.request()->company.'&export_data='.$export_data);
    @endphp
    <div  class="x_title">
                                        <h4 style="color: black;font-size: 18px;font-weight: bold;margin-top: 10px;text-shadow: 5px 5px 5px lightgrey, 3px 3px 5px lightgrey;">{{ $title }}</h4>
                                        <div class="clearfix"></div>
                                    </div>
                                    <form method="GET" id="filter_form" action="{{ url('/attendance') }}">
        <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}" >
        <div class="x_content">
      <div class="row">
          <div class="col-md-2 col-sm-12  form-group">
               <input placeholder="Employee Code" type="text" name="employee_code" value="{{ request()->employee_code }}" class="form-control">
           </div>
           <div class="col-md-2 col-sm-12  form-group">
              <input placeholder="Employee Name" type="text" name="employee_name" value="{{ request()->employee_name }}" class="form-control">
           </div>
           <div class="col-md-2 col-sm-12  form-group">
           <input placeholder="Start date" type="text" name="start_date"
                    value="{{ request()->start_date }}" class="form-control" onfocus="(this.type='date')">
           </div>
           <div class="col-md-2 col-sm-12  form-group">
           <input placeholder="End date" name="end_date" type="text"
                     value="{{ request()->end_date }}" class="form-control" onfocus="(this.type='date')">
           </div>

           <div class="col-md-2 col-sm-12  form-group">
           <select name="status" autocomplete="off" class="form-control" maxlength="140" placeholder="Status">
                       <option value="">Select Status</option>
                       <option value="Present" @if(request()->status == 'Present') Selected @endif>Present</option>
                       <option value="Absent" @if(request()->status == 'Absent') Selected @endif>Absent</option>
                       <option value="On Leave" @if(request()->status == 'On Leave') Selected @endif>On Leave</option>
                       <option value="Half Day" @if(request()->status == 'Half Day') Selected @endif>Half Day</option>
                       <option value="Work From Home" @if(request()->status == 'Work From Home') Selected @endif>Work From Home</option>
                   </select>
           </div>
           <div class="col-md-2 col-sm-12  form-group">
           <select name="shift" autocomplete="off" class="form-control" maxlength="140" placeholder="Status">
                     <option value="">Select Shift</option>
                     <option value="Unit 1 Shift Sitapura" @if(request()->shift == 'Unit 1 Shift Sitapura') selected @endif>Unit 1 Shift Sitapura</option>
                     <option value="Unit 2 Shift Sitapura" @if(request()->shift == 'Unit 2 Shift Sitapura') selected @endif>Unit 2 Shift Sitapura</option>
                      <option value="Mahapura Unit Shift" @if(request()->shift == 'Mahapura Unit Shift') selected @endif>Mahapura Unit Shift</option>
                 </select>
           </div>
           <div class="col-md-2 col-sm-12  form-group">
           <select name="company" autocomplete="off" class="form-control" maxlength="140" placeholder="Company">
                     <option value="">Select Company</option>
                     <option value="Pinkcity Jewelhouse Private Ltd-Mahapura" @if(request()->company == 'Pinkcity Jewelhouse Private Ltd-Mahapura') Selected @endif>Mahapura</option>
                     <option value="Pinkcity Jewelhouse Private Limited- Unit 1" @if(request()->company == 'Pinkcity Jewelhouse Private Limited- Unit 1') Selected @endif>Unit 1</option>
                     <option value="Pinkcity Jewelhouse Private Limited-Unit 2" @if(request()->company == 'Pinkcity Jewelhouse Private Limited-Unit 2') Selected @endif>Unit 2</option>
                 </select>
           </div>

           <div class="form-group" style="margin-top: 9px;margin-right: 25px;margin-left: 34px;">
              <input class="form-check-input" type="radio" name="export_data" value="all" id="export_data" @if(request()->export_data == 'all' || empty(request()->export_data) ) checked @endif> All Export
           </div>
           <div class="form-group" style="margin-top: 8px;">
              <input class="form-check-input" type="radio" name="export_data" value="out" id="export_data" @if(request()->export_data == 'out') checked @endif> Export Out Missing Data
           </div>
           <div class="form-group" style="margin-top: 8px;margin-right: 10px;margin-left: 28px;">
              <input class="form-check-input" type="radio" name="export_data" value="in" id="export_data" @if(request()->export_data == 'in') checked @endif> Export In Missing Data
           </div>
           <div class="form-group" style="margin-top: 8px;margin-right: 10px;margin-left: 15px;">
              <input class="form-check-input" type="radio" name="export_data" value="overtime" id="export_data" @if(request()->export_data == 'overtime') checked @endif> Export Overtime Data
           </div>
          <div class="col-md-2 col-sm-6">
            <button type="submit" title="Submit" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
            <a href="{{ url('/attendance') }}" style="color: white;"><button type="button" title="Refresh" class="btn btn-danger"><i class="fa fa-refresh"></i></button></a>
            <a href="{{ $url }}" style="color: white;" ><button type="button" title="Excel" class="btn btn-info"><i class="fa fa-file-excel-o"></i></button> </a>
          </div>
      </div>
   </div>
</form>
    @endif

    @if(request()->segment(2) == 'essl')
    <div  class="x_title">
      <h4 style="color: black;font-size: 18px;font-weight: bold;margin-top: 10px;text-shadow: 5px 5px 5px lightgrey, 3px 3px 5px lightgrey;">{{ $title }}</h4>
      <div class="clearfix"></div>
  </div>
<form method="GET" id="filter_form" action="{{ url('/attendance/essl') }}">
   <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}" >
   <div class="x_content">
      <div class="row">
        <div class="col-md-2 col-sm-12  form-group">
           <input placeholder="Employee Name" type="text" id="employee_name" name="employee_name" value="{{ request()->employee_name }}" class="form-control">
        </div>
        <div class="col-md-2 col-sm-12  form-group">
        <input placeholder="Start date" type="text" name="start_date"
                     value="{{ request()->start_date }}" class="form-control" onfocus="(this.type='date')">
        </div>
        <div class="col-md-2 col-sm-12  form-group">
        <input placeholder="End date" name="end_date" type="text"
                    value="{{ request()->end_date }}" class="form-control" onfocus="(this.type='date')">
        </div>
        <div class="col-md-3 col-sm-12  form-group">
        <select name="company" autocomplete="off" class="form-control" maxlength="140" placeholder="Company">
                        <option value="">Select Company</option>
                        <option value="Pinkcity Jewelhouse Private Ltd-Mahapura" @if(request()->company == 'Pinkcity Jewelhouse Private Ltd-Mahapura') Selected @endif>Mahapura</option>
                        <option value="Pinkcity Jewelhouse Private Limited- Unit 1" @if(request()->company == 'Pinkcity Jewelhouse Private Limited- Unit 1') Selected @endif>Unit 1</option>
                        <option value="Pinkcity Jewelhouse Private Limited-Unit 2" @if(request()->company == 'Pinkcity Jewelhouse Private Limited-Unit 2') Selected @endif>Unit 2</option>
                    </select>
        </div>
        @php
          $yesterday_date = \Carbon\Carbon::yesterday()->todatestring();
          $today_date = \Carbon\Carbon::now()->todatestring();

          @endphp
          <div class="col-md-3 col-sm-2">
                  <button type="submit" title="Submit" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
                  <a href="{{ url('/attendance/essl?start_date='.$yesterday_date.'&end_date='.$today_date) }}" style="color: white;"><button type="button" title="Refresh" class="btn btn-danger"><i class="fa fa-refresh"></i></button></a>
                  <a href="{{ url('/essl-export?company='.request()->company.'&employee_name='.request()->employee_name.'&start_date='.request()->start_date.'&end_date='.request()->end_date . '&show='.request()->show) }}"  style="color: white;"><button type="button" title="Excel" class="btn btn-info"><i class="fa fa-file-excel-o"></i></button></a>
            </div>
      </div>
   </div>
</form>
    @endif

    @if(request()->segment(1) == 'attendnce-record-api')
    <form method="GET" action="{{ url('/attendnce-record-api') }}">
        <div class="row">
            <div class="col-md-3">
                <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                    <input placeholder="Employee Code" type="text" name="employee_code" value="{{ request()->employee_code }}" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                    <input placeholder="Employee Name" type="text" name="employee_name" value="{{ request()->employee_name }}" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                    <input placeholder="Select date" type="date" name="start_date"
                        value="{{ request()->start_date }}" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                    <input placeholder="Select date" name="end_date" type="date"
                        value="{{ request()->end_date }}" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="footer-button">
                <button type="submit" class="btn btn-primary">Apply</button>
                <a href="{{ url('/attendnce-record-api') }}" class="btn btn-danger">Reset</a>

                </div>
            </div>
        </div>
    </form>
    @endif




</div>
