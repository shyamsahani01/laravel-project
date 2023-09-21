@extends('admin.layout.app')

@section('content')
<div class="main-panel">
     @includeif('admin.layout.navbar')
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">{{$title}}</h4>
                  <p class="card-category"> All Vendor Listing</p>
                  <a href="{{url('add-user')}}" class="btn btn-success btn-sm pull-right" style="margin-top:-43px;"><i class="fa fa-plus"></i> Add User</a>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                      <tr >
                          <th><input type="checkbox" class="check" id="checkAll"></th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Mobile Number</th>
                          @if(auth()->user()->role == 'superadmin')
                          <th>Created at</th>
                          @endif
                          <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      @if(!empty($users))
                          @foreach($users as $user)
                          <tr>
                            <td><Input type="checkbox" class="check check_user" name="ids[]" value="{{$user->id}}"></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile }}</td>
                            @if(auth()->user()->role == 'superadmin')
                            <td>{{date('d-m-Y',strtotime($user->created_at))}}</td>
                            @endif
                            <td>
                              <a href="{{url('view-message/'.$user->id)}}" class="btn btn-primary notification"><span><i class="fa fa-eye"></i></span><span class="badge">{{$user->getNotifaction($user->id)}}</span></a>
                              @if(auth()->user()->role == 'superadmin')
                              <a href="{{url('edit-user/'.$user->id)}}" class="btn btn-success btn_space"><span><i class="fa fa-edit"></i></span></a>
                              <a href="{{url('delete-user/'.$user->id)}}" class="btn btn-danger btn_space"><span><i class="fa fa-trash"></i></span></a>
                              @endif
                            </td>
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
