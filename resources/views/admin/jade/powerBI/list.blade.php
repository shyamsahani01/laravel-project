@extends('admin.layout.app')

@section('content')
<div class="main-panel">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary" style="background-color: white;">
                  <h4 class="card-title " style="font-size: 18px;font-weight: bold;color: black;text-shadow: 5px 5px 5px lightgrey, 3px 3px 5px lightgrey;">{{$title}}</h4>
                  <a href="{{url('/jadePowerBiReport/add')}}" class="btn btn-success btn-sm pull-right" style="margin-top: -31px; margin-right: -10px;"><i class="fa fa-plus"></i> Add</a>
                </div>

                <!-- <div class="card-body">
                  <div class="table-responsive"> -->

                    <div class="card-body" style="">
                        <div class="row">

                          @if(!empty($jade_report_data))
                              @foreach($jade_report_data as $key => $data)

                              <div class="col-md-2" style="background-color: #eee; border: 1px solid;">
                                  <h3 class="font-weight-bold" style="font-size: 10px;color: black;">{{$data->report_name}}</h3>
                                  <a href="{{$data->report_url}}" target="_blank" title="View" class="" >
                                    <!-- {{$data->report_name}} -->
                                    <button id="go-button" class="btn btn-primary fa fa-expand pull-right go-button-sale" style="margin-top: -30px;"></button>
                                  </a>
                                    <!-- <button id="go-button" class="btn btn-primary fa fa-expand pull-right go-button-sale" style="margin-top: -39px;"></button> -->
                                  <embed  type="text/html" class="element-sale" height="210" width="100%" src="{{$data->report_url}}" width="500" height="800">
                              </div>

                              <!-- <a href="{{$data->report_url}}" target="_blank" title="View" class="btn btn-info btn_space" >View</a>
                              <a href="{{url('/jadePowerBiReport/add?id='.$data->id)}}" title="Edit" class="btn btn-success btn_space" >Edit</a>
                              <a href="javascript:void(0)" onclick="showConfirmDialog('{{$data->id}}')" title="Delete" class="btn btn-danger btn_space" >Delete</a></td> -->


                              @endforeach
                          @endif



                        </div>
                      </div>



                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>




<!-- confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Report</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <h5 class="modal-title" >Are you sure ?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" id="deleteForm-button" onclick="deleteForm(0)" class="btn btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>



<script>
function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}


function showConfirmDialog(row_id) {
      $("#deleteForm-button").attr("onclick", "deleteForm("+row_id+")")
      $("#confirmModal").modal("show")
}


function deleteForm(id)
{
  $("#confirmModal").modal("hide")
  window.location.href = "{{url('/jadePowerBiReport/delete?id=')}}" + id;
}

</script>
@endsection
