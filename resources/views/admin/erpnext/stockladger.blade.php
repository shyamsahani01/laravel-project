@extends('admin.layout.app')
@section('content')
<div class="main-panel">
   <div class="content">
      @includeif('admin.erpnext.filters')
      <div class="row"  style="margin-top: 10px;">
         <div class="col-md-12">
            <div class="card">
               <div class="clearfix"></div>
               <!-- <div class="card-header card-header-primary">
                  <h4 class="card-title ">{{ $title }}</h4>
                  <p class="card-category"> All Stock Ledger Listing</p>
                  <a href="{{ url('stocks-export') }}" class="btn btn-success btn pull-right" style="margin-top:-43px;"><i class="fa fa-file-excel-o lg" aria-hidden="true"></i> Export Data</a>
                  </div> -->
               <div class="card-body">
                  <div class="table-responsive">

                     <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                           <tr style="text-align: center;text-shadow: 1px 1px 1px lightgrey, 3px 3px 5px lightgrey;">
                              <th>S.No.</th>
                              <th>Item Code</th>
                              <th>Warehouse</th>
                              <th>In QTY</th>
                              <th>Out QTY</th>
                              <th>Balance Qty</th>
                              {{--
                              <th>Sales Qty</th>
                              --}}
                              <th>Purchase Qty</th>
                              <th>Company</th>
                              {{--
                              <th>Date</th>
                              --}}
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @if (count($stockdatas) > 0)
                           @php $count = 1 @endphp
                           @foreach ($stockdatas as $key=>$stock)
                           @php
                           if ($stock['qty_after_transaction'] <= 0) {
                           $purchase = 'purchase_min';
                           $purchasebtn = '<a class="btn btn-danger" target="_blnack" href="https://erp.pinkcityindia.com/app/purchase-order/new-purchase-order-"><i class="fa fa-shopping-cart"></i></a>';
                           } else {
                           $purchase = '';
                           $purchasebtn = '';
                           }
                           @endphp
                           <tr style="text-align: center;">
                              <td>{{ $stockdatas->firstItem() + $key }}</td>
                              <td>{{ $stock['item_code'] }}</td>
                              <td>{{ $stock['warehouse'] }}</td>
                              <td>{{ round($stock['incoming_rate']) }}</td>
                              <td>{{ round($stock['actual_qty']) }}</td>
                              <td class="{!! $purchase !!}">{{ round($stock['qty_after_transaction']) }}</td>
                              {{--
                              <td>{{ Helper::SalesItem($stock['item_code']) }}</td>
                              --}}
                              @php
                              $purchaseqty = Helper::PurchaseItem($stock['item_code'],$data['start_date'],$data['end_date']);
                              // $salesorders = Helper::SalesItem($stock['item_code'],$data['start_date'],$data['end_date']);
                              @endphp
                              {{--
                              <td><a href="https://erp.pinkcityindia.com/sales-order/{{ $salesorders['name'] }}" target="_blanck">{{ $salesorders['total'] }}</a></td>
                              --}}
                              <td><a href="https://erp.pinkcityindia.com/app/purchase-order/{{ $purchaseqty['name'] }}" target="_blanck">{{ $purchaseqty['total'] }}</a></td>
                              <td>{{ $stock['company'] }}</td>
                              {{--
                              <td>{{ $stock['date'] }}</td>
                              --}}
                              <td> {!! $purchasebtn !!} </td>
                           </tr>
                           @endforeach
                           @else
                           <tr>
                              <td colspan="10" class="text-center text-danger">
                                 <h3><b>No Record Found</b></h3>
                              </td>
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
                        {{ $stockdatas->links('vendor.pagination.bootstrap-4') }}
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
