@extends('admin.layout.app')
@section('content')
    <div class="main-panel">
        <div class="content">
            @includeif('admin.erpnext.filters')
            <div class="row" style="margin-top: 10px;">
                <div class="col-md-12">
                    <div class="card">
                    <div class="clearfix"></div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr style="text-align: center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
                                            <th>S.No.</th>
                                            <th>Name</th>
                                            <th>Supplier Name</th>
                                            <th>WorkFlow Status</th>
                                            <th>Company</th>
                                            <th>Grand Total</th>
                                            <th>Stock QTY</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($purchasedatas) > 0)
                                            @php $count = 1; @endphp
                                            @foreach ($purchasedatas as $key => $data)
                                                <tr style="text-align: center;">
                                                    <td>{{ $purchasedatas->firstItem() + $key }}</td>
                                                    <td>{{ $data['name'] }}</td>
                                                    <td>{{ $data['supplier_name'] }}</td>
                                                    <td>{{ $data['workflow_state'] }}</td>
                                                    <td>{{ $data['company'] }}</td>
                                                    <td>{{ round($data['grand_total']) }}</td>
                                                    <td>
                                                        <?php $total = 0; ?>
                                                        @foreach($data->Purchaseitem as $item)
                                                          @php $total += $item->qty @endphp
                                                        @endforeach
                                                        <a href="https://erp.pinkcityindia.com/app/purchase-order/{{ $data['name']  }}" target="_blanck"> {{ $total }} </a>
                                                    </td>
                                                    <td>{{ $data['status'] }}</td>
                                                    <td>{{ $data['schedule_date'] }}</td>
                                                    <td><a href="https://erp.pinkcityindia.com/app/purchase-order/{{ $data['name']  }}" target="_blanck" class="btn btn-warning"><i class="fa fa-eye"></i></a></td>
                                                </tr>
                                            @endforeach
                                        @else
                                          <tr>
                                           <td colspan="10" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
                                          </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="btn-group">
						            <button type="button" onclick="changenumber(10)" class="btn btn-default btn-sm btn-paging @if(request()->show == 10 || empty(request()->show )) btn-info @endif " data-value="10">10</button>
						            <button type="button" onclick="changenumber(100)" class="btn btn-default btn-sm btn-paging @if(request()->show == 100) btn-info @endif " data-value="100">100</button>
						            <button type="button" onclick="changenumber(500)" class="btn btn-default btn-sm btn-paging @if(request()->show == 500) btn-info @endif " data-value="500">500</button>
                               </div>
                                <div class="pagination pull-right">
                                    {{ $purchasedatas->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer-scripts')
<script>
   function changenumber(params) {
    $("#show_hidden_input").attr("value", params);
    $("#filter_form").trigger("submit");
}
</script>
@endsection
