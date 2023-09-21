@extends('layouts.frontend.app')
@section('content')
<div class="container">
    <div class="row formclasscust">
       <div class="col-md-2 col-xs-4">
          <a href="{{url('/')}}" class="btn btn-primary" style="margin-top:10px">Back To Home Page</a>
        </div>

        
    </div>   
    <div class="row form-group">
            <div class="col-md-12 col-xs-12 form-group">
             <h3 class="message-text">Message :- {{$msg->message}} </h3>
            </div>
            <form method="get" action="{{route('view-Message',Request::segment(3))}}">
                @csrf
                <div class="col-md-12 col-xs-12 form-group">
                    <div class="form-group col-md-2 col-xs-4">
                        <select class="form-control" name="stone">
                            <option value="">Select Stone</option>
                            @foreach($msg->ProductCategory('Stone') as $stone)
                            <option value="{{$stone->id}}" @if(request()->get('stone') == $stone->id) selected @endif>{{$stone->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2 col-xs-4">
                        <select class="form-control" name="shape">
                            <option value="">Select Shape</option>
                            @foreach($msg->ProductCategory('shape') as $shape)
                            <option value="{{$shape->id}}" @if(request()->get('shape') == $shape->id) selected @endif>{{$shape->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2 col-xs-4">
                        <select class="form-control" name="size">
                            <option value="">Select Size</option>
                            @foreach($msg->ProductCategory('size') as $size)
                            <option value="{{$size->id}}" @if(request()->get('size') == $size->id) selected @endif>{{$size->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2 col-xs-4">
                        <select class="form-control" name="pricect">
                            <option value="">Select Ct/Pc</option>
                            @foreach($msg->ProductCategory('pricect') as $pricect)
                            <option value="{{$pricect->id}}" @if(request()->get('pricect') == $pricect->id) selected @endif>{{$pricect->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2 col-xs-4">
                        <select class="form-control" name="quality">
                            <option value="">Select Quality</option>
                            @foreach($msg->ProductCategory('quality') as $quality)
                            <option value="{{$quality->id}}" @if(request()->get('quality') == $quality->id) selected @endif>{{$quality->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2 col-xs-6">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{route('view-Message',Request::segment(3))}}" class="btn btn-primary">Reset</a>
                    </div>
                </div>
            </form>
            <div class="col-md-12">
                <table id="example" class="table table-bordered border-primary bg-primary" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">S.NO</th>
                            <th scope="col">User Name</th>
                            @foreach($products as $product)
                                <th scope="col">{{ $product->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1; @endphp
                        @foreach($messages as $key => $message)
                            @php 
                            $alldatas = Helper::getAllProductData($requestdata,$message->id);
                            @endphp
                            @foreach($alldatas as $key=>$datas)
                            <tr>
                            <td>{{$count++}}</td>  
                            <td><a href="{{route('view-Message-single',$message->id)}}" style="color:#fff">{{$datas->message->users->name}}</a></td>
                            @php $catdatas = Helper::getAllProducts(json_decode($datas->c_id)); @endphp
                            @foreach($catdatas as $data) 
                            <td>{!! $data !!}</td>   
                            @endforeach
                            </tr>
                            @endforeach               
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> 
    <div class="footer-space"></div>
</div>
@endsection



