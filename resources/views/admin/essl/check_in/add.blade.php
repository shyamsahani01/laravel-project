@extends('admin.layout.app')

@section('content')

<!-- Begin Body -->
<div class="main-panel">
   <div class="content">
    <div class="container-fluid">
      <div class="row">
              <div class="col-md-12">
                @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                @endif
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ $title }}</h4>
                    <!-- <p class="card-category">Create New User</p> -->
                  </div>
                  <div class="card-body">
                    <form method="POST" action="" id="saveForm">
                      @csrf
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <!-- <label class="bmd-label-floating">Employee ID</label> -->
                            <input type="text" name="week_name" class="form-control" value="{{ date('l') }}" id="week_name" readonly style="text-align: center;">
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <!-- <label class="bmd-label-floating">Check In Type</label> -->
                            <input type="text" name="current_date" class="form-control" value="{{ date('d-m-Y') }}" id="current_date" readonly style="text-align: center;">
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <!-- <label class="bmd-label-floating">Check In Type</label> -->
                            <input type="text" name="current_time" class="form-control" value="{{ date('H:i:s') }}" id="current_time" readonly style="text-align: center;">
                          </div>
                        </div>

                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Employee ID</label>
                            <input type="text" name="employee_id" oninput="this.value = this.value.toUpperCase()" class="form-control" onkeyup="get_emp_details()" id="employee_id" required>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Check In Type</label>
                            <select class="form-control" name="type" id="type" required>
                              <option value="">Please Select</option>
                              <option value="1">In</option>
                              <option value="0">Out</option>
                            </select>
                          </div>
                        </div>

                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Department</label>
                            <input type="text" readonly name="department"  id="department" class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Name</label>
                            <input type="text" readonly name="emp_name" id="emp_name" class="form-control" >
                          </div>
                        </div>

                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <div class="clearfix"></div>
                    </form>

                    <h5 style="text-align: center; color: black"> Regualar Shift time from 9:30AM to 6:00PM</h5>
                  </div>
                </div>
              </div>
      </div>
    </div>
  </div>
</div>

<script>

$("#saveForm").on("submit", function (e) {
  e.preventDefault();
  var employee_id =  $('#employee_id').val();

  if(employee_id) {
    $.ajax({
          url: '{{  url("/essl/check_in_local/add") }}',
          cache: false,
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
          type: "post",
          data: {"employee_id" : $('#employee_id').val(), "type": $('#type').val() },
          dataType: "json",
          async: "true",
          beforeSend: function (obj) {
            $('#loader').removeClass('hidden')
          },
          success: function(obj){
            $('#loader').addClass('hidden')
             if(obj.status) {
                alert(obj.msg)

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
  else {
    alert("Please enter Employee ID.")
  }
})




function get_emp_details(this_instance) {
  $.ajax({
        url: '{{  url("/essl/check_in_local/get_emp_details") }}',
        cache: false,
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
        type: "post",
        data: {"employee_id" : $('#employee_id').val(), "type": $('#type').val() },
        dataType: "json",
        beforeSend: function (obj) {
          // $('#loader').removeClass('hidden')
        },
        success: function(obj){
          // $('#loader').addClass('hidden')
           if(obj.status) {
             $("#department").val(obj.data.DepartmentFName)
             $("#emp_name").val(obj.data.EmployeeName)
              // alert(obj.msg)

           }else {
              // alert(obj.msg)
           }


        },
        error: function(obj){
          $('#loader').addClass('hidden')
           var error_msg = ""
           $.each(obj.responseJSON.errors, function (key, val) {
               error_msg +=  val[0] + "\n";
           });
           // alert(error_msg)

        },
    });

}

function updateTime() {
  current_time = new Date();
  $("#current_time").val(current_time.getHours() + ":" + current_time.getMinutes() + ":" + current_time.getSeconds())
}


setInterval(function () {
  updateTime()
}, 1000)

</script>
@endsection
