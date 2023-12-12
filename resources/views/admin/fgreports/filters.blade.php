<div class="container-fluid card">
   @if(request()->segment(1) == 'fg' && request()->segment(2) == 'unit1')
   <div class="x_title">
      <h2>{{ $title }}</h2>
      <div class="clearfix"></div>
   </div>
   <form method="GET" id="filter_form" action="{{ url('/fg/unit1/list') }}">
      <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}" >
      <div class="x_content">
         <div class="row">


           <div class="col-md-2 col-sm-12  form-group">
              <input type="text" name="start_date"  autocomplete="off" onfocus="(this.type='date')" placeholder="Start date" class="form-control" value="{{ request()->start_date }}">
           </div>

           <div class="col-md-2 col-sm-12  form-group">
              <input type="text" name="end_date"  autocomplete="off" onfocus="(this.type='date')" placeholder="End date" class="form-control" value="{{ request()->end_date }}">
           </div>

            <!-- <div class="col-md-4 col-sm-12  form-group">
               <select name="company" class="form-control">
                  <option value="">Select Company</option>
                  <option value="Pinkcity Jewelhouse Private Ltd-Mahapura" @if(request()->company == 'Pinkcity Jewelhouse Private Ltd-Mahapura') Selected @endif>Pinkcity Jewelhouse Private Ltd-Mahapura</option>
                  <option value="Pinkcity Jewelhouse Private Limited- Unit 1" @if(request()->company == 'Pinkcity Jewelhouse Private Limited- Unit 1') Selected @endif>Pinkcity Jewelhouse Private Limited- Unit 1</option>
                  <option value="Pinkcity Jewelhouse Private Limited-Unit 2" @if(request()->company == 'Pinkcity Jewelhouse Private Limited-Unit 2') Selected @endif>Pinkcity Jewelhouse Private Limited-Unit 2</option>
               </select>
            </div> -->

            <div class="col-md-4 col-sm-6">
               <button type="submit" title="Submit" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
               <a href="{{ url('/fg/unit1/list') }}" style="color: white;" ><button type="button" title="Refresh" class="btn btn-danger"><i class="fa fa-refresh"></i></button></a>
               <!-- <a href="{{ url('/fg/unit1/export?start_date='.request()->start_date.'&end_date='.request()->end_date . '&show='.request()->show) }}"  style="color: white;"><button type="button" title="Excel" class="btn btn-info"><i class="fa fa-file-excel-o"></i></button></a> -->
               <!-- <button type="button" class="btn btn-info"><a href="{{ url('/fg/unit1fgReport/export?company='.request()->company.'&employee_name='.request()->employee_name.'&month='.request()->month.'&year='.request()->year . '&show='.request()->show) }}"  style="color: white;" ><i class="fa fa-file-excel-o"></i></a></button> -->
            </div>
         </div>
      </div>
   </form>
   @endif

   @if(request()->segment(1) == 'fg' && request()->segment(2) == 'unit2')
   <div class="x_title">
      <h2>{{ $title }}</h2>
      <div class="clearfix"></div>
   </div>
   <form method="GET" id="filter_form" action="{{ url('/fg/unit2/list') }}">
      <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}" >
      <div class="x_content">
         <div class="row">


           <div class="col-md-2 col-sm-12  form-group">
              <input type="text" name="start_date"  autocomplete="off" onfocus="(this.type='date')" placeholder="Start date" class="form-control" value="{{ request()->start_date }}">
           </div>

           <div class="col-md-2 col-sm-12  form-group">
              <input type="text" name="end_date"  autocomplete="off" onfocus="(this.type='date')" placeholder="End date" class="form-control" value="{{ request()->end_date }}">
           </div>

            <!-- <div class="col-md-4 col-sm-12  form-group">
               <select name="company" class="form-control">
                  <option value="">Select Company</option>
                  <option value="Pinkcity Jewelhouse Private Ltd-Mahapura" @if(request()->company == 'Pinkcity Jewelhouse Private Ltd-Mahapura') Selected @endif>Pinkcity Jewelhouse Private Ltd-Mahapura</option>
                  <option value="Pinkcity Jewelhouse Private Limited- Unit 1" @if(request()->company == 'Pinkcity Jewelhouse Private Limited- Unit 1') Selected @endif>Pinkcity Jewelhouse Private Limited- Unit 1</option>
                  <option value="Pinkcity Jewelhouse Private Limited-Unit 2" @if(request()->company == 'Pinkcity Jewelhouse Private Limited-Unit 2') Selected @endif>Pinkcity Jewelhouse Private Limited-Unit 2</option>
               </select>
            </div> -->

            <div class="col-md-4 col-sm-6">
               <button type="submit" title="Submit" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
               <a href="{{ url('/fg/unit2/list') }}" style="color: white;" ><button type="button" title="Refresh" class="btn btn-danger"><i class="fa fa-refresh"></i></button></a>
               <!-- <a href="{{ url('/fg/unit2/export?start_date='.request()->start_date.'&end_date='.request()->end_date . '&show='.request()->show) }}"  style="color: white;"><button type="button" title="Excel" class="btn btn-info"><i class="fa fa-file-excel-o"></i></button></a> -->
               <!-- <button type="button" class="btn btn-info"><a href="{{ url('/fg/unit1fgReport/export?company='.request()->company.'&employee_name='.request()->employee_name.'&month='.request()->month.'&year='.request()->year . '&show='.request()->show) }}"  style="color: white;" ><i class="fa fa-file-excel-o"></i></a></button> -->
            </div>
         </div>
      </div>
   </form>
   @endif


   @if(request()->segment(1) == 'fg' && request()->segment(2) == 'mahapura')
   <div class="x_title">
      <h2>{{ $title }}</h2>
      <div class="clearfix"></div>
   </div>
   <form method="GET" id="filter_form" action="{{ url('/fg/mahapura/list') }}">
      <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}" >
      <div class="x_content">
         <div class="row">


           <div class="col-md-2 col-sm-12  form-group">
              <input type="text" name="start_date"  autocomplete="off" onfocus="(this.type='date')" placeholder="Start date" class="form-control" value="{{ request()->start_date }}">
           </div>

           <div class="col-md-2 col-sm-12  form-group">
              <input type="text" name="end_date"  autocomplete="off" onfocus="(this.type='date')" placeholder="End date" class="form-control" value="{{ request()->end_date }}">
           </div>

            <!-- <div class="col-md-4 col-sm-12  form-group">
               <select name="company" class="form-control">
                  <option value="">Select Company</option>
                  <option value="Pinkcity Jewelhouse Private Ltd-Mahapura" @if(request()->company == 'Pinkcity Jewelhouse Private Ltd-Mahapura') Selected @endif>Pinkcity Jewelhouse Private Ltd-Mahapura</option>
                  <option value="Pinkcity Jewelhouse Private Limited- Unit 1" @if(request()->company == 'Pinkcity Jewelhouse Private Limited- Unit 1') Selected @endif>Pinkcity Jewelhouse Private Limited- Unit 1</option>
                  <option value="Pinkcity Jewelhouse Private Limited-Unit 2" @if(request()->company == 'Pinkcity Jewelhouse Private Limited-Unit 2') Selected @endif>Pinkcity Jewelhouse Private Limited-Unit 2</option>
               </select>
            </div> -->

            <div class="col-md-4 col-sm-6">
               <button type="submit" title="Submit" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
               <a href="{{ url('/fg/mahapura/list') }}" style="color: white;" ><button type="button" title="Refresh" class="btn btn-danger"><i class="fa fa-refresh"></i></button></a>
               <a href="{{ url('/fg/mahapura/export?start_date='.request()->start_date.'&end_date='.request()->end_date . '&show='.request()->show) }}"  style="color: white;"><button type="button" title="Excel" class="btn btn-info"><i class="fa fa-file-excel-o"></i></button></a>
               <!-- <button type="button" class="btn btn-info"><a href="{{ url('/fg/unit1fgReport/export?company='.request()->company.'&employee_name='.request()->employee_name.'&month='.request()->month.'&year='.request()->year . '&show='.request()->show) }}"  style="color: white;" ><i class="fa fa-file-excel-o"></i></a></button> -->
            </div>
         </div>
      </div>
   </form>
   @endif

</div>
