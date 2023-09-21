<script>

// last_form_id++

function add_quotation() {
        $.ajax({
              url: '{{  url("quotation/add") }}',
              cache: false,
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
              type: "post",
              data: $('#quotation-form').serialize(),
              dataType: "json",
              success: function(obj){
                 if(obj.status) {
                    $("#quotation-form-id").attr("value", obj.data)
                    alert(obj.msg)
                 }else {
                    alert(obj.msg)
                 }
              },
              error: function(obj){
                 var error_msg = ""
                 $.each(obj.responseJSON.errors, function (key, val) {
                     error_msg +=  val[0] + "\n";
                 });
                 alert(error_msg)

              },
          });
}
    function addDesignForm(last_id)
   {

     if($("#quotation-form-id").val() == 0  || $("#designpost-designheaderid-1").val() == 0  ) {
        alert("Please Save the Quotation Description first.");
        return;
     }

     $.ajax({
               url: '{{  url("quotation/quotation_design_2/addNewDesignFormRow") }}',
               cache: false,
               headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
               type: "post",
               data: {"id":last_id},
               dataType: "json",
               success: function(obj){
                  if(obj.status) {
                     $("#designtable").append(obj.data);
                     selectLib()
                  }else {
                     alert(obj.msg)
                  }

               },
               error: function(obj){
                  var error_msg = ""
                  $.each(obj.responseJSON.errors, function (key, val) {
                      error_msg +=  val[0] + "\n";
                  });
                  alert(error_msg)

               },
           });

           last_form_id++;

}


  function callDuplicateMethod(last_id, last_insert_id)
   {

     if($("#quotation-form-id").val() == 0  || $("#designpost-designheaderid-1").val() == 0  ) {
        alert("Please Save the Quotation Details & Description first.");
        return;
     }

     $.ajax({
               url: '{{  url("quotation/quotation_design_2/duplicateNewDesignFormRow") }}',
               cache: false,
               headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
               type: "post",
               data: {"id":last_id, "last_insert_id": last_insert_id},
               dataType: "json",
               success: function(obj){
                  if(obj.status) {
                     $("#designtable").append(obj.data);
                     selectLib()
                     zoomImages();
                  }else {
                     alert(obj.msg)
                  }

               },
               error: function(obj){
                  var error_msg = ""
                  $.each(obj.responseJSON.errors, function (key, val) {
                      error_msg +=  val[0] + "\n";
                  });
                  alert(error_msg)

               },
           });

           last_form_id++;

}

function addMoreData(id) {
     var current_row = $("#designpost-current_row-"+id).val();
     current_row = parseInt(current_row);
   $.ajax({
               url: '{{  url("quotation/quotation_design_2/addMoreData") }}',
               cache: false,
               headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
               type: "post",
               data: {"row_id":id, "current_row":current_row+1},
               dataType: "json",
               success: function(obj){
                  if(obj.status) {

                     $("#designpost-last-row-"+id).before(obj.data)
                     $(".designpost-tbody-class-"+id).attr("rowspan", current_row+1)
                     $("#designpost-current_row-"+id).attr("value", current_row+1)
                     selectLib()
                  }else {
                     alert(obj.msg)
                  }
               },
               error: function(obj){
                  var error_msg = ""
                  $.each(obj.responseJSON.errors, function (key, val) {
                      error_msg +=  val[0] + "\n";
                  });
                  alert(error_msg)

               },
           });
  }


