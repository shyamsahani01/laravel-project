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
                  <a href="{{url('add-user')}}" class="btn btn-success btn-sm pull-right" style="margin-top: -31px; margin-right: -10px;"><i class="fa fa-plus"></i> Add Admin</a>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                      <tr style="text-align: center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
                          <th>S.No.</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Role</th>
                          <th>Status</th>
                          <th>Created at</th>
                          <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      @if(!empty($users))
                          @foreach($users as $key => $user)
                          <tr style="text-align: center;">
                              <td>{{$key+1}}</td>
                              <td>{{$user->name}}</td>
                              <td>{{$user->email}}</td>
                              <td>{{ ucwords($user->role)}}</td>
                              <!-- <td>@if($user->email_verified_at) <span class="active">Active</span> @else <span class="inactive">Inactive</span> @endif</td> -->
                              <td>@if($user->status) <span class="active">Active</span> @else <span class="inactive">Inactive</span> @endif</td>
                              <td>{{date('d-m-Y',strtotime($user->created_at))}}</td>
                              <td>
                              <a href="{{url('/user-active/'.$user->id)}}" class="btn btn-primary notification"><i class="fa fa-bolt "></i></a>
                              <a href="{{url('edit-user/'.$user->id)}}" class="btn btn-success btn_space"><i class="fa fa-edit"></i></a>
                              <a href="{{url('/user-deleted/'.$user->id)}}" class="btn btn-danger notification"><i class="fa fa-trash"></i></a></td>
                          </tr>
                          @endforeach
                      @endif
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

</div>
@endsection
