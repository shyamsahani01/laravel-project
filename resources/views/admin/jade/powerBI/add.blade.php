@extends('admin.layout.app')

@section('content')

<!-- Begin Body -->
<div class="main-panel">
   <div class="content">
    <div class="container-fluid">
      <div class="row">
                <div class="col-md-12 card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title">{{$title}}</h4>
                  </div>
                  <div class="card-body">
                    <form id="add-form" method="POST" onsubmit="event.preventDefault(); add_jade_reprot();">
                      <input type="hidden" name="id" id="quotation-form-id" value="@if(isset($report_data->id)){{ $report_data->id }}@else{{0}}@endif">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="bmd-label-floating">Report Name</label>
                            <input type="text" name="report_name" class="form-control" required value="@if(isset($report_data->report_name)){{ $report_data->report_name }}@endif">
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="bmd-label-floating">Report URL</label>
                            <input type="text" name="report_url" class="form-control" required value="@if(isset($report_data->report_url)){{ $report_data->report_url }}@endif">
                          </div>
                        </div>
                      </div>

                      </div>
                        <div class="col-md-2">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                      <div class="clearfix"></div>
                    </form>
                  </div>
                </div>
              </div>
      </div>
    </div>
  </div>
</div>
<script>
function add_jade_reprot() {
         $.ajax({
               url: '{{  url("/jadePowerBiReport/add_data") }}',
               cache: false,
               headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
               type: "post",
               data: $('#add-form').serialize(),
               dataType: "json",
               beforeSend: function (obj) {
                 $('#loader').removeClass('hidden')
               },
               success: function(obj){
                 $('#loader').addClass('hidden')
                  if(obj.status) {

                     window.location.href = "{{url('/jadePowerBiReport/list')}}" ;

                  }else {
                     alert(obj.msg)
                  }


               },
               error: function(obj){
                 $('#loader').addClass('hidden')
                  var error_msg = ""
                  $.each(obj.responseJSON.errors, function (key, val) {
                      error_msg +=  val[0] + "\n";
                  });
                  alert(error_msg)

               },
           });
}

</script>
@endsection
