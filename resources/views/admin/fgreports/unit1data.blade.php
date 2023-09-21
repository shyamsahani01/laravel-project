@extends('admin.layout.app') 
@section('content') 
@php 
// $url = url('attendnce-export?employee_code='.request()->employee_code.'&employee_name='.request()->employee_name.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&status='.request()->status.'&shift='.request()->shift.'&company='.request()->company.'&export_data='.request()->export_data); 
// $showurl = url('attendance?show='.request()->show.'&employee_code='.request()->employee_code.'&employee_name='.request()->employee_name.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&status='.request()->status.'&shift='.request()->shift.'&company='.request()->company.'&export_data='.request()->export_data); 
$showurl = url('fg/unit1data?show='.request()->show.'&start_date='.request()->start_date.'&end_date='.request()->end_date); 
@endphp 
<div class="main-panel">
   @includeif('admin.layout.navbar') 
   <div class="content">
      @includeif('admin.fgreports.filters') 
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header card-header-primary">
                  <h4 class="card-title ">{{ $title }}</h4>
                  <p class="card-category"> All Data Listing</p>
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table id="" class="table ">
                        <thead class=" text-primary">
                           <tr>
                              <th style="text-align: center;">S.NO.</th>
                              <th style="text-align: center; min-width: 100px;">FgTc</th>
                              <th style="text-align: center; min-width: 150px;">FgYy</th>
                              <th style="text-align: center; min-width: 150px;">FgChr</th>
                              <th style="text-align: center; min-width: 100px;">FgNo</th>
                              <th style="text-align: center; min-width: 150px;">FgDt</th>
                              <th style="text-align: center; min-width: 80px;">FgFrRmLoc</th>
                              <th style="text-align: center; min-width: 80px;">FgToRmLoc</th>
                              <th style="text-align: center; min-width: 80px;">FgFrBLoc</th>
                              <th style="text-align: center; min-width: 80px;">FgToBLoc</th>
                              <th style="text-align: center; min-width: 80px;">ModUsr</th>
                              <th style="text-align: center; min-width: 150px;">ModDt</th>
                              <th style="text-align: center; min-width: 80px;">ModTime</th>
                              <th style="text-align: center; min-width: 150px;">FgCoCd</th>
                              <th style="text-align: center; min-width: 150px;">FgSubLoc</th>
                              <th style="text-align: center; min-width: 100px;">FgSeoPwd </th>
                              <th style="text-align: center; min-width: 150px;">FgIdNo</th>
                              <th style="text-align: center; min-width: 180px;">FgPrtKey</th>
                           </tr>
                        </thead>
                        <tbody>
                           @if (count($fgData) > 0) @php $count = 1 @endphp @foreach($fgData as $key => $data) 
                           <tr>
                              <td style="text-align: center;">{{ $fgData->firstItem() +  $key }}</td>
                              <td style="text-align: center;">{{ $data->FgTc }}</td>
                              <td style="text-align: center;">{{ $data->FgYy }}</td>
                              <td style="text-align: center;">{{ $data->FgChr }}</td>
                              <td style="text-align: center;">{{ $data->FgNo }}</td>
                              <td style="text-align: center;">{{ $data->FgDt }}</td>
                              <td style="text-align: center;">{{ $data->FgFrRmLoc }}</td>
                              <td style="text-align: center;">{{ $data->FgToRmLoc }}</td>
                              <td style="text-align: center;">{{ $data->FgFrBLoc }}</td>
                              <td style="text-align: center;">{{ $data->FgToBLoc }}</td>
                              <td style="text-align: center;">{{ $data->ModUsr }}</td>
                              <td style="text-align: center;">{{ $data->ModDt }}</td>
                              <td style="text-align: center;">{{ $data->ModTime }}</td>
                              <td style="text-align: center;">{{ $data->FgCoCd }}</td>
                              <td style="text-align: center;">{{ $data->FgSubLoc }}</td>
                              <td style="text-align: center;">{{ $data->FgSeoPwd }}</td>
                              <td style="text-align: center;">{{ $data->FgIdNo }}</td>
                              <td style="text-align: center;">{{ $data->FgPrtKey }}</td>
                           </tr>
                           @endforeach @else 
                           <tr>
                              <td colspan="17" class="text-center text-danger">
                                 <h3>
                                    <b>No Record Found</b>
                                 </h3>
                              </td>
                           </tr>
                           @endif 
                        </tbody>
                     </table>
                     <div class="btn-group">
                        <button type="button" onclick="changenumber(10)" class="btn btn-default btn-sm btn-paging @if(request()->show == 10 || empty(request()->show )) btn-info @endif " data-value="10">10</button>
                        <button type="button" onclick="changenumber(100)" class="btn btn-default btn-sm btn-paging @if(request()->show == 100) btn-info @endif " data-value="100">100</button>
                        <button type="button" onclick="changenumber(500)" class="btn btn-default btn-sm btn-paging @if(request()->show == 500) btn-info @endif " data-value="500">500</button>
                     </div>
                     <div class="pagination pull-right">
                        {{ $fgData->links('vendor.pagination.bootstrap-4') }}
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div> 
@endsection 
@section('footer-scripts') 
<script>
   function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
   }
</script> 
@endsection
                                