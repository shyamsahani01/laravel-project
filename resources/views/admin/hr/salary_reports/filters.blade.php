<div class="container-fluid card">

   @if(request()->segment(2) == 'salary_register')
   <div class="x_title">
      <h2>{{ $title }}</h2>
      <div class="clearfix"></div>
   </div>
   <form method="GET" id="filter_form" action="{{ url('/hr/salary_register') }}">
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
                   <option value="{{ $key }}" @if(request()->month == $key) Selected @endif>{{ $value }}</option>
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
            <div class="col-md-4 col-sm-12  form-group">
               <select   name="company"  class="form-control">
                  <option value="" >Select Company</option>
                  <option value="Pinkcity Jewelhouse Private Ltd-Mahapura" @if(request()->company == 'Pinkcity Jewelhouse Private Ltd-Mahapura' ) Selected @endif>Pinkcity Jewelhouse Private Ltd-Mahapura</option>
                  <option value="Pinkcity Jewelhouse Private Limited- Unit 1" @if(request()->company == 'Pinkcity Jewelhouse Private Limited- Unit 1') Selected @endif>Pinkcity Jewelhouse Private Limited- Unit 1</option>
                  <option value="Pinkcity Jewelhouse Private Limited-Unit 2" @if(request()->company == 'Pinkcity Jewelhouse Private Limited-Unit 2') Selected @endif>Pinkcity Jewelhouse Private Limited-Unit 2</option>
               </select>
            </div>
            <div class="col-md-2 col-sm-12  form-group">
               <input name="employee_name" type="text" autocomplete="off" placeholder="Search Employee" class="form-control" value="{{ request()->employee_name }}">
            </div>
            <div class="col-md-2 col-sm-6">
               <button type="submit" title="Submit" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
               <a href="{{ url('/hr/salary_register') }}" style="color: white;" ><button type="button" title="Refresh" class="btn btn-danger"><i class="fa fa-refresh"></i></button></a>
               <a href="{{ url('/hr/salary_register/export?company='.request()->company.'&employee_name='.request()->employee_name.'&month='.request()->month.'&year='.request()->year . '&show='.request()->show) }}"  style="color: white;"><button type="button" title="Excel" class="btn btn-info"><i class="fa fa-file-excel-o"></i></button></a>
            </div>
         </div>
      </div>
   </form>
   @endif
</div>
