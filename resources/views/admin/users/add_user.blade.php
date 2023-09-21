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
                    <h4 class="card-title">Add User</h4>
                    <p class="card-category">Create New User</p>
                  </div>
                  <div class="card-body">
                    <form method="POST" action="{{route('user.store')}}">
                      @csrf
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Name</label>
                            <input type="text" name="name" class="form-control" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Email</label>
                            <input type="email" name="email" class="form-control" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control" maxlength="12" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Password</label>
                            <input type="password" name="password" class="form-control" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">User Role</label>
                            <select class="form-control" name="role" required>
                              <option value="">Please Select</option>
                              <option value="user">User</option>
                              <option value="admin">Admin</option>
                              <option value="reports">Reports</option>
                              <option value="attendance">Attendance</option>
                              <option value="buying">Buying</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6" style="margin-left: 20px">
                            <input type="checkbox" class="form-check-input" name="status" value="1" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Active</label>

                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
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
$("#checkAll").click(function () {
    $(".check").prop('checked', $(this).prop('checked'));
});
</script>
@endsection
