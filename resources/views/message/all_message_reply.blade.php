@extends('layouts.frontend.app')

@section('content')
<!-- Begin Body -->
<div class="container">
    <div class="row form-class">
        <form action="{{route('messageReplayStore')}}" method="POST" class="form-class" id="form">
          @csrf
           
            <div class="col-md-12">
                @if(Session::has('message'))
                   <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                 
                  <div class="form-group">
                    <input type="hidden" name="messageid" value="{{$message->id}}">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" name="email" class="form-control" value="{{$message->users->email}}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Mobile Number</label>
                    <input type="text" name="mobile" class="form-control" value="{{$message->users->mobile}}">
                  </div>
                   <div class="form-group">
                    <label for="exampleInputEmail1">Message:-</label>
                    <Strong>{!! $message->message !!}</Strong>
                  </div>
                  @if(count($datas['pdatas']) >= 1)
                  <table id="example" class="table table-bordered border-primary bg-primary">
                    <thead>
                      <tr>
                        @foreach($products as $product)
                        <input type="hidden" name="p_ids[]" value="{{ $product->id }}"> 
                        <th scope="col">{{ $product->name }}</th>
                        @endforeach
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($datas['pdatas'] as $data)
                      <tr>
                        <?php
                         $catdata = $data;
                         unset($catdata[5],$catdata[6],$catdata[7]);
                        ?>
                        @foreach($catdata as $pcatdata)
                         <td>{!! Helper::getProductName($pcatdata) !!} </td>
                        @endforeach
                        <td>{{$data[5]}}</td>
                        <td>{{$data[6]}}</td>
                        <td>{{$data[7]}}</td>
                        <td>
                          <select class="form-control" name="available[]" required>
                            <option value="">Please Select</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                          </select>
                        </td>
                         <td><input type="number" name="price[]" class="form-control" maxlength="6" placeholder="Enter Price" required></td>
                         <td><input type="text" name="remark[]" class="form-control" placeholder="Enter Remarks" required></td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                  @endif
                  <div class="form-group">
                    <label for="exampleInputEmail1">Reply Message</label>
                    <textarea name="message" class="form-control" rows="4" cols="50"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary pull-right">Submit</button>
            </div>  
          
        </form>
    </div>
</div>
@endsection

