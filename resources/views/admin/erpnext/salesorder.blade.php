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
                            <p class="card-category"> All Sales Order Listing</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Customer Name</th>
                                            <th>Grand Total</th>
                                            <th>Company</th>
                                            <th>Status</th>
                                            <th>Stock QTY</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($salesdatas) > 0)
                                            @php $count = 1; @endphp
                                            @foreach ($salesdatas as $data)
                                                <tr>
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ $data['name'] }}</td>
                                                    <td>{{ $data['customer_name'] }}</td>
                                                    <td>{{ $data['grand_total'] }}</td>
                                                    <td>{{ $data['company'] }}</td>
                                                    <td>{{ $data['status'] }}</td>
                                                    <td>
                                                        <?php $total = 0; ?>
                                                        @foreach($data->Salesitem as $item)
                                                          @php $total += $item->qty @endphp
                                                        @endforeach
                                                        <a href="https://erp.pinkcityindia.com/app/sales-order/{{ $data['name']  }}" target="_blanck"> {{ $total }} </a>
                                                    </td>
                                                    <td>{{ $data['transaction_date'] }}</td>
                                                    <td><a href="https://erp.pinkcityindia.com/app/sales-order/{{ $data['name']  }}" target="_blanck" class="btn btn-warning">View</a></td>
                                                </tr>
                                            @endforeach
                                        @else 
                                           <tr>
                                            <td colspan="10" class="text-center text-danger"><h3><b>No Record Found</b></h3></td>
                                           </tr>   
                                        @endif

                                    </tbody>
                                </table>
                                <div class="pagination pull-right">
                                    {{ $salesdatas->links('vendor.pagination.bootstrap-4') }}
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
