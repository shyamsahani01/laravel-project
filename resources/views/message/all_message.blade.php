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
        <div class="col-md-2 col-xs-4">
          <a href="{{url('/')}}" class="btn btn-primary" style="margin-top:10px">Back To Home Page</a>
        </div>
        <div class="col-md-12 col-xs-8 form-group ">
        <h3 class="all_message">All Message</h3>
        </div>
        
        <form action="{{route('messageSend')}}" method="POST" class="form-class" id="form">
          @csrf
        <table id="allmessage" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <td>S.No.</td>
                    <th>Message</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
              @foreach($messages as $key => $message)
               @if($message->token_number)  
                <tr> 
                  <td>{{$key+1}}</td>
                  <td>{!! $message->message !!}</td>
                  <td>{{date('d-m-Y h:i A',strtotime($message->created_at))}}</td>
                  <td><a href="{{url('message/view-message/'.$message->token_number)}}" class="text-success notification"><span>View</span></a></td>
                </tr>
               @endif 
              @endforeach
                
            </tbody>
        </table>
        </form>
    </div>
</div>
<script>
$("#checkAll").click(function () {
    $(".check").prop('checked', $(this).prop('checked'));
});
$(document).ready(function() {
    $('#allmessage').DataTable( {
        "order": [[ 3, "desc" ]]
    } );
});
</script>
@endsection



