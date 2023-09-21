@extends('admin.layout.app')

@section('content')

<!-- Begin Body -->
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
                    <h4 class="card-title">Edit User</h4>
                    <p class="card-category">Edit Details  User</p>
                  </div>
                  <div class="card-body">
                    <form method="POST" action="{{route('user.update')}}">
                      @csrf
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <label class="bmd-label-floating">Name</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control" value="{{ $user->mobile }}" maxlength="12" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">Password</label>
                            <input type="password" name="password" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="bmd-label-floating">User Role</label>
                            <select class="form-control" name="role" required>
                              <option value="">Please Select</option>
                              <option value="user" @if($user->role == 'user') selected @endif>User</option>
                              <option value="admin" @if($user->role == 'admin') selected @endif>Admin</option>
                              <option value="reports" @if($user->role == 'reports') selected @endif>Reports</option>
                              <option value="attendance" @if($user->role == 'attendance') selected @endif>Attendance</option>
                              <option value="buying" @if($user->role == 'buying') selected @endif>Buying</option>
                              <option value="superadmin" @if($user->role == 'superadmin') selected @endif>Superadmin</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6" style="margin-left: 20px">
                            <input type="checkbox" class="form-check-input" name="status" @if($user->status == 1) checked @endif  id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Active  </label>
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

@endsection
