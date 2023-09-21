@extends('admin.layout.app')

@section('content')
    <div class="main-panel">
        @includeif('admin.layout.navbar')
        <div class="content">
            @includeif('admin.erpnext.filters')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ $title }}</h4>
                            <p class="card-category"> All Stock Ledger Listing</p>
                            {{-- <a href="{{ url('add-user') }}" class="btn btn-success btn-sm pull-right"
                                    style="margin-top:-43px;"><i class="fa fa-plus"></i> Add User</a> --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>S.NO.</th>
                                            <th>Item Code</th>
                                            <th>Name</th>
                                            <th>Warehouse</th>
                                            <th>Stock QTY</th>
                                            <th>Sales QTY</th>
                                            <th>Purchase QTY</th>
                                            <th>Company</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($stockdatas))

                                            @foreach ($stockdatas as $key => $stock)
                                                @php
                                                    if ($stock['actual_qty'] < 0) {
                                                        $purchase = 'purchase_min';
                                                        $purchasebtn = '<a class="btn btn-danger" target="_blnack" href="https://erp.pinkcityindia.com/app/purchase-order/new-purchase-order-">Purchase</a>';
                                                    } else {
                                                        $purchase = '';
                                                        $purchasebtn = '';
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $stock['item_code'] }}</td>
                                                    <td>{{ $stock['name'] }}</td>
                                                    <td>{{ $stock['warehouse'] }}</td>
                                                    <td class="{!! $purchase !!}">{{ $stock['actual_qty'] }}</td>
                                                    <td>
                                                        {{ $stock->SalesItem($stock->item_code) }}
                                                        {{-- @php $sales_tot = 0  @endphp
                                                        @foreach($stock->Salesitem as $sale)
                                                          <?php //$sales_tot += $sale->qty ?>
                                                        @endforeach
                                                        {{ $sales_tot }} --}}
                                                    </td>
                                                    <td>
                                                       
                                                        {{-- @php $purcahse_tot = 0  @endphp
                                                        @foreach($stock->Purchaseitem as $purchase)
                                                         <?php //$purcahse_tot += $purchase->qty ?>
                                                        @endforeach --}}
                                                      <a href="{{url('/purchase-order',$stock->item_code)}}" target="_blanck">{{ $stock->PurchaseItem($stock->item_code) }}</a>
                                                    </td>
                                                    <td>{{ $stock['company'] }}</td>
                                                    <td>{{ $stock['creation']}}</td>
                                                    <td> {!! $purchasebtn !!} </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
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
    {{-- <footer class="footer">
        <div class="container-fluid">
            <nav class="float-left">
                <ul>
                    <li>
                        <a href="https://www.creative-tim.com">
                            Creative Tim
                        </a>
                    </li>
                    <li>
                        <a href="https://creative-tim.com/presentation">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="http://blog.creative-tim.com">
                            Blog
                        </a>
                    </li>
                    <li>
                        <a href="https://www.creative-tim.com/license">
                            Licenses
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="copyright float-right">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script>, made with <i class="material-icons">favorite</i> by
                <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a> for a better web.
            </div>
        </div>
    </footer> --}}
    </div>
@endsection
