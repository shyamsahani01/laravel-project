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

        <form action="{{ route('category-import') }}" method="POST" class="" enctype="multipart/form-data">
            @csrf
            <div class="col-md-7">
              <div class="form-group pull-right" style=" margin: 0 auto;">
                  <div class="custom-file text-left">
                      <input type="file" name="file" class="custom-file-input form-control" id="customFile">
                  </div>
              </div>
            </div>
            <div class="col-md-3">
              <button class="btn btn-primary pull-right import_class">Import data</button>
            </div>
            <div class="col-md-2">
            </div>
        </form>
        @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
     @endif
        </div>
       <h3>Add Product</h3>
       <form method="POST" action="{{url('/storeProduct')}}">
        @csrf
        <div class="form-group col-md-6">
          <label for="exampleInputEmail1">Product name</label>
          <input type="text" class="form-control" name="product_name"  placeholder="Product Name" required>
        </div>
        <div class="form-group col-md-6">
        <button type="submit" class="btn btn-primary" style="margin-top: 20px">Submit</button>
        </div>
      </form>
    </div>
    <div style="margin-top: 60px;">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Name</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @if(!empty($products))
                @foreach($products as $key=>$product)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{$product->name}}</td>
                    <td>{{date('d-m-Y',strtotime($product->created_at))}}</td>
                    <td>
                    <a href="{{url('product-deleted/'.$product->id)}}" class="text-success notification"><span><i class="fa fa-trash"></i>Delete</span></a></td>
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



