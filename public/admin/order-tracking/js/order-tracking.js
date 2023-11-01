$("#order_search_form").on("submit", function (e) {
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
        beforeSend: function (obj) {
            // $('#loader').removeClass('hidden')
        },
        success: function (obj) {

            $('#order-design-details').addClass("inactive-section")
            $('#order-design-table').addClass("inactive-section")
            // $('#loader').addClass('hidden')
            if (obj.status) {
                html_data = ""
                for (let i = 0; i < obj.data.length; i++) {
                    id_name = "order-" + obj.data[i].OmTc + '-' + obj.data[i].OmYy + '-' + obj.data[i].OmChr + '-' + obj.data[i].OmNo + '-' + obj.data[i].OmCoCd
                    html_data += '<a href="javascript:void(0)" onclick="getDesignList(\'' + obj.data[i].OmTc + '\', \'' + obj.data[i].OmYy + '\', \'' + obj.data[i].OmChr + '\', \'' + obj.data[i].OmNo + '\', \'' + obj.data[i].OmCoCd + '\', \'' + obj.data[i].order_no + '\')" id="' + id_name + '" class="order-no order-list">' + obj.data[i].order_no + '</a>';
                }
                $('#order-list').removeClass("inactive-section")
                $('#order-list-data').html(html_data)
            } else {
                $('#order-list').addClass("inactive-section")
                $('#order-design-table').addClass("inactive-section")
                new NOTIFY({
                    text: obj.msg,
                    position: 'bottom-right',
                    type: 'danger',
                    autoClose: 3000,
                });
            }


        },
        error: function (obj) {
            // $('#loader').addClass('hidden')
            var error_msg = ""
            $.each(obj.responseJSON.errors, function (key, val) {
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


function getDesignList(OmTc, OmYy, OmChr, OmNo, OmCoCd, order_no) {

    $(".order-list").removeClass("active");
    $("#order-" + OmTc + '-' + OmYy + '-' + OmChr + '-' + OmNo + '-' + OmCoCd).addClass("active");

    $.ajax({
        url: '{{  url("/emporer/order-tracking-order-designs") }}',
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "get",
        data: {
            "OmTc": OmTc,
            "OmYy": OmYy,
            "OmChr": OmChr,
            "OmNo": OmNo,
            "OmCoCd": OmCoCd
        },
        dataType: "json",
        beforeSend: function (obj) {
            // $('#loader').removeClass('hidden')
        },
        success: function (obj) {

            $('#order-design-details').addClass("inactive-section")
            // $('#loader').addClass('hidden')
            if (obj.status) {
                html_data = ""
                for (let i = 0; i < obj.data.length; i++) {
                    parameter_data = "'" + obj.data[i].OdTc + "', '" + obj.data[i].OdYy + "', '" + obj.data[i].OdChr + "', '" + obj.data[i].OdNo + "', '" + obj.data[i].OdSr + "', '";
                    parameter_data += obj.data[i].OdDmCd + "', '" + obj.data[i].OdCoCd + "', '" + (i + 1) + "'";
                    html_data += ` <tr class="design-tr" id="design-` + (i + 1) + `-` + obj.data[i].OdDmCd + `">
                                 <th scope="row">` + (i + 1) + `</th>
                                 <td>` + obj.data[i].OdDmCd + `</td>
                                 <td>` + obj.data[i].category + `</td>
                                 <td>` + obj.data[i].OdDmSz + `</td>
                                 <td>` + obj.data[i].OdOrdQty + `</td>
                                 <td>
                                     <button type="button" onclick="getDesignDetails(` + parameter_data + `)" class="btn btn-primary btn-sm">View Details ></button>
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
        error: function (obj) {
            // $('#loader').addClass('hidden')
            var error_msg = ""
            $.each(obj.responseJSON.errors, function (key, val) {
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

function getDesignDetails(OdTc, OdYy, OdChr, OdNo, OdSr, OdDmCd, OdCoCd, key) {

    $(".design-tr").removeClass("active");
    $("#design-" + key + '-' + OdDmCd).addClass("active");

    $.ajax({
        url: '{{  url("/emporer/order-tracking-order-designs-details") }}',
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "get",
        data: {
            "OdTc": OdTc,
            "OdYy": OdYy,
            "OdChr": OdChr,
            "OdNo": OdNo,
            "OdSr": OdSr,
            "OdDmCd": OdDmCd,
            "OdCoCd": OdCoCd
        },
        dataType: "json",
        beforeSend: function (obj) {
            // $('#loader').removeClass('hidden')
        },
        success: function (obj) {
            // $('#loader').addClass('hidden')
            if (obj.status) {
                html_data = ""
                $('#design_image').attr('src', obj.data.file_url)
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
        error: function (obj) {
            // $('#loader').addClass('hidden')
            var error_msg = ""
            $.each(obj.responseJSON.errors, function (key, val) {
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