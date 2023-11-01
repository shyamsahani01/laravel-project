<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->

    <link href="{{ asset('/admin/assets/newTheme/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

    <title>Order Tracking</title>

    <link rel="stylesheet" href="/public/admin/order-tracking/message-dnp/notification.css">
    <link rel="stylesheet" href="/public/admin/order-tracking/css/design.css?sf">
    <link rel="stylesheet" href="/public/admin/order-tracking/css/style.css">

</head>

<body>
    <div id="loader"></div>

    <div id="particles-js"></div>


    <div class="container-fluid">
        <div class="row border-bottom border-danger">
            <!-- <div class="col-lg-4 d-flex justify-content-start align-items-center bg-white">
            </div> -->
            <div
                class="col-md-12 p-0 mb-0 text-center display-flex justify-content-center bg-white py-2 align-items-center">
                <img src="https://www.pinkcityindia.com/wp-content/uploads/2023/07/350x71-1-2.png" alt="" srcset=""
                    style="background: #000;border-radius: 8px;width: 180px; height: auto;padding:8px 10px;display:inline-block;margin-right:30px;">
                <span class="page-title">Order Tracking</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" id="order_search_form" class="row bg-white px-0 py-2">
                    <div class="col-lg-6">
                        <div class="alert alert-light rounded-3 mb-0 p-2">
                            <small class="mb-0" style="font-size: 16px;font-weight:bold;" id="client_name"></small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-8">
                        <div class="input-group">
                            <input type="text" id="customer_id" class="form-control" placeholder="Enter Customer ID"
                                aria-label="Customer ID" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-8 ">
                        <div class="input-group">
                            <select name="company" id="company_code" class="form-control">
                                <!-- <option value="">Select Company</option> -->
                                <option value="Mahapura" @if(request()->company == 'Mahapura') Selected @endif>Mahapura
                                </option>
                                <option value="Sitapura" @if(request()->company == 'Sitapura') Selected @endif>Sitapura
                                </option>
                                <!-- <option value="PC" @if(request()->company == 'PC') Selected @endif>PC (Mahapura)</option>
                             <option value="PJ" @if(request()->company == 'PJ') Selected @endif>PJ (Unit 1)</option>
                             <option value="PJ2" @if(request()->company == 'PJ2') Selected @endif>PJ2 (Unit 2)</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-4">
                        <button type="submit" class="btn btn-primary d-block w-100">Search</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="row mb-3">
            <!-- <div class="col-md-12 bg-white py-2">
        <p class="text-center title-1">Client Name</p>
    </div> -->
        </div>
        <div class="row order">
            <div class="col-xl-2 col-lg-4 col-12 text-center order-section mb-3 inactive-section" id="order-list"
                style="height: auto !important;">
                <section class="section">
                    <div class="card">
                        <div class="card-header py-1 alert alert-success mb-0">
                            <p class="text-center title-1">Order List</p>
                        </div>
                        <div class="card-body py-0 px-1 border-0" id="order-list-data">

                        </div>
                    </div>
                </section>
            </div>

            <div class="col-xl-5 col-lg-8 col-12 text-center design-section mb-3 inactive-section"
                id="order-design-table" style="height: auto;">
                <section class="section p-2 rounded-3" style="overflow-x: auto !important;">
                    <table class="table table-bordered rounded-3">
                        <thead class="table-warning">
                            <tr>
                                <th scope="col">S.No.</th>
                                <th scope="col">Design</th>
                                <th scope="col">Design Category</th>
                                <th scope="col">Size</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="order-design-table-data">
                            <tr>
                                <th scope="row">1</th>
                                <td>SDF345</td>
                                <td>Ring</td>
                                <td>30</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm">View Details ></button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>WERK452</td>
                                <td>Bracelet</td>
                                <td>50</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm">View Details ></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>
            </div>

            <div class="col-xl-5 col-lg-12 col-12 tracking-section mb-3 inactive-section" id="order-design-details"
                style="height: auto !important;">
                <section class="section">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <p class="title-1" id="design-code">
                                Design Image
                            </p>
                            <img id="design_image" src="https://picsum.photos/800/300" alt="" srcset=""
                                class="img-fluid rounded-3 shadow">
                        </div>
                        <div class="col-md-12 mb-3">
                            <p class="title-1">Design Progress</p>
                            <!-- <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 15%" aria-valuenow="15"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-success" role="progressbar" style="width: 30%"
                                    aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 20%"
                                    aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 10%"
                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                            </div> -->
                            <div class="progress">
                                <!-- <div class="progress-bar" id = "progress_bar" role="progressbar" style="width: 70%;" aria-valuenow="70"
                                    aria-valuemin="0" aria-valuemax="100">70%</div> -->
                                <div class="progress-bar" id = "progress_bar" role="progressbar"  aria-valuenow="70"
                                    aria-valuemin="0" aria-valuemax="100">70%</div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <b>Current Production:&nbsp;<small class="text-primary" id="curr_prod">21 Pcs</small></b>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <b>Remaining Production:&nbsp;<small class="text-primary" id="remain_prod">9 Pcs</small></b>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <b>Total Production:&nbsp;<small class="text-primary" id="total_prod">30 Pcs</small></b>
                        </div>

                    </div>
                </section>
            </div>

        </div>
        <div class="row mb-3 inactive-section" id="order-info">
            <div class="col-md-12 order-track">
                <section class="section">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="title-1">
                                Order Progress
                            </p>
                            <div class="progress mb-3">
                                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100">25%</div>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-0 mb-3">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <p class="title-1">Track Delivery</p>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center text-success">
                                    1. Order Packed
                                    <small class="badge bg-success rounded-pill">Complete</small>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center text-primary">
                                    2. Order Shipped
                                    <span class="badge bg-primary rounded-pill">Pending</span>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center text-primary">
                                    3. Order Delivered
                                    <span class="badge bg-primary rounded-pill">Pending</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="/public/admin/order-tracking/images/delivery.jpg" alt="" srcset=""
                                    class="img-fluid" width="400px">
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>


    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->

    <!-- jQuery -->
    <script src="{{ asset('/admin/assets/newTheme/vendors/jquery/dist/jquery.min.js')}}"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"> -->
    </script>
    <script src="/public/admin/order-tracking/particles/particles.min.js"></script>

    <script src="/public/admin/order-tracking/js/script.js"></script>
    <script src="/public/admin/order-tracking/message-dnp/notification.js"></script>
    <!-- <script src="/public/admin/order-tracking/js/order-tracking.js"></script> -->

    <!-- Loader start -->
    <script>
    var loader = new Loader("loader", "/public/admin/order-tracking/images/spinner.gif");

    </script>
    <!-- Loader end -->

    <script>
    $("#order_search_form").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{  url("/emporer/order-tracking-check-cust-order") }}',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "get",
            data: {
                "customer_id": $("#customer_id").val(),
                "company_code": $("#company_code").val()
            },
            dataType: "json",
            beforeSend: function(obj) {
              loader.show()
                // $('#loader').removeClass('hidden')
            },
            success: function(obj) {
              loader.hide()

                $('#order-design-details').addClass("inactive-section")
                $('#order-design-table').addClass("inactive-section")
                // $('#order-info').addClass("inactive-section")
                // $('#loader').addClass('hidden')
                if (obj.status) {
                    html_data = ""
                    client_name = ""
                    for (let i = 0; i < obj.data.length; i++) {
                        client_name = obj.data[i].CmName
                        id_name = "order-" + obj.data[i].OmIdNo + '-' + obj.data[i].OmCoCd
                        html_data += '<a href="javascript:void(0)" onclick="getDesignList(\'' + obj.data[i].OmIdNo + '\', \'' + obj.data[i].OmCoCd + '\', \'' + obj.data[i].order_no + '\')" '
                        html_data += ' id="' + id_name + '" class="order-no order-list">' + obj.data[i].order_no + '<small class="order-date">' + obj.data[i].order_date + '</small></a>';
                    }
                    $('#order-list').removeClass("inactive-section")
                    // $('#order-info').removeClass("inactive-section")
                    $('#order-list-data').html(html_data)
                    $('#client_name').html(client_name)

                } else {
                    // $('#order-info').addClass("inactive-section")
                    $('#order-list').addClass("inactive-section")
                    $('#order-design-table').addClass("inactive-section")
                    $('#client_name').html("")
                    new NOTIFY({
                        text: obj.msg,
                        position: 'bottom-right',
                        type: 'danger',
                        autoClose: 3000,
                    });
                }


            },
            error: function(obj) {
              loader.hide()
                // $('#loader').addClass('hidden')
                var error_msg = ""
                $.each(obj.responseJSON.errors, function(key, val) {
                    error_msg += val[0] + "\n";
                });
                new NOTIFY({
                    text: error_msg,
                    position: 'bottom-right',
                    type: 'danger',
                    autoClose: 3000,
                });

            },
        });
    })


    function getDesignList(OmIdNo, OmCoCd, order_no) {

        $(".order-list").removeClass("active");
        $("#order-" + OmIdNo + '-' + OmCoCd).addClass("active");

        $.ajax({
            url: '{{  url("/emporer/order-tracking-order-designs") }}',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "get",
            data: {
                "OmIdNo": OmIdNo,
                // "OmYy": OmYy,
                // "OmChr": OmChr,
                // "OmNo": OmNo,
                "OmCoCd": OmCoCd
            },
            dataType: "json",
            beforeSend: function(obj) {
              loader.show()
            },
            success: function(obj) {
                loader.hide()
                $('#order-design-details').addClass("inactive-section")
                // $('#loader').addClass('hidden')
                if (obj.status) {
                    html_data = ""
                    for (let i = 0; i < obj.data.length; i++) {
                        parameter_data = "'" + obj.data[i].OdIdNo + "', '" +obj.data[i].OdDmCd + "', '" + obj.data[i].OdCoCd + "', '" + (i +  1) + "'";
                        html_data += ` <tr class="design-tr" id="design-` + (i + 1) + `-` + obj.data[i].OdDmCd + `">
                                 <th scope="row">` + (i + 1) + `</th>
                                 <td>` + obj.data[i].OdDmCd + `</td>
                                 <td>` + obj.data[i].category + `</td>
                                 <td>` + obj.data[i].OdDmSz + `</td>
                                 <td>` + obj.data[i].OdOrdQty + `</td>
                                 <td>
                                     <button type="button" onclick="getDesignDetails(` + parameter_data + `)" class="btn btn-primary btn-sm">View Details </button>
                                 </td>
                             </tr> `;
                    }
                    $('#order-design-table').removeClass("inactive-section")
                    $('#order-design-table-data').html(html_data)
                } else {
                    $('#order-design-table').addClass("inactive-section")
                    new NOTIFY({
                        text: obj.msg,
                        position: 'bottom-right',
                        type: 'danger',
                        autoClose: 3000,
                    });
                }


            },
            error: function(obj) {
                loader.hide()
                var error_msg = ""
                $.each(obj.responseJSON.errors, function(key, val) {
                    error_msg += val[0] + "\n";
                });
                new NOTIFY({
                    text: error_msg,
                    position: 'bottom-right',
                    type: 'danger',
                    autoClose: 3000,
                });

            },
        });
    }

    function getDesignDetails(OdIdNo, OdDmCd, OdCoCd, key) {

        $(".design-tr").removeClass("table-info");
        $("#design-" + key + '-' + OdDmCd).addClass("table-info");

        $.ajax({
            url: '{{  url("/emporer/order-tracking-order-designs-details") }}',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "get",
            data: {
                // "OdTc": OdTc,
                // "OdYy": OdYy,
                // "OdChr": OdChr,
                // "OdNo": OdNo,
                // "OdSr": OdSr,
                "OdIdNo": OdIdNo,
                "OdDmCd": OdDmCd,
                "OdCoCd": OdCoCd
            },
            dataType: "json",
            beforeSend: function(obj) {
              loader.show()
            },
            success: function(obj) {
                loader.hide()
                if (obj.status) {
                    html_data = ""
                    $('#design-code').html("Design : " + OdDmCd)
                    $('#curr_prod').html( obj.data.total_fg_qty + " Pc")
                    $('#remain_prod').html( (obj.data.OdOrdQty - obj.data.total_fg_qty ) + " Pc" )
                    $('#total_prod').html(obj.data.OdOrdQty + " Pc")
                    $('#design_image').attr('src', obj.data.file_url)

                    var progress = 0
                    if(obj.data.OdOrdQty > 0 && obj.data.total_fg_qty > 0) {
                      progress = parseFloat( ( obj.data.total_fg_qty / obj.data.OdOrdQty ) * 100).toFixed(2)
                    }

                    $('#progress_bar').attr('aria-valuenow',   progress)
                    $('#progress_bar').attr('style',  "width: "+ progress + "%")
                    // $('#progress_bar').attr('width',   progress + "%")
                    $('#progress_bar').html( progress + "%"  )
                    $('#order-design-details').removeClass("inactive-section")
                } else {
                    $('#order-design-details').addClass("inactive-section")
                    new NOTIFY({
                        text: obj.msg,
                        position: 'bottom-right',
                        type: 'danger',
                        autoClose: 3000,
                    });
                }


            },
            error: function(obj) {
                loader.hide()
                var error_msg = ""
                $.each(obj.responseJSON.errors, function(key, val) {
                    error_msg += val[0] + "\n";
                });
                new NOTIFY({
                    text: error_msg,
                    position: 'bottom-right',
                    type: 'danger',
                    autoClose: 3000,
                });

            },
        });
    }
    </script>


</body>

</html>