function duplicateData(id, i) {
     var current_row = $("#designpost-current_row-"+id).val();
     current_row = parseInt(current_row);
     var formData = new FormData();


      formData.append('row_id', id);
      formData.append('current_row', current_row);
      formData.append('table_id[]', $('#designpost-'+id+'-row-table_id-'+i+'').val());
      formData.append('silver_act_wt[]', $('#designpost-'+id+'-row-silver_act_wt-'+i+'').val());
      formData.append('silver_add_wt[]', $('#designpost-'+id+'-row-silver_add_wt-'+i+'').val());
      formData.append('silver_wt[]', $('#designpost-'+id+'-row-silver_wt-'+i+'').val());
      formData.append('stone_wt[]', $('#designpost-'+id+'-row-stone_wt-'+i+'').val());
      formData.append('stone_diamond_name[]', $('#designpost-'+id+'-row-stone_diamond_name-'+i+'').val());
      formData.append('stone_diamond_shape[]', $('#designpost-'+id+'-row-stone_diamond_shape-'+i+'').val());
      formData.append('stone_diamond_size[]', $('#designpost-'+id+'-row-stone_diamond_size-'+i+'').val());
      formData.append('stone_diamond_qty[]', $('#designpost-'+id+'-row-stone_diamond_qty-'+i+'').val());
      formData.append('stone_diamond_weight[]', $('#designpost-'+id+'-row-stone_diamond_weight-'+i+'').val());
      formData.append('stone_diamond_price[]', $('#designpost-'+id+'-row-stone_diamond_price-'+i+'').val());
      formData.append('stone_diamond_inc_margin[]', $('#designpost-'+id+'-row-stone_diamond_inc_margin-'+i+'').val());
      formData.append('stone_diamond_amt[]', $('#designpost-'+id+'-row-stone_diamond_amt-'+i+'').val());
      formData.append('silver_amt[]', $('#designpost-'+id+'-row-silver_amt-'+i+'').val());
      formData.append('labour_charge[]', $('#designpost-'+id+'-row-labour_charge-'+i+'').val());
      formData.append('labour[]', $('#designpost-'+id+'-row-labour-'+i+'').val());
      formData.append('setting[]', $('#designpost-'+id+'-row-setting-'+i+'').val());
      formData.append('misc_item[]', $('#designpost-'+id+'-row-misc_item-'+i+'').val());
      formData.append('misc_cost[]', $('#designpost-'+id+'-row-misc_cost-'+i+'').val());
      formData.append('plating_gp[]', $('#designpost-'+id+'-row-plating_gp-'+i+'').val());
      formData.append('plating_rp[]', $('#designpost-'+id+'-row-plating_rp-'+i+'').val());
      formData.append('total_cost_ss[]', $('#designpost-'+id+'-row-total_cost_ss-'+i+'').val());
      formData.append('total_cost_gp[]', $('#designpost-'+id+'-row-total_cost_gp-'+i+'').val());
      formData.append('total_cost_rp[]', $('#designpost-'+id+'-row-total_cost_rp-'+i+'').val());
      formData.append('finding_charge[]', $('#designpost-'+id+'-row-finding_charge-'+i+'').val());
      formData.append('value_add_per[]', $('#designpost-'+id+'-row-value_add_per-'+i+'').val());
      formData.append('value_addition_ss[]', $('#designpost-'+id+'-row-value_addition_ss-'+i+'').val());
      formData.append('value_addition_gp[]', $('#designpost-'+id+'-row-value_addition_gp-'+i+'').val());
      formData.append('value_addition_rp[]', $('#designpost-'+id+'-row-value_addition_rp-'+i+'').val());
      formData.append('sale_price_ss[]', $('#designpost-'+id+'-row-sale_price_ss-'+i+'').val());
      formData.append('sale_price_gp[]', $('#designpost-'+id+'-row-sale_price_gp-'+i+'').val());
      formData.append('sale_price_rp[]', $('#designpost-'+id+'-row-sale_price_rp-'+i+'').val());
      formData.append('cost_change_1[]', $('#designpost-'+id+'-row-cost_change_1-'+i+'').val());
      formData.append('cost_change_2[]', $('#designpost-'+id+'-row-cost_change_2-'+i+'').val());
      formData.append('cost_change_3[]', $('#designpost-'+id+'-row-cost_change_3-'+i+'').val());


   $.ajax({
               url: '{{  url("quotation/quotation_design_2/duplicateMoreData") }}',
               cache: false,
               headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
              type: "post",
              data: formData,
              dataType: "json",
              processData: false,
              contentType: false,
               success: function(obj){
                  if(obj.status) {

                     $("#designpost-last-row-"+id).before(obj.data)
                     $(".designpost-tbody-class-"+id).attr("rowspan", current_row+1)
                     $("#designpost-current_row-"+id).attr("value", current_row+1)

                     selectLib()
                  }else {
                     alert(obj.msg)
                  }
               },
               error: function(obj){
                  var error_msg = ""
                  $.each(obj.responseJSON.errors, function (key, val) {
                      error_msg +=  val[0] + "\n";
                  });
                  alert(error_msg)

               },
           });
  }


  function editform(id, form_type)
     {
        if($("#quotation-form-id").val() == 0) {
           alert("Please Save the quotation form first.");
           return;
        }

        var formData = new FormData();
         formData.append('id', $("#designpost-id-"+id).val());
         formData.append('quotation_table_id', $("#quotation-form-id").val());
         // if($('#designpost-image-'+id)[0].files.length > 0) {
         //   formData.append('image', $('#designpost-image-'+id)[0].files[0]);
         // }
         formData.append('image', $('#designpost-image-'+id).val());
         formData.append('image_type', $('#designpost-image_type-'+id).val());
         formData.append('design', $('#designpost-design-'+id).val());
         formData.append('current_row', $("#designpost-current_row-"+id).val());
         var current_row_of_id = parseInt($("#designpost-current_row-"+id).val())
         for(let i=0; i<=current_row_of_id; i++) {
           if($('#designpost-'+id+'-row-silver_wt-'+i+'').val() == undefined ) {
              continue;
           }
           else {
              formData.append('table_id[]', $('#designpost-'+id+'-row-table_id-'+i+'').val());
              formData.append('silver_act_wt[]', $('#designpost-'+id+'-row-silver_act_wt-'+i+'').val());
              formData.append('silver_add_wt[]', $('#designpost-'+id+'-row-silver_add_wt-'+i+'').val());
              formData.append('silver_wt[]', $('#designpost-'+id+'-row-silver_wt-'+i+'').val());
              formData.append('stone_wt[]', $('#designpost-'+id+'-row-stone_wt-'+i+'').val());
              formData.append('stone_diamond_name[]', $('#designpost-'+id+'-row-stone_diamond_name-'+i+'').val());
              formData.append('stone_diamond_shape[]', $('#designpost-'+id+'-row-stone_diamond_shape-'+i+'').val());
              formData.append('stone_diamond_size[]', $('#designpost-'+id+'-row-stone_diamond_size-'+i+'').val());
              formData.append('stone_diamond_qty[]', $('#designpost-'+id+'-row-stone_diamond_qty-'+i+'').val());
              formData.append('stone_diamond_weight[]', $('#designpost-'+id+'-row-stone_diamond_weight-'+i+'').val());
              formData.append('stone_diamond_price[]', $('#designpost-'+id+'-row-stone_diamond_price-'+i+'').val());
              formData.append('stone_diamond_inc_margin[]', $('#designpost-'+id+'-row-stone_diamond_inc_margin-'+i+'').val());
              formData.append('stone_diamond_amt[]', $('#designpost-'+id+'-row-stone_diamond_amt-'+i+'').val());
              formData.append('silver_amt[]', $('#designpost-'+id+'-row-silver_amt-'+i+'').val());
              formData.append('labour_charge[]', $('#designpost-'+id+'-row-labour_charge-'+i+'').val());
              formData.append('labour[]', $('#designpost-'+id+'-row-labour-'+i+'').val());
              formData.append('setting[]', $('#designpost-'+id+'-row-setting-'+i+'').val());
              formData.append('misc_item[]', $('#designpost-'+id+'-row-misc_item-'+i+'').val());
              formData.append('misc_cost[]', $('#designpost-'+id+'-row-misc_cost-'+i+'').val());
              formData.append('plating_gp[]', $('#designpost-'+id+'-row-plating_gp-'+i+'').val());
              formData.append('plating_rp[]', $('#designpost-'+id+'-row-plating_rp-'+i+'').val());
              formData.append('total_cost_ss[]', $('#designpost-'+id+'-row-total_cost_ss-'+i+'').val());
              formData.append('total_cost_gp[]', $('#designpost-'+id+'-row-total_cost_gp-'+i+'').val());
              formData.append('total_cost_rp[]', $('#designpost-'+id+'-row-total_cost_rp-'+i+'').val());
              formData.append('finding_charge[]', $('#designpost-'+id+'-row-finding_charge-'+i+'').val());
              formData.append('value_add_per[]', $('#designpost-'+id+'-row-value_add_per-'+i+'').val());
              formData.append('value_addition_ss[]', $('#designpost-'+id+'-row-value_addition_ss-'+i+'').val());
              formData.append('value_addition_gp[]', $('#designpost-'+id+'-row-value_addition_gp-'+i+'').val());
              formData.append('value_addition_rp[]', $('#designpost-'+id+'-row-value_addition_rp-'+i+'').val());
              formData.append('sale_price_ss[]', $('#designpost-'+id+'-row-sale_price_ss-'+i+'').val());
              formData.append('sale_price_gp[]', $('#designpost-'+id+'-row-sale_price_gp-'+i+'').val());
              formData.append('sale_price_rp[]', $('#designpost-'+id+'-row-sale_price_rp-'+i+'').val());
              formData.append('cost_change_1[]', $('#designpost-'+id+'-row-cost_change_1-'+i+'').val());
              formData.append('cost_change_2[]', $('#designpost-'+id+'-row-cost_change_2-'+i+'').val());
              formData.append('cost_change_3[]', $('#designpost-'+id+'-row-cost_change_3-'+i+'').val());
          }
        }
              $.ajax({
                 url: '{{  url("quotation/quotation_design_2/update") }}',
                 cache: false,
                 headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                 type: "post",
                 data: formData,
                 dataType: "json",
                 processData: false,
                 contentType: false,
                 success: function(obj){
                    if(obj.status) {
                       $("#designpost-id-"+id).attr("value", obj.data)

                       if(form_type == 'duplicate') {
                          callDuplicateMethod(last_form_id+1, $("#designpost-id-"+id).val())
                       } else {
                         alert(obj.msg)
                       }

                    }else {
                       alert(obj.msg)
                    }
                 },
                 error: function(obj){
                    var error_msg = ""
                    $.each(obj.responseJSON.errors, function (key, val) {
                        error_msg +=  val[0] + "\n";
                    });
                    alert(error_msg)
                 },
              });
     }

    function editdesignhead()
    {
             if($("#quotation-form-id").val() == 0) {
                alert("Please Save the quotation form first.");
                return;
             }

             var formData = new FormData();
              formData.append('id', $("#designpost-designheaderid-1").val());
              formData.append('quotation_table_id', $("#quotation-form-id").val());
              formData.append('sliver_us_rate', $('#designpost-sliver_us_rate-1').val());
              formData.append('sliver_inr_rate', $('#designpost-sliver_inr_rate-1').val());
              formData.append('currency_exchange_rate', $('#designpost-currency_exchange_rate-1').val());
              formData.append('gold_us_rate', $('#designpost-gold_us_rate-1').val());
              formData.append('silver_loss', $('#designpost-silver_loss-1').val());
              formData.append('gold_18k', $('#designpost-gold_18k-1').val());
              formData.append('gold_24k', $('#designpost-gold_24k-1').val());

                   $.ajax({
                      url: '{{  url("quotation/quotation_design_2/header_update") }}',
                      cache: false,
                      headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         },
                      type: "post",
                      data: formData,
                      dataType: "json",
                      processData: false,
                      contentType: false,
                      success: function(obj){
                         if(obj.status) {
                            $("#designpost-designheaderid-1").attr("value", obj.data)
                            alert(obj.msg)
                         }else {
                            alert(obj.msg)
                         }
                      },
                      error: function(obj){
                         var error_msg = ""
                         $.each(obj.responseJSON.errors, function (key, val) {
                             error_msg +=  val[0] + "\n";
                         });
                         alert(error_msg)
                      },
                   });
    }


   function deleteMoreRowData(row_id, more_data_id) {
      $("#designpost-"+row_id+"-row-id-"+more_data_id).remove();

      var current_row_of_id = parseInt($("#designpost-current_row-"+row_id).val())
      current_row_of_id = current_row_of_id  - 1;
      $("#designpost-current_row-"+row_id).attr("value", current_row_of_id)
   }

   function showConfirmDialog(row_id) {
      $("#deleteForm-button").attr("onclick", "deleteForm("+row_id+")")
      $("#confirmModal").modal("show")
   }

   function deleteForm(id)
   {
      if($("#designpost-id-"+id).val() == 0) {
         $("#designpost-tbody-"+id).remove();
         $("#confirmModal").modal("hide")
      }
      else {
         $.ajax({
              url: '{{  url("quotation/quotation_design_2/delete") }}',
              cache: false,
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
              type: "post",
              data: {"design_id": $("#designpost-id-"+id).val() },
              dataType: "json",
              success: function(obj){
                var html_data = ""
                 if(obj.status) {
                  $("#designpost-tbody-"+id).remove();
                  $("#confirmModal").modal("hide")
                 }else {
                    alert(obj.msg)
                 }
              },
              error: function(obj){
                 var error_msg = ""
                 $.each(obj.responseJSON.errors, function (key, val) {
                     error_msg +=  val[0] + "\n";
                 });
                 alert(error_msg)
              },
          });
      }
   }


   function checkValue(value) {
    var check = false;
      // console.log('parseFloat(value) : ' + parseFloat(value));
      // console.log("value : " + value);
      if(parseFloat(value) == NaN || parseFloat(value) <= 0  ||  value <= 0 || value == "") {
      // if(parseFloat(value) == NaN || parseFloat(value) <= 0  ) {
        check = false;
        // console.log("check  22: " + check);
      }
      else {
        check = true;
        // console.log("check 11: " + check);
      }
      // console.log("check : " + check);
      return check;
  }


  function performCalculation(current_section, each_row) {

    if(checkValue($("#designpost-"+current_section+"-row-silver_act_wt-"+each_row).val()) == 0 ) {
      // alert("Stone/Diamond Price should be number only.")
      return;
    }
    if(checkValue($("#designpost-"+current_section+"-row-silver_add_wt-"+each_row).val()) == 0 ) {
      // alert("Stone/Diamond Price should be number only.")
      return;
    }
    var silver_act_wt = $("#designpost-"+current_section+"-row-silver_act_wt-"+each_row).val();
    var silver_add_wt = $("#designpost-"+current_section+"-row-silver_add_wt-"+each_row).val();
    // calculation ----------------
    var silver_wt = parseFloat(silver_act_wt) * parseFloat(silver_add_wt);
    $("#designpost-"+current_section+"-row-silver_wt-"+each_row).val(silver_wt.toFixed(2))

    if(checkValue($("#designpost-"+current_section+"-row-stone_diamond_price-"+each_row).val()) == 0 ) {
      // alert("Stone/Diamond Price should be number only.")
      return;
    }
    var stone_diamond_price = $("#designpost-"+current_section+"-row-stone_diamond_price-"+each_row).val();
    // calculation ----------------
    var stone_diamond_inc_margin = parseFloat(stone_diamond_price) * 2;
    $("#designpost-"+current_section+"-row-stone_diamond_inc_margin-"+each_row).val(stone_diamond_inc_margin.toFixed(2))

    if(checkValue($("#designpost-"+current_section+"-row-stone_diamond_weight-"+each_row).val()) == 0 ) {
      // alert("Stone/Diamond Weight should be number only.")
      return;
    }
    if(checkValue($("#designpost-currency_exchange_rate-1").val()) == 0 ) {
      // alert("Currency Exchange Rate should be number only.")
      return;
    }
    var stone_diamond_weight = $("#designpost-"+current_section+"-row-stone_diamond_weight-"+each_row).val();
    var currency_exchange_rate = $("#designpost-currency_exchange_rate-1").val();
    // calculation ----------------
    var stone_diamond_amt = ( parseFloat(stone_diamond_weight) * stone_diamond_inc_margin ) / parseFloat(currency_exchange_rate) ;
    $("#designpost-"+current_section+"-row-stone_diamond_amt-"+each_row).val(stone_diamond_amt.toFixed(2))

    if(checkValue($("#designpost-"+current_section+"-row-silver_wt-"+each_row).val()) == 0 ) {
      // alert("Silver Weight should be number only.")
      return;
    }
    if(checkValue($("#designpost-silver_loss-1").val()) == 0 ) {
      // alert("Currency Exchange Rate should be number only.")
      return;
    }
    var silver_wt = $("#designpost-"+current_section+"-row-silver_wt-"+each_row).val()
    var silver_loss = $("#designpost-silver_loss-1").val();
    // calculation ----------------
    var silver_amt = ( parseFloat(silver_wt) * parseFloat(silver_loss) );
    $("#designpost-"+current_section+"-row-silver_amt-"+each_row).val(silver_amt.toFixed(2))

    if(checkValue($("#designpost-"+current_section+"-row-labour_charge-"+each_row).val()) == 0 ) {
      // alert("Silver Weight should be number only.")
      return;
    }
    var labour_charge = $("#designpost-"+current_section+"-row-labour_charge-"+each_row).val()
    // calculation ----------------
    var labour = ( parseFloat(labour_charge) * parseFloat(silver_wt) ) / parseFloat(currency_exchange_rate);
    $("#designpost-"+current_section+"-row-labour-"+each_row).val(labour.toFixed(2))

    // new changes-----------------------------------
    // if(checkValue($("#designpost-"+current_section+"-row-labour-"+each_row).val()) == 0 ) {
    //   // alert("Stone/Diamond Quantity should be number only.")
    //   return;
    // }
    // var labour = $("#designpost-"+current_section+"-row-labour-"+each_row).val();

    if(checkValue($("#designpost-"+current_section+"-row-stone_diamond_qty-"+each_row).val()) == 0 ) {
      // alert("Stone/Diamond Quantity should be number only.")
      return;
    }
    var stone_diamond_qty = $("#designpost-"+current_section+"-row-stone_diamond_qty-"+each_row).val()
    // calculation ----------------
    var setting = ( 20 * parseFloat(stone_diamond_qty) ) / parseFloat(currency_exchange_rate);
    $("#designpost-"+current_section+"-row-setting-"+each_row).val(setting.toFixed(2))

    // calculation ----------------
    var misc_cost = ( 10 / parseFloat(currency_exchange_rate) ) + 0.05 ;
    $("#designpost-"+current_section+"-row-misc_cost-"+each_row).val(misc_cost.toFixed(2))

    // calculation ----------------
    var plating_gp =  1.97 * parseFloat(silver_wt) ;
    $("#designpost-"+current_section+"-row-plating_gp-"+each_row).val(plating_gp.toFixed(2))

    // calculation ----------------
    var plating_rp =  1.97 * parseFloat(silver_wt) ;
    $("#designpost-"+current_section+"-row-plating_rp-"+each_row).val(plating_rp.toFixed(2))

    // calculation ----------------
    var total_cost_ss =  parseFloat(silver_amt) + parseFloat(labour) + parseFloat(setting) + parseFloat(misc_cost) ;
    $("#designpost-"+current_section+"-row-total_cost_ss-"+each_row).val(total_cost_ss.toFixed(2))

    // calculation ----------------
    var total_cost_gp =  parseFloat(silver_amt) + parseFloat(labour) + parseFloat(setting) + parseFloat(misc_cost) ;
    $("#designpost-"+current_section+"-row-total_cost_gp-"+each_row).val(total_cost_gp.toFixed(2))

    // calculation ----------------
    var total_cost_rp =  parseFloat(silver_amt) + parseFloat(labour) + parseFloat(setting) + parseFloat(misc_cost) ;
    $("#designpost-"+current_section+"-row-total_cost_rp-"+each_row).val(total_cost_rp.toFixed(2))

    // if(checkValue($("#designpost-"+current_section+"-row-finding_charge-"+each_row).val()) == 0 ) {
    //   // alert("Stone/Diamond Quantity should be number only.")
    //   return;
    // }
    if(checkValue($("#designpost-"+current_section+"-row-value_add_per-"+each_row).val()) == 0 ) {
      // alert("Stone/Diamond Quantity should be number only.")
      return;
    }
    var finding_charge = $("#designpost-"+current_section+"-row-finding_charge-"+each_row).val()
    var value_add_per = $("#designpost-"+current_section+"-row-value_add_per-"+each_row).val()
    // calculation ----------------
    var value_addition_ss = ( parseFloat(total_cost_ss)  * parseFloat( parseFloat(value_add_per) / 100 ) ) +  parseFloat(stone_diamond_amt) + parseFloat(finding_charge);
    $("#designpost-"+current_section+"-row-value_addition_ss-"+each_row).val(value_addition_ss.toFixed(2))

    // calculation ----------------
    var value_addition_gp = ( parseFloat(total_cost_gp)  * parseFloat( parseFloat(value_add_per) / 100 ) ) + parseFloat(plating_gp) +  parseFloat(stone_diamond_amt) + parseFloat(finding_charge);
    $("#designpost-"+current_section+"-row-value_addition_gp-"+each_row).val(value_addition_gp.toFixed(2))

    // calculation ----------------
    var value_addition_rp = ( parseFloat(total_cost_rp)  * parseFloat( parseFloat(value_add_per) / 100 ) ) + parseFloat(plating_rp) +  parseFloat(stone_diamond_amt) + parseFloat(finding_charge) ;
    $("#designpost-"+current_section+"-row-value_addition_rp-"+each_row).val(value_addition_rp.toFixed(2))

    // // new changes-----------------------------------
    // if(checkValue($("#designpost-"+current_section+"-row-value_addition_ss-"+each_row).val()) == 0 ) {
    //   // alert("Stone/Diamond Quantity should be number only.")
    //   return;
    // }
    // var value_addition_ss = $("#designpost-"+current_section+"-row-value_addition_ss-"+each_row).val();
    //
    // if(checkValue($("#designpost-"+current_section+"-row-value_addition_gp-"+each_row).val()) == 0 ) {
    //   // alert("Stone/Diamond Quantity should be number only.")
    //   return;
    // }
    // var value_addition_gp = $("#designpost-"+current_section+"-row-value_addition_gp-"+each_row).val();
    //
    // if(checkValue($("#designpost-"+current_section+"-row-value_addition_rp-"+each_row).val()) == 0 ) {
    //   // alert("Stone/Diamond Quantity should be number only.")
    //   return;
    // }
    // var value_addition_rp = $("#designpost-"+current_section+"-row-value_addition_rp-"+each_row).val();

    // calculation ----------------
    var sale_price_ss = parseFloat(value_addition_ss) +  parseFloat(total_cost_ss);
    $("#designpost-"+current_section+"-row-sale_price_ss-"+each_row).val(sale_price_ss.toFixed(2))

    // calculation ----------------
    var sale_price_gp = parseFloat(value_addition_gp) +  parseFloat(total_cost_gp);
    $("#designpost-"+current_section+"-row-sale_price_gp-"+each_row).val(sale_price_gp.toFixed(2))

    // calculation ----------------
    var sale_price_rp = parseFloat(value_addition_rp) +  parseFloat(total_cost_rp);
    // console.log(sale_price_rp.toFixed(2));
    // console.log(sale_price_rp);
    $("#designpost-"+current_section+"-row-sale_price_rp-"+each_row).val(sale_price_rp.toFixed(2))

    // calculation ----------------
    var sale_price_rp = parseFloat(value_addition_rp) +  parseFloat(total_cost_rp);
    $("#designpost-"+current_section+"-row-sale_price_rp-"+each_row).val(sale_price_rp.toFixed(2))

    var cost_change_1 =  parseFloat(sale_price_rp)
    $("#designpost-"+current_section+"-row-cost_change_1-"+each_row).val(cost_change_1.toFixed(2))

    // if(checkValue($("#designpost-"+current_section+"-row-cost_change_1-"+each_row).val()) == 0 ) {
    //   // alert("Cost Change should be number only.")
    //   return;
    // }
    // var cost_change_1 = $("#designpost-"+current_section+"-row-cost_change_1-"+each_row).val()


    // calculation ----------------
    var cost_change_2 = parseFloat(cost_change_1) -  parseFloat(sale_price_rp);
    $("#designpost-"+current_section+"-row-cost_change_2-"+each_row).val(cost_change_2.toFixed(2))

    // calculation ----------------
    var cost_change_3 = cost_change_2 / 10 ;
    $("#designpost-"+current_section+"-row-cost_change_3-"+each_row).val(cost_change_3.toFixed(2))
  }

function performHeaderCalculation() {
  if(checkValue($("#designpost-sliver_us_rate-1").val()) == 0 ) {
    // alert("Currency Exchange Rate should be number only.")
    return;
  }
  var sliver_us_rate = $("#designpost-sliver_us_rate-1").val()
  var sliver_inr_rate = parseFloat(sliver_us_rate) / 31.1;
  $("#designpost-sliver_inr_rate-1").val(sliver_inr_rate.toFixed(4))

  var silver_loss = parseFloat(sliver_inr_rate)  + ( parseFloat(sliver_inr_rate) * 0.15 );
  $("#designpost-silver_loss-1").val(silver_loss.toFixed(4))

  performAllCalculation()
}


function performAllCalculation() {

   for(let j=0; j<$(".section_id-class").length; j++)
   {
      var id = $(".section_id-class")[j].defaultValue;
      var current_row_of_id = parseInt($("#designpost-current_row-"+id).val())
         for(let i=0; i<=current_row_of_id; i++) {
           if($('#designpost-'+id+'-row-silver_wt-'+i+'').val() == undefined ) {
              continue;
           }
           else {
             performCalculation(id, i)
           }
         }
   }

}


</script>
