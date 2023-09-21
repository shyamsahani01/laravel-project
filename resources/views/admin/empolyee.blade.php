@extends('admin.layout.app')

@section('content')

<!-- Begin Body -->
<div class="main-panel">
  @includeif('admin.layout.navbar')
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
                    @livewire('employees')
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



