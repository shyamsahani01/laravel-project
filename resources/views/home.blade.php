@extends('layouts.frontend.app')

@section('content')

<!-- Begin Body -->
<div class="container formclasscust">
    <div class="row pull-right btn-right">
        <div class="col-md-9 col-xs-9">
          <a href="{{url('/message')}}" class="btn btn-primary pull-right">View All Message</a>
        </div>
        <div class="form-group  col-md-3 col-xs-3">
          <a href="{{url('/add-user')}}" class="btn btn-primary">Add user</a>
        </div>
      </div>

      @if(auth()->user()->role == 'superadmin')
        <form action="{{ route('file-import') }}" method="POST" class="" enctype="multipart/form-data">
        @csrf
        <div class="col-md-7">
        <div class="form-group pull-right" style=" margin: 0 auto;">
        <div class="custom-file text-left">
        <input type="file" name="file" class="custom-file-input form-control" id="customFile">
        </div>
        </div>
        </div>
        <div class="col-md-3">
        <a class="btn btn-success pull-right" href="{{ route('file-export') }}">Export data</a>
        <button class="btn btn-primary pull-right import_class">Import data</button>
        </div>
        <div class="col-md-2">
        </div>
        </form>
      @endif

  <div class="row" style="margin-top:40px" >
    <div class="col-md-12 ">
      <div class="alert alert-danger" role="alert" id="alert_box">
        <span class="error_message"></span>
      </div>
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <form action="{{route('messageSend')}}" method="POST" class="form-class" id="form_id">
        @csrf

        <div class="col-md-12 y-2">
          @if(Session::has('message'))
          <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
          @endif
          <div class="form-group">
            <label for="exampleInputEmail1">Message</label>
            <textarea name="editor1" id="message_input" class="form-control" rows="4" cols="50" required></textarea>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Table Of Products</label>

            <table class="table table-bordered border-primary bg-primary" id="example">
              <thead>
                <tr>
                  @if(isset($products))
                  @foreach($products as $product)
                  <input type="hidden" name="p_ids[]" value="{{ $product->id }}">
                  @if($product->id !='8' && $product->id !='9' && $product->id !='10')
                  <th scope="col">{{ $product->name }}</th>
                  @endif
                  @endforeach
                  @endif
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr id="table_row">
                  <td colspan="8">
                  </td>
                </tr>
              </tbody>
            </table>
            <button type="button" name="add" id="add" class="btn btn-success add_filed add_input">Add More</button>
          </div>
          <button id="submit_btn" type="submit" class="btn btn-primary pull-right" style="margin-top:-48px">Submit</button>

          <div class="mt-5" style="margin-top:10px">
            <table id="example" class="table table-striped table-bordered " style="width:100%">
              <thead>
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
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->mobile}}</td>
                  @if(auth()->user()->role == 'superadmin')
                  <td>{{date('d-m-Y',strtotime($user->created_at))}}</td>
                  @endif
                  <td>
                    <a href="{{url('view-message/'.$user->id)}}" class="text-success notification"><span><i class="fas fa-eye"></i></span><span class="badge">{{$user->getNotifaction($user->id)}}</span></a>
                    @if(auth()->user()->role == 'superadmin')
                    <a href="{{url('edit-user/'.$user->id)}}" class="btn btn-success btn_space"><span><i class="fas fa-edit"></i></span></a>
                    <a href="{{url('delete-user/'.$user->id)}}" class="btn btn-danger btn_space"><span><i class="fas fa-trash"></i></span></a>
                    @endif
                  </td>
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
  <script>
    jQuery(function(){
       jQuery('.add_input').click();
    });
    $("#checkAll").click(function () {
      $(".check").prop('checked', $(this).prop('checked'));
    });
    $('#alert_box').hide();
    $( "#submit_btn" ).click(function() {
      var message = '';
      var msg = $('#message_input').val();
      if(msg == ''){
        var message  = 'Please Enter Message Filed is Required';
        $('#alert_box').show();
        $('.error_message').html(message);
        return false;
      }
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        var message  = 'Please Check At least One Vendor';
        $('#alert_box').show();
        $('.error_message').html(message);
        return false;
      }



      $( "#form_id" ).submit();
    });
  </script>
  <script type="text/javascript">
    var i = 0;
    $('#loader').hide();
    $(".add_filed").click(function(){
      $('#loader').show();
      var more = ++i;
      var id = more;
      $.ajax({
        url: 'addmore',
        type: "get",
        data: {id:id},
        success: function(response){
          $('#example').append(response.html);
          $('#loader').hide();
        }
      });
      $('#table_row').hide();
      $('.add_input').show();
    });

    $(document).on('click', '.remove-tr', function(){
     $(this).parents('tr').remove();
   });

    $(document).ready(function(){
      $("form").submit(function(){
        $('#loader').show();
      });
    });
  </script>
@endsection
