@extends('admin.layout.app')
@section('content')
<div class="main-panel">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="shadow-lg p-3 mb-5 bg-white rounded" style="margin-bottom: 20px !important;">
                <div class="card">
                  <div class="card-header card-header-primary" style="background-color: white;">

                      <div class="row">
                          <div class="col-md-6">
                            <h4 class="card-title " style="font-weight: 700;color: black;font-size: 1.25rem;">{{$title}}</h4>
                          </div>
                          <div class="col-md-6">
                            <a class=" pull-right" href="{{ url('quotation/quotation_design/add?quotation_id=&quoation_form_type=Anna-EFB Network&page=view') }}">
                              <button class="btn btn-secondary " type="button" >
                                <i class="fa fa-plus"></i> Add Quotation
                              </button>
                            </a>
                          </div>
                      </div>


                      <form method="GET" id="filter_form" action="{{ url('/quotation/list') }}">
                         <input type="hidden" name="show" id="show_hidden_input" value="{{ request()->show }}" >
                         <div class="x_content">
                            <div class="row">
                               <div class="col-md-3 col-sm-12  form-group">
                                  <input type="text" name="customer_name"  autocomplete="off" placeholder="Search Customer" class="form-control" value="{{ request()->customer_name }}">
                               </div>
                               <div class="col-md-3 col-sm-12  form-group">
                                  <input type="text" name="title"  autocomplete="off" placeholder="Search Title" class="form-control" value="{{ request()->title }}">
                               </div>
                               <!-- <div class="col-md-3 col-sm-12  form-group">
                                  <input type="date" name="date"  autocomplete="off" placeholder="Search Date" class="form-control" value="{{ request()->date }}"> -->
                               <!-- </div> -->
                               <div class="col-md-2 col-sm-12  form-group">
                                  <input placeholder="From" name="from" autocomplete="off"  type="text" onfocus="(this.type='date')" class="form-control" value="{{ request()->from }}"  >
                                  <!-- <input placeholder="From" name="from" autocomplete="off"  type="text" onfocus="(this.type='date')" class="form-control" value="@if(!empty(request()->from)){{ date('d/m/Y', strtotime(request()->from) ) }}@endif"  > -->
                               </div>
                               <div class="col-md-2 col-sm-12  form-group">
                                  <!-- <input placeholder="To" name="to"  autocomplete="off"  type="text" onfocus="(this.type='date')"  class="form-control" value="@if(!empty(request()->to)){{ date('d/m/Y', strtotime(request()->to) ) }}@endif" > -->
                                  <input placeholder="To" name="to"  autocomplete="off"  type="text" onfocus="(this.type='date')"  class="form-control" value="{{ request()->to }}" >
                               </div>
                               <div class="col-md-2 col-sm-12 text-end">
                                  <button type="submit" title="Submit" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
                                  <a href="{{ url('/quotation/list') }}" style="color: white;" ><button type="button" title="Refresh" class="btn btn-danger"><i class="fa fa-refresh"></i></button></a>
                               </div>
                            </div>
                         </div>
                      </form>


                    <!-- <a href="{{url('quotation/quotation_design_1/add')}}" class="btn btn-success btn-sm pull-right" >

                      <i class="fa fa-plus"></i> Add Design</a> -->


                      <!-- <div class="dropdown pull-right" style="margin-top: -31px; margin-right: -10px;" >

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="{{ url('quotation/quotation_design/add?quotation_id=&quoation_form_type=Anna-EFB Network&page=view') }}">Anna-EFB Network</a> -->
                          <!-- <a class="dropdown-item" href="{{url('quotation/quotation_design_2/add')}}">Monika</a> -->
                        <!-- </div>
                      </div> -->

                      <!-- <div class="dropdown pull-right" style="margin-top: -31px; margin-right: -10px;" >
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-plus"></i> Add Quotation
                        </button> -->
                        <!-- <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          Anna-EFB Network</a> -->
                          <!-- <a class="dropdown-item" href="{{url('quotation/quotation_design_2/add')}}">Monika</a> -->
                        <!-- </div>
                      </div> -->

                  </div>
                  <div class="card-body">
                    <div class=" ">
                      <table id="datatable" class="table table-bordered" style="width:100%">
                        <thead>
                          <tr style="text-align:center;">
                              <!-- <th>S.No.</th> -->
                              <th>Name</th>
                              <th>Title</th>
                              <th>Quoation Form Type</th>
                              <!-- <th>Sales Person</th> -->
                              <th>Customer</th>
                              <th>Date</th>
                              <th>Status</th>
                              <!-- <th>Document Status</th> -->
                              <th style="width:200px">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(!empty($quotation_data))
                            @foreach($quotation_data as $key => $data)

                            <tr style="text-align: center;">
                                <!-- <td>{{$key+1}}</td> -->
                                <!-- https://erp.pinkcityindia.com/app/quotation/SAL-QTN-2022-00012 -->
                                <td>
                                  <a href="{{url('https://erp.pinkcityindia.com/app/quotation/'.$data->name)}}" class="green-text" target="_blank">
                                    {{ $data->name }}
                                  </a>
                                </td>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->quoation_form_type }}</td>
                                <!-- <td>{{ $data->owner }}</td> -->
                                <td>{{ $data->customer_name }}</td>
                                <td>{{ $data->transaction_date }}</td>
                                <td>{{ $data->status }}</td>
                                <td style="padding: 0px !important;text-align: center;">
                                   <a href="{{url('quotation/quotation_design/view?quotation_id='.$data->name.'&quoation_form_type='.$data->quoation_form_type.'&page=view')}}" title="View" class="btn btn-info btn_space" style="color: white;" ><i class="fa fa-eye"></i></a>
                                   <a href="{{url('quotation/quotation_design/edit?quotation_id='.$data->name.'&quoation_form_type='.$data->quoation_form_type.'&page=edit')}}" title="Edit" class="btn btn-success btn_space" style="color: white;"><i class="fa fa-edit"></i></a>
                                   <a href="{{url('quotation/quotation_design/export?quotation_id='.$data->name.'&quoation_form_type='.$data->quoation_form_type.'&page=excel')}}" title="Export" class="btn btn-primary btn_space" style="color: white;"><i class="fa fa-file-excel-o"></i></a>
                                   <a href="javascript:void(0)" onclick="showConfirmDialog('{{$data->name}}')"title="Delete" class="btn btn-danger btn_space" style="color: white;"><i class="fa fa-trash"></i></a>
                                </td>

                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                      </table>
                      <div class="btn-group">
                          <button type="button" onclick="changenumber(10)" class="btn btn-default btn-sm btn-paging @if(request()->show == 10 || empty(request()->show )) btn-info @endif " data-value="10">10</button>
                          <button type="button" onclick="changenumber(100)" class="btn btn-default btn-sm btn-paging @if(request()->show == 100) btn-info @endif " data-value="100">100</button>
                          <button type="button" onclick="changenumber(500)" class="btn btn-default btn-sm btn-paging @if(request()->show == 500) btn-info @endif " data-value="500">500</button>
                      </div>
                      <div class="pagination pull-right">
                          {{ $quotation_data->links('vendor.pagination.bootstrap-4') }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>



<!-- confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Design</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <h5 class="modal-title" >Are you sure ?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" id="deleteForm-button" onclick="deleteForm(0)" class="btn btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>


<script>
function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}


function showConfirmDialog(row_id) {
      $("#deleteForm-button").attr("onclick", "deleteForm('"+row_id+"')")
      $("#confirmModal").modal("show")
}


function deleteForm(id)
{
  $("#confirmModal").modal("hide")
  window.location.href = "{{url('quotation/delete?quotation_id=')}}" + id
}


</script>
  @endsection
