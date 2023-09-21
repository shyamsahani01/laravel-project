@extends('admin.layout.app')

@section('content')
@php 
 // $url = url('attendnce-export?employee_code='.request()->employee_code.'&employee_name='.request()->employee_name.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&status='.request()->status.'&shift='.request()->shift.'&company='.request()->company.'&export_data='.request()->export_data);
 // $showurl = url('attendance?show='.request()->show.'&employee_code='.request()->employee_code.'&employee_name='.request()->employee_name.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&status='.request()->status.'&shift='.request()->shift.'&company='.request()->company.'&export_data='.request()->export_data);
$showurl = url('fg/unit2data?show='.request()->show.'&start_date='.request()->start_date.'&end_date='.request()->end_date);

@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                                
                               <table id="" class="table " >
                                    <thead class=" text-primary">
                                        <tr>
                                            <th style="text-align: center;"  >S.NO.</th>
                                            <th style="text-align: center; min-width: 100px;">FdTc</th>
                                            <th style="text-align: center; min-width: 150px;" >FdYy</th>
                                            <th style="text-align: center; min-width: 150px;" >FdChr</th>
                                            <th style="text-align: center; min-width: 100px;" >FdNo</th>
                                            <th style="text-align: center; min-width: 150px;" >FdSr</th>
                                            <th style="text-align: center; min-width: 80px;" >FdBYy</th>
                                            <th style="text-align: center; min-width: 80px;" >FdBChr</th>
                                            <th style="text-align: center; min-width: 80px;" >FdBNo</th>
                                            <th style="text-align: center; min-width: 80px;" >FdDmCd</th>
                                            <th style="text-align: center; min-width: 80px;" >FdQty</th>
                                            <th style="text-align: center; min-width: 150px;" >FdGrWt</th>

                                            <th style="text-align: center; min-width: 80px;" >FdPrdOdTc</th>
                                            <th style="text-align: center; min-width: 150px;" >FdPrdOdYy</th>
                                            <th style="text-align: center; min-width: 150px;" >FdPrdOdChr</th>
                                            <th style="text-align: center; min-width: 100px;" >FdPrdOdNo </th>
                                            <th style="text-align: center; min-width: 150px;" >FdPrdOdSr</th>
                                            <th style="text-align: center; min-width: 80px;" >FdPrdCmCd</th>
                                            
                                            <th style="text-align: center; min-width: 80px;" >FdExpCmCd</th>
                                            <th style="text-align: center; min-width: 80px;" >FdExpOdTc</th>
                                            <th style="text-align: center; min-width: 80px;" >FdExpOdYy</th>
                                            <th style="text-align: center; min-width: 80px;" >FdExpOdChr</th>
                                            <th style="text-align: center; min-width: 80px;" >FdExpOdNo</th>
                                            <th style="text-align: center; min-width: 80px;" >FdExpOdSr</th>

                                            <th style="text-align: center; min-width: 80px;" >FdPlYy</th>
                                            <th style="text-align: center; min-width: 80px;" >FdPlChr</th>
                                            <th style="text-align: center; min-width: 80px;" >FdPlNo</th>
                                            <th style="text-align: center; min-width: 80px;" >FdInTc</th>
                                            <th style="text-align: center; min-width: 80px;" >FdInYy</th>
                                            <th style="text-align: center; min-width: 80px;" >FdInChr</th>
                                            <th style="text-align: center; min-width: 80px;" >FdInNo</th>
                                            <th style="text-align: center; min-width: 80px;" >FdInExpNo</th>
                                            <th style="text-align: center; min-width: 80px;" >FdDespQty</th>

                                            <th style="text-align: center; min-width: 80px;" >ModUsr</th>
                                            <th style="text-align: center; min-width: 180px;" >ModDt</th>

                                            <th style="text-align: center; min-width: 80px;" >ModTime</th>
                                            <th style="text-align: center; min-width: 80px;" >FdBm</th>
                                            <th style="text-align: center; min-width: 80px;" >FdKey</th>
                                            <th style="text-align: center; min-width: 80px;" >FdRefYy</th>
                                            <th style="text-align: center; min-width: 80px;" >FdRefKey</th>
                                            <th style="text-align: center; min-width: 80px;" >FdBYyKey</th>
                                            <th style="text-align: center; min-width: 80px;" >FdCoCd</th>
                                            <th style="text-align: center; min-width: 80px;" >FdDesc</th>
                                            <th style="text-align: center; min-width: 80px;" >FdSubLoc</th>
                                            <th style="text-align: center; min-width: 80px;" >FdCTBDespQty</th>
                                            <th style="text-align: center; min-width: 180px;" >FdDt</th>
                                            <th style="text-align: center; min-width: 80px;" >FdIdNo</th>
                                            <th style="text-align: center; min-width: 80px;" >FdFgIdNo</th>
                                            <th style="text-align: center; min-width: 80px;" >FdDmIdNo</th>
                                            <th style="text-align: center; min-width: 80px;" >FdBIdNo</th>
                                            <th style="text-align: center; min-width: 80px;" >FdPrtKey</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($fgData) > 0)
                                           @php $count = 1 @endphp
                                            @foreach($fgData as $key => $data)
                                                <tr>
                                                    <td style="text-align: center;" >{{ $fgData->firstItem() +  $key }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdTc }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdYy }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdChr }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdNo }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdSr }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdBYy }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdBChr }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdBNo }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdDmCd }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdQty }}</td>

                                                    <td style="text-align: center;" >{{ $data->FdGrWt }}</td>

                                                    <td style="text-align: center;" >{{ $data->FdPrdOdTc }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdPrdOdYy }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdPrdOdChr }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdPrdOdNo }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdPrdOdSr }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdPrdCmCd }}</td>
                                                    
                                                    <td style="text-align: center;" >{{ $data->FdExpCmCd }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdExpOdTc }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdExpOdYy }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdExpOdChr }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdExpOdNo }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdExpOdSr }}</td>

                                                    <td style="text-align: center;" >{{ $data->FdPlYy }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdPlChr }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdPlNo }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdInTc }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdInYy }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdInChr }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdInNo }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdInExpNo }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdDespQty }}</td>
                                                    <td style="text-align: center;" >{{ $data->ModUsr }}</td>
                                                    <td style="text-align: center;" >{{ $data->ModDt }}</td>
                                                    <td style="text-align: center;" >{{ $data->ModTime }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdBm }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdKey }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdRefYy }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdRefKey }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdBYyKey }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdCoCd }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdDesc }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdSubLoc }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdCTBDespQty }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdDt }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdIdNo }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdFgIdNo }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdDmIdNo }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdBIdNo }}</td>
                                                    <td style="text-align: center;" >{{ $data->FdPrtKey }}</td>


                                                    
                                                </tr>

                                            @endforeach
                                        @else
                                          <tr>
                                            <td colspan="17" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
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
<script src="https://rawgit.com/select2/select2/master/dist/js/select2.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha512-lzilC+JFd6YV8+vQRNRtU7DOqv5Sa9Ek53lXt/k91HZTJpytHS1L6l1mMKR9K6VVoDt4LiEXaa6XBrYk1YhGTQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script>
 function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}

$('#example').select2({
    placeholder: 'Select a month'
});


</script>
@endsection
