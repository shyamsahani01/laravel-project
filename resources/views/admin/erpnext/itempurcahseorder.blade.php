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
                            <p class="card-category"> All Purchase Order Listing</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="stockledger" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Name</th>
                                            <th>Supplier Name</th>
                                            <th>WorkFlow</th>
                                            <th>Total Item</th>
                                            <th>Total Qty</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($purchasedatas))
                                            @php 
                                            $itemqty_total = 0;
                                            $total_qty = 0; @endphp
                                            @foreach ($purchasedatas as $key=> $data)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $data['name'] }}</td>
                                                    <td>{{ $data['supplier_name'] }}</td>
                                                    <td>{{ $data['workflow_state'] }}</td>
                                                    <td>{{ count($data->Purchaseitem) }}</td>
                                                    <td>
                                                        @foreach ($data->Purchaseitem as $item)
                                                          <?php $itemqty_total += $item->qty; ?>
                                                        @endforeach
                                                        {{ round($itemqty_total,2) }} 
                                                    </td>
                                                    <td>{{ $data['status'] }}</td>
                                                    <td>{{ $data['schedule_date'] }}</td>
                                                    <td><a href="https://erp.pinkcityindia.com/app/purchase-order/{{ $data['name'] }}" class="btn btn-success">View</a></td>
                                                    <?php $total_qty += $itemqty_total ?>
                                                </tr>
                                            @endforeach
                                        @endif
                     
                                        <tr>
                                            <td colspan="5"><h4 class="pull-right"><b>Total</b></h4></td>
                                            <td>{{ $total_qty }}</td>
                                        </tr>
                                    </tbody>
                                </table>
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
    <footer class="footer">
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
    </footer>
    </div>
@endsection
