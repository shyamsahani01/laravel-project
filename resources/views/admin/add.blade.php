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
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
          <h3>Add new User</h3>
          <form action="{{url('/adminusers/store')}}" method="post">
            @csrf
            <div class="form-group">
              <label for="exampleInputEmail1">Name</label>
             <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>
             @error('name')
                <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">E-Mail Address</label>
              <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" name="status" id="exampleCheck1" >
              <label class="form-check-label" for="exampleCheck1">Active</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
        <div class="col-md-2">
        </div>

    </div>
</div>
<script>
$("#checkAll").click(function () {
    $(".check").prop('checked', $(this).prop('checked'));
});
</script>
@endsection
