<div class="container-fluid card">
   @if(request()->segment(2) == 'leave_details')
   <div class="x_title">
      <h2>{{ $title }}</h2>
      <div class="clearfix"></div>
   </div>
   <form method="GET" id="filter_form" action="{{ url('/hr/leave_details') }}">
      <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}" >
      <div class="x_content">
         <div class="row">
           <div class="col-md-2 col-sm-12  form-group">
              <select name="month" class="form-control">
                 <option value="">Select Month</option>
                 @php $months = ["01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April",
                 "05"=>"May", "06"=>"June", "07"=>"July", "08"=>"August",
                 "09"=>"September", "10"=>"Octomber", "11"=>"November", "12"=>"December"]; @endphp
                 @if(!empty($months))
                 @foreach($months as $key => $value)
                 <option value="{{ $key }}" @if(request()->month == $key || $month == $key) Selected @endif>{{ $value }}</option>
                 @endforeach
                 @endif
              </select>
           </div>
            <div class="col-md-2 col-sm-12  form-group">
               <select  name="year" class="form-control">
                  <option value="">Select Year</option>
                  @for($i=2021; $i<=date("Y", time()); $i++)
                  <option value="{{ $i }}" @if(request()->year == $i) Selected @endif>{{ $i }}</option>
                  @endfor
               </select>
            </div>
            <div class="col-md-2 col-sm-12  form-group">
               <select name="company" class="form-control">
                  <option value="">Select Company</option>
                  <option value="PINKCITY COLORSTONES PVT. LTD." @if(request()->company == 'PINKCITY COLORSTONES PVT. LTD.') Selected @endif>PINKCITY COLORSTONES PVT. LTD.</option>
                  <option value="Pinkcity Jewelhouse Private Ltd-Mahapura" @if(request()->company == 'Pinkcity Jewelhouse Private Ltd-Mahapura') Selected @endif>Pinkcity Jewelhouse Private Ltd-Mahapura</option>
                  <option value="Pinkcity Jewelhouse Private Limited- Unit 1" @if(request()->company == 'Pinkcity Jewelhouse Private Limited- Unit 1') Selected @endif>Pinkcity Jewelhouse Private Limited- Unit 1</option>
                  <option value="Pinkcity Jewelhouse Private Limited-Unit 2" @if(request()->company == 'Pinkcity Jewelhouse Private Limited-Unit 2') Selected @endif>Pinkcity Jewelhouse Private Limited-Unit 2</option>
               </select>
            </div>
            <div class="col-md-2 col-sm-12  form-group">
               <input type="text" name="employee_name"  autocomplete="off" placeholder="Search Employee" class="form-control" value="{{ request()->employee_name }}">
            </div>
            <div class="col-md-2 col-sm-12  form-group">
               <select name="status" class="form-control">
                 <option value="">Select Status</option>
                 <option value="Active" @if(request()->status == 'Active' ) Selected @endif>Active</option>
                 <option value="Left" @if(request()->status == 'Left') Selected @endif>Left</option>
               </select>
            </div>
            <div class="col-md-2 col-sm-6">
               <button type="submit" title="Submit" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
               <a href="{{ url('/hr/leave_details') }}" style="color: white;" ><button type="button" title="Refresh" class="btn btn-danger"><i class="fa fa-refresh"></i></button></a>
               <!-- <button class="btn btn-info dropdown-toggle" title="Excel" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fa fa-file-excel-o"></i>
               </button> -->

               <!-- <a href="{{ url('/hr/leave_details/export?company='.request()->company.'&employee_name='.request()->employee_name.'&status='.request()->status.'&year='.request()->year . '&show='.request()->show) }}"  style="color: white;"><button type="button" title="Excel" class="btn btn-info"><i class="fa fa-file-excel-o"></i></button></a> -->

               <!-- <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item"  href="{{ url('/pf/pf_challan/export?start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name.'&month='.request()->month.'&year='.request()->year. '&show='.request()->show) }}">Excel</a>
                  <a class="dropdown-item" href="{{ url('/pf/pf_challan/export_text?start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name.'&month='.request()->month.'&year='.request()->year. '&show='.request()->show) }}">Text</a>
               </div> -->
            </div>
         </div>
      </div>
   </form>
   @endif

</div>
