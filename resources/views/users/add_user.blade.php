@extends('layouts.frontend.app')

@section('content')

<!-- Begin Body -->
<div class="container">
    <div class="row" >
        <div class="col-md-12 formclasscust">
          @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
          @endif

          <form method="POST" action="{{route('user.store')}}">
            @csrf
            <div class="form-group">
              <label for="exampleInputName">Name</label>
              <input type="text" name="name" class="form-control" id="exampleInputName" aria-describedby="NameHelp" placeholder="Enter Name" required>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Mobile Number</label>
              <input type="number" name="mobile" class="form-control" placeholder="Enter Mobile" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">User Role</label>
              <select class="form-control" name="role" required>
                 <option value="">Please Select</option>
                 <option value="user">User</option>
                 <option value="admin">Admin</option>
                 <option value="reports">Reports</option>
                 <option value="attendance">Attendance</option>
                 <option value="buying">Buying</option>
              </select>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" name="status" value="1" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">Active</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
    </div>
</div>
<script>
$("#checkAll").click(function () {
    $(".check").prop('checked', $(this).prop('checked'));
});
</script>
@endsection



