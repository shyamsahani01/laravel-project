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
        </div>
       <h3>Admin Users</h3>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>S.NO.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               @if(!empty($users))
                @foreach($users as $key => $user)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>@if($user->email_verified_at) <span class="active">Active</span> @else <span class="inactive">Inactive</span> @endif</td>
                    <td>{{date('d-m-Y',strtotime($user->created_at))}}</td>
                    <td>
                    <a href="{{url('/user-active/'.$user->id)}}" class="text-danger notification"><span>Active</span></a>
                    <a href="{{url('/user-deleted/'.$user->id)}}" class="text-danger notification"><span>Delete</span></a></td>
                </tr>
                @endforeach
               @endif
            </tbody>
        </table>
    </div>
</div>
<script>
$("#checkAll").click(function () {
    $(".check").prop('checked', $(this).prop('checked'));
});
</script>
@endsection



