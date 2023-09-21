<script>
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
                  beforeSend: function (obj) {
                    $('#loader').removeClass('hidden')
                  },
                  success: function(obj){
                    $('#loader').addClass('hidden')
                     if(obj.status) {
                        $("#quotation-form-id").val(obj.data)
                        $("#quotation-form-name").val(obj.data)
                        // alert(obj.msg)

                        editdesignhead()

                     }else {
                        alert(obj.msg)
                     }


                  },
                  error: function(obj){
                    $('#loader').addClass('hidden')
                     var error_msg = ""
                     $.each(obj.responseJSON.errors, function (key, val) {
                         error_msg +=  val[0] + "\n";
                     });
                     alert(error_msg)

                  },
              });
   }


   function addMoreData(this_instance, id) {
     var current_row = $("#designpost-current_row-"+id).val();
     current_row = parseInt(current_row);
     $.ajax({
               url: '{{  url("quotation/quotation_design_1/addMoreData") }}',
               cache: false,
               headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
               type: "post",
               data: {"row_id":id, "current_row":current_row+1},
               dataType: "json",
               beforeSend: function (obj) {
                 $('#loader').removeClass('hidden')
               },
               success: function(obj){
                 $('#loader').addClass('hidden')

                  if(obj.status) {

                     // $("#designpost-labor-table-tbody-"+id).append(obj.data)
                     //
                     // $(".designpost-tbody-class-"+id).attr("rowspan", current_row+1)
                     // $("#designpost-current_row-"+id).attr("value", current_row+1)

                     // var parent_tbody =  $(this_instance).parent().parent().parent().parent()
                     // $(parent_tbody).append(obj.data)

                     var parent_tbody =  $(this_instance).parent().parent().parent()
                     $(parent_tbody).after(obj.data)

                     // var parent_tbody =  $(this_instance).parent().parent().parent().parent()
                     // $(parent_tbody).append(obj.data)

                     selectLib()

                     labour_type_select2();
                     setting_charge_select2();

                     // plating_type_select2();
                     plating_casting_select2();
                     plating_chains_select2();

                     // updateRowNoOnTable(parent_tbody)
                     updateRowNoOnTable($(parent_tbody).parent())

                  }else {
                     alert(obj.msg)
                  }



               },
               error: function(obj){
                 $('#loader').addClass('hidden')
                  var error_msg = ""
                  $.each(obj.responseJSON.errors, function (key, val) {
                      error_msg +=  val[0] + "\n";
                  });
                  alert(error_msg)


               },
      });
  }


   function addMoreData2(this_instance, id, method_type) {
     var current_row = $("#designpost-current_row-"+id).val();

     var formData = new FormData();
    formData.append('row_id', id);
    formData.append('current_row', current_row+1 );
    formData.append('method_type', method_type );

    if(method_type == 'add_first') {
      // it will work as Add
      formData.append('method_type', 'add' );
    }


    if(method_type == 'duplicate') {

      var inner_tr = $(this_instance).parent().parent().parent();
      for (let j = 0; j < $(inner_tr).children().length; j++) {
        var inner_td = $(inner_tr).children()[j]
        if($(inner_td).children().length == 0) {
          continue;
        }
        var inner_input = $(inner_td).children()[0]
        if( $(inner_input).attr('name') == "stone_name" ) {
          formData.append('stone_name', checkNullValue($(inner_input).val()) );
        }
        if( $(inner_input).attr('name') == "stone_cut" ) {
          formData.append('stone_cut', checkNullValue($(inner_input).val()) ) ;
        }
        if( $(inner_input).attr('name') == "stone_shape" ) {
          formData.append('stone_shape', checkNullValue($(inner_input).val()) );
        }
        if( $(inner_input).attr('name') == "stone_size_l" ) {
          formData.append('stone_size_l', checkNullValue($(inner_input).val()) );
        }
        if( $(inner_input).attr('name') == "stone_size_w" ) {
          formData.append('stone_size_w', checkNullValue($(inner_input).val()) );
        }
        if( $(inner_input).attr('name') == "stone_diamond_quality" ) {
          formData.append('stone_diamond_quality', checkNullValue($(inner_input).val()) );
        }
        if( $(inner_input).attr('name') == "setting_type" ) {
          formData.append('setting_type', checkNullValue($(inner_input).val()) );
        }
        if( $(inner_input).attr('name') == "price_unit" ) {
          formData.append('price_unit', checkNullValue($(inner_input).val()) );
        }
        if( $(inner_input).attr('name') == "stone_qty" ) {
          formData.append('stone_qty', checkNullValue($(inner_input).val()) );
        }
        if( $(inner_input).attr('name') == "stone_weight" ) {
          formData.append('stone_weight', checkNullValue($(inner_input).val()) );
        }
        if( $(inner_input).attr('name') == "stone_value" ) {
          formData.append('stone_value', checkNullValue($(inner_input).val()) );
        }
        if( $(inner_input).attr('name') == "value_added_per" ) {
          formData.append('value_added_per', checkNullValue($(inner_input).val()) );
        }
        if( $(inner_input).attr('name') == "stone_value_added" ) {
          formData.append('stone_value_added', checkNullValue($(inner_input).val()) );
        }
        if( $(inner_input).attr('name') == "sale_price" ) {
          formData.append('sale_price', checkNullValue($(inner_input).val()) );
        }
      }
    }





     $.ajax({
               url: '{{  url("quotation/quotation_design_1/addMoreData2") }}',
               cache: false,
               headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
               type: "post",
               data: formData,
               dataType: "json",
               processData: false,
               contentType: false,
               beforeSend: function (obj) {
                 $('#loader').removeClass('hidden')
               },
               success: function(obj){
                 $('#loader').addClass('hidden')
                  if(obj.status) {

                    if(method_type == 'add_first') {
                      // first element will add by ID
                      // var parent_tbody =  $(this_instance).parent().parent().parent()
                      $("#designpost-stone-table-tbody-"+id).append(obj.data)
                    }
                    else {
                      // other element will add by 'this' instance
                      var parent_tbody =  $(this_instance).parent().parent().parent()
                      $(parent_tbody).after(obj.data)
                    }



                     selectLib()

                     stone_name_select2();
                     stone_cut_select2();
                     stone_shape_select2();
                     stone_size_l_select2();
                     stone_size_w_select2();
                     stone_diamond_quality_select2();
                     setting_type_select2();
                     price_unit_select2();

                     // updateRowNoOnTable(parent_tbody)
                     updateRowNoOnTable($(parent_tbody).parent())

                     if(method_type == 'duplicate') {
                        performCalculation(id)
                     }

                  }else {
                     alert(obj.msg)
                  }



               },
               error: function(obj){
                 $('#loader').addClass('hidden')
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
        alert("Please Save the Description first.");
        return;
     }

     $.ajax({
               url: '{{  url("quotation/quotation_design_1/addNewDesignFormRow") }}',
               cache: false,
               headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
               type: "post",
               data: {"id":last_id},
               dataType: "json",
               beforeSend: function (obj) {
                 $('#loader').removeClass('hidden')
               },
               success: function(obj){
                  if(obj.status) {
                     $("#designtable").append(obj.data);

                     selectLib()

                     product_type_select2();
                     metal_type_select2();
                     metal_name_select2();
                     labour_type_select2();
                     setting_charge_select2();

                     // plating_type_select2();
                     plating_casting_select2();
                     plating_chains_select2();

                     stone_name_select2();
                     stone_cut_select2();
                     stone_shape_select2();
                     stone_size_l_select2();
                     stone_size_w_select2();
                     stone_diamond_quality_select2();
                     setting_type_select2();
                     price_unit_select2();


                     updateRowNoMainTable()

                  }else {
                     alert(obj.msg)
                  }

                    $('#loader').addClass('hidden')
               },
               error: function(obj){
                  var error_msg = ""
                  $.each(obj.responseJSON.errors, function (key, val) {
                      error_msg +=  val[0] + "\n";
                  });
                  alert(error_msg)

                  $('#loader').addClass('hidden')
               },
           });
           last_form_id++;
   }



   function editform(this_instance, id, form_type)
   {

      var formData = new FormData();
       formData.append('id', $("#designpost-id-"+id).val());
       formData.append('row_no', $("#designpost-row_no-"+id).val());
       formData.append('current_row_no', $("#designpost-current_row_no-"+id).val());
       formData.append('quotation_table_id', $("#quotation-form-id").val());
       formData.append('image', $('#designpost-image-'+id).val());
       formData.append('image_type', $('#designpost-image_type-'+id).val());

       formData.append('product_type', checkNullValue($('#designpost-product_type-'+id).val()) );
       formData.append('product_code', $('#designpost-product_code-'+id).val());
       formData.append('their_code', $('#designpost-their_code-'+id).val());
       formData.append('metal_type', checkNullValue($('#designpost-metal_type-'+id).val()) );
       formData.append('metal', checkNullValue($('#designpost-metal-'+id).val()) );
       formData.append('metal_weight_casting', checkNullValue($('#designpost-metal_weight_casting-'+id).val() ) );
       formData.append('metal_weight_chain', checkNullValue($('#designpost-metal_weight_chain-'+id).val() ));
       formData.append('value_of_metal', $('#designpost-value_of_metal-'+id).val() );

       formData.append('cost_1', $('#designpost-cost_1-'+id).val());
       formData.append('cost_2', $('#designpost-cost_1-'+id).val());
       formData.append('value_addition_cost_1', $('#designpost-value_addition_cost_1-'+id).val());
       formData.append('ex_factory_price', $('#designpost-ex_factory_price-'+id).val());
       formData.append('discount_per', checkNullValue( $('#designpost-discount_per-'+id).val() ) );
       formData.append('price_after_discount', checkNullValue( $('#designpost-price_after_discount-'+id).val() ) );
       // formData.append('stone_quoatrion_price', $('#designpost-stone_quoatrion_price-'+id).val());
       // formData.append('sale_price', $('#designpost-sale_price-'+id).val());


       formData.append('labour_value_cfp', checkNullValue( $("#designpost-"+id+"-row-labour_value_cfp").val() ) );
       formData.append('labour_value_chain_labour', checkNullValue( $("#designpost-"+id+"-row-labour_value_chain_labour").val() ) );
       formData.append('labour_value_total_setting', checkNullValue( $("#designpost-"+id+"-row-labour_value_total_setting").val() ) );
       formData.append('labour_value_finding', checkNullValue( $("#designpost-"+id+"-row-labour_value_finding").val() ) );
       formData.append('labour_value_packing', checkNullValue( $("#designpost-"+id+"-row-labour_value_packing").val() ) );
       formData.append('labour_value_plating_casting', checkNullValue($("#designpost-"+id+"-row-labour_value_plating_casting").val() ) );
       formData.append('labour_value_plating_chains', checkNullValue($("#designpost-"+id+"-row-labour_value_plating_chains").val() ) );

       formData.append('plating_casting', checkNullValue( $("#designpost-"+id+"-row-plating_casting").val() ) );
       formData.append('plating_casting_square_value', checkNullValue( $("#designpost-plating_casting-square_value"+id).val() ) );
       formData.append('plating_chains', checkNullValue( $("#designpost-"+id+"-row-plating_chains").val() ) );
       formData.append('plating_chains_square_value', checkNullValue( $("#designpost-plating_chains-square_value"+id).val() ) );


       formData.append('current_row', checkNullValue($("#designpost-current_row-"+id).val() ) );


          // var parent_tbody = "#designpost-labor-table-tbody-"+id;
          //
          //   for(let i =0; i<$(parent_tbody).children().length; i++) {
          //     var inner_tr = $(parent_tbody).children()[i]
          //     for (let j = 0; j < $(inner_tr).children().length; j++) {
          //       var inner_td = $(inner_tr).children()[j]
          //       if($(inner_td).children().length == 0) {
          //         continue;
          //       }
          //       var inner_input = $(inner_td).children()[0]
          //       if( $(inner_input).attr('name') == "labour_type" ) {
          //         formData.append('labour_type[]', checkNullValue($(inner_input).val()) );
          //       }
          //       if( $(inner_input).attr('name') == "labour_value" ) {
          //         formData.append('labour_value[]', checkNullValue($(inner_input).val()) );
          //       }
          //
          //       if( $($(inner_input).parent()).hasClass("setting_charge") ) {
          //         var inner_input = $(inner_td).children()[2]
          //         if( $(inner_input).attr('name') == "setting_charge" ) {
          //           formData.append('setting_charge[]', checkNullValue($(inner_input).val()) );
          //         }
          //       }
          //       if( $($(inner_input).parent()).hasClass("plating_type") ) {
          //         // console.log("hi11");
          //         var inner_input = $(inner_td).children()[2]
          //         // console.log(inner_input);
          //         if( $(inner_input).attr('name') == "plating_type" ) {
          //           formData.append('plating_type[]', checkNullValue($(inner_input).val()) );
          //         }
          //
          //         if( $($(inner_input).parent()).hasClass("square_value") ) {
          //           // console.log("hi22");
          //           var inner_input = $(inner_td).children()[4]
          //           // console.log(inner_input);
          //           if( $(inner_input).attr('name') == "square_value" ) {
          //             formData.append('square_value[]', checkNullValue($(inner_input).val()) );
          //           }
          //         }
          //
          //       }
          //
          //
          //     }
          //   }

          var parent_tbody = "#designpost-stone-table-tbody-"+id;

            for(let i =0; i<$(parent_tbody).children().length; i++) {
              var inner_tr = $(parent_tbody).children()[i]
              for (let j = 0; j < $(inner_tr).children().length; j++) {
                var inner_td = $(inner_tr).children()[j]
                if($(inner_td).children().length == 0) {
                  continue;
                }
                var inner_input = $(inner_td).children()[0]
                if( $(inner_input).attr('name') == "stone_name" ) {
                  formData.append('stone_name[]', checkNullValue($(inner_input).val()) );
                }
                if( $(inner_input).attr('name') == "stone_cut" ) {
                  formData.append('stone_cut[]', checkNullValue($(inner_input).val()) ) ;
                }
                if( $(inner_input).attr('name') == "stone_shape" ) {
                  formData.append('stone_shape[]', checkNullValue($(inner_input).val()) );
                }
                if( $(inner_input).attr('name') == "stone_size_l" ) {
                  formData.append('stone_size_l[]', checkNullValue($(inner_input).val()) );
                }
                if( $(inner_input).attr('name') == "stone_size_w" ) {
                  formData.append('stone_size_w[]', checkNullValue($(inner_input).val()) );
                }
                if( $(inner_input).attr('name') == "stone_diamond_quality" ) {
                  formData.append('stone_diamond_quality[]', checkNullValue($(inner_input).val()) );
                }
                if( $(inner_input).attr('name') == "setting_type" ) {
                  formData.append('setting_type[]', checkNullValue($(inner_input).val()) );
                }
                if( $(inner_input).attr('name') == "price_unit" ) {
                  formData.append('price_unit[]', checkNullValue($(inner_input).val()) );
                }
                if( $(inner_input).attr('name') == "stone_qty" ) {
                  formData.append('stone_qty[]', checkNullValue($(inner_input).val()) );
                }
                if( $(inner_input).attr('name') == "stone_weight" ) {
                  formData.append('stone_weight[]', checkNullValue($(inner_input).val()) );
                }
                if( $(inner_input).attr('name') == "stone_value" ) {
                  formData.append('stone_value[]', checkNullValue($(inner_input).val()) );
                }
                if( $(inner_input).attr('name') == "value_added_per" ) {
                  formData.append('value_added_per[]', checkNullValue($(inner_input).val()) );
                }
                if( $(inner_input).attr('name') == "stone_value_added" ) {
                  formData.append('stone_value_added[]', checkNullValue($(inner_input).val()) );
                }
                if( $(inner_input).attr('name') == "sale_price" ) {
                  formData.append('sale_price[]', checkNullValue($(inner_input).val()) );
                }
              }
            }


           $.ajax({
               url: '{{  url("quotation/quotation_design_1/update") }}',
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
                     $("#designpost-id-"+id).val(obj.data)

                     if(form_type == 'duplicate') {
                        callDuplicateMethod(last_form_id+1, $("#designpost-id-"+id).val(), this_instance)
                     }
                     else if(form_type == 'auto_save') {
                        // don't show alert
                     }
                       else {
                       alert(obj.msg)
                     }

                  }else {
                    if(form_type == 'auto_save') {
                       // don't show alert
                    } else {
                       alert(obj.msg)
                    }
                  }

               },
               error: function(obj){
                  var error_msg = ""
                  $.each(obj.responseJSON.errors, function (key, val) {
                      error_msg +=  val[0] + "\n";
                  });
                  // alert(error_msg)

                  if(form_type == 'auto_save') {
                     // don't show alert
                  } else {
                     alert(error_msg)
                  }

               },
           });
   }

   function checkNullValue(value) {
     if(value == null || value == undefined) {
       return '';
     }
     else {
       return value
     }
   }



   function editdesignhead()
        {
           if($("#quotation-form-id").val() == 0) {
              alert("Please Save the quotation form first.");
              return;
           }


                 $.ajax({
                    url: '{{  url("quotation/quotation_design_1/header_update") }}',
                    cache: false,
                    headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                       },
                    type: "post",
                    // data: formData,
                    data: $('#quotation-form').serialize(),
                    dataType: "json",
                    // processData: false,
                    // contentType: false,
                    success: function(obj){
                       if(obj.status) {
                          $("#designpost-designheaderid-1").val(obj.data)
                          alert(obj.msg)
                       } else {
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



   function deleteMoreRowData(this_instance) {
     var parent_tbody =  $(this_instance).parent().parent().parent().parent()
     $(this_instance).parent().parent().parent().remove()
     updateRowNoOnTable(parent_tbody)

     performCalculation(current_section)
   }

   function deleteMoreRowData2(this_instance, current_section) {
     var parent_tbody =  $(this_instance).parent().parent().parent().parent()
     // var parent_tbody =  $(this_instance).parent().parent().parent().parent()

     $(this_instance).parent().parent().parent().remove()

     if( $( parent_tbody ).children().length < 1 ) {
       addMoreData2(this_instance, current_section,  'add_first')
     }

     updateRowNoOnTable(parent_tbody)

     performCalculation(current_section)

   }

   function updateRowNoOnTable(parent_tbody) {
     // console.log("hi11");
     // console.log(parent_tbody);


     for(let i =0; i<$(parent_tbody).children().length; i++) {
       var inner_tr = $(parent_tbody).children()[i]

       // console.log("hi22");
       // console.log($(inner_tr).children().length);

       if($(inner_tr).children().length == 0) {
         continue;
       }
       var inner_td = $(inner_tr).children()[0]

       // console.log($(inner_td).children().length);

       if($(inner_td).children().length == 0) {
         continue;
       }
       var inner_input = $(inner_td).children()[0]

       $(inner_input).attr('value', i+1)

     }


   }



   function updateRowNoMainTable() {
     // console.log("hi11");
     // console.log(parent_tbody);

     var parent_table = "#designtable";

     // start at 1 because of thead
     for(let i =1; i<$(parent_table).children().length; i++) {
       var inner_tr = $($(parent_table).children()[i]).children()

       // console.log(inner_tr);
       // console.log("hi22");

       // if($(inner_tr).children().length >= 0) {
       //   continue;
       // }
       var inner_td = $(inner_tr).children()[5]

       // console.log(inner_td);
       // console.log("hi33");

       if($(inner_td).children().length == 0) {
         continue;
       }
       var inner_input = $(inner_td).children()[0]

       $(inner_input).attr('value', i)

     }

     saveAlldata()


   }

   function showConfirmDialog(row_id) {
      $("#deleteForm-button").attr("onclick", "deleteForm("+row_id+")")
      $("#confirmModal").modal("show")
   }

   function showDuplicateConfirmDialog(this_instance, id, form_type) {
      $("#duplicateForm-button").attr("onclick", "duplicateForm("+this_instance+", "+id+", "+form_type+")")
      $("#confirmDuplicateModal").modal("show")
   }

   function duplicateForm(this_instance, id, form_type) {
      editform(this_instance, id, form_type)
   }

   function deleteForm(id)
   {
      if($("#designpost-id-"+id).val() == 0) {
         $("#designpost-tbody-"+id).remove();
         $("#confirmModal").modal("hide")
      }
      else {
         $.ajax({
              url: '{{  url("quotation/quotation_design_1/delete") }}',
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


     </script>

     <script>


          function checkValue(value) {
              // var check = false;
              var check = 0;
                // console.log('parseFloat(value) : ' + parseFloat(value));
                // console.log("value : " + value);
                // if(parseFloat(value) == NaN || parseFloat(value) <= 0  ||  value <= 0 || value == "" ||  value == undefined) {
                if(parseFloat(value) == NaN || parseFloat(value) < 0   || value == "" ||  value == undefined) {
                // if(parseFloat(value) == NaN || parseFloat(value) <= 0  ) {
                  check = 0;
                  // check = false;
                  // console.log("check  22: " + check);
                }
                else {
                  check = 1;
                  // check = true;
                  // console.log("check 11: " + check);
                }
                // console.log("check : " + check);
                return check;
            }


</script>

<script>

    // I defined it globally because of pass by refernce
    // cost_1 = 0;
    // labour_setting_price = 0;



  function performCalculation(current_section) {
        // labour_setting_price = 0;

        if(checkValue($("#conversion_rate_inr").val()) == 0 ) { return; }
        var conversion_rate_inr = parseFloat($("#conversion_rate_inr").val())

        if(checkValue($("#gold_rate").val()) == 0 ) { return; }
        var gold_rate = parseFloat($("#gold_rate").val())

        if(checkValue($("#silver_rate").val()) == 0 ) { return; }
        var silver_rate = parseFloat($("#silver_rate").val())

        if(checkValue($("#loss_gold").val()) == 0 ) { return; }
        var loss_gold = parseFloat($("#loss_gold").val())

        if(checkValue($("#loss_white_gold").val()) == 0 ) { return; }
        var loss_white_gold = parseFloat($("#loss_white_gold").val())

        if(checkValue($("#loss_silver").val()) == 0 ) { return; }
        var loss_silver = parseFloat($("#loss_silver").val())

        if(checkValue($("#value_additionl_per_for_cost_1_gold").val()) == 0 ) { return; }
        var value_additionl_per_for_cost_1_gold = parseFloat($("#value_additionl_per_for_cost_1_gold").val())

        if(checkValue($("#value_additionl_per_for_cost_1_silver").val()) == 0 ) { return; }
        var value_additionl_per_for_cost_1_silver = parseFloat($("#value_additionl_per_for_cost_1_silver").val())

        if(checkValue($("#designpost-metal_type-"+current_section).val()) == 0 ) { return; }
        var metal_type = $("#designpost-metal_type-"+current_section).val()

        // if(checkValue($("#designpost-metal-"+current_section).val()) == 0 ) { return; }
        // var metal = $("#designpost-metal-"+current_section).val()

        if(checkValue($("#designpost-metal-"+current_section).val()) == 0 ) { return; }
        var metal = $("#designpost-metal-"+current_section).val()

        var metal_weight_casting = 0
        if(checkValue($("#designpost-metal_weight_casting-"+current_section).val()) == 0 ) {
          zeroTheRemiainigValue(current_section);
          // throw new Error("hello");
          return ;
        }
        else { metal_weight_casting = parseFloat( $("#designpost-metal_weight_casting-"+current_section).val() )   }

        var metal_weight_chain = 0
        if(checkValue($("#designpost-metal_weight_chain-"+current_section).val()) == 0 ) {}
        else { metal_weight_chain = parseFloat( $("#designpost-metal_weight_chain-"+current_section).val() ) }

        var value_of_metal_auto = 0;
        var total_metal_weight = 0

        if(metal_type == "Gold") {
          // added 20 from actual price in case of Regular Gold
          if(metal.toLowerCase().indexOf("9k") >= 0) {
            value_of_metal_auto = ( ( ( gold_rate + 20 ) / 31.104 ) /  24 ) * 9 ; }
          if(metal.toLowerCase().indexOf("10k") >= 0 ) {
            value_of_metal_auto = ( ( ( gold_rate + 20 ) / 31.104 ) /  24 ) * 10 ; }
          if(metal.toLowerCase().indexOf("14k") >= 0 ) {
            value_of_metal_auto = ( ( ( gold_rate + 20 ) / 31.104 ) /  24 ) * 14 ; }
          if(metal.toLowerCase().indexOf("18k") >= 0 ) {
            value_of_metal_auto = ( ( ( gold_rate + 20 ) / 31.104 ) /  24 ) * 18 ; }
          if(metal.toLowerCase().indexOf("22k") >= 0 ) {
            value_of_metal_auto = ( ( ( gold_rate + 20 ) / 31.104 ) /  24 ) * 22 ; }

          // added 5% extra from actual weight of gold metal
          metal_weight_casting = (metal_weight_casting / 100 ) * 5 + metal_weight_casting;
          metal_weight_chain = (metal_weight_chain / 100 ) * 5 + metal_weight_chain;
          total_metal_weight = metal_weight_casting + metal_weight_chain;

          if(metal.toLowerCase().indexOf("white") >= 0 ) {
            total_metal_weight = ( ( total_metal_weight / 100 ) * ( loss_white_gold ) ) + total_metal_weight; }
          else {
            total_metal_weight = ( ( total_metal_weight / 100 ) * ( loss_gold ) ) + total_metal_weight;;
          }

        }
        if(metal_type == "Re-Cycled Gold") {
            // added 30 from actual price in case of Re-Cycled Gold
          if(metal.toLowerCase().indexOf("9k") >= 0 ) {
            value_of_metal_auto = ( ( ( gold_rate + 30 ) / 31.104 ) /  24 ) * 9 ; }
          if(metal.toLowerCase().indexOf("10k") >= 0 ) {
            value_of_metal_auto = ( ( ( gold_rate + 30 ) / 31.104 ) /  24 ) * 10 ; }
          if(metal.toLowerCase().indexOf("14k") >= 0 ) {
            value_of_metal_auto = ( ( ( gold_rate + 30 ) / 31.104 ) /  24 ) * 14 ; }
          if(metal.toLowerCase().indexOf("18k") >= 0 ) {
            value_of_metal_auto = ( ( ( gold_rate + 30 ) / 31.104 ) /  24 ) * 18 ; }
          if(metal.toLowerCase().indexOf("22k") >= 0 ) {
            value_of_metal_auto = ( ( ( gold_rate + 30 ) / 31.104 ) /  24 ) * 22 ; }

            // added 5% extra from actual weight of gold metal
            metal_weight_casting = ( (metal_weight_casting / 100 ) * 5 ) + metal_weight_casting;
            metal_weight_chain = ( (metal_weight_chain / 100 ) * 5 ) + metal_weight_chain;
            total_metal_weight = metal_weight_casting + metal_weight_chain;

            if(metal.toLowerCase().indexOf("white") >= 0 ) {
              total_metal_weight = ( ( total_metal_weight / 100 ) * ( loss_white_gold ) ) + total_metal_weight; }
            else {
              total_metal_weight = ( ( total_metal_weight / 100 ) * ( loss_gold ) ) + total_metal_weight;
            }

        }
        if(metal_type == "Silver") {
          value_of_metal_auto = ( ( silver_rate + 2 ) / 31.104 ) ;

          // added 10% extra from actual weight of silver metal
          metal_weight_casting = ( (metal_weight_casting / 100 ) * 10 ) + metal_weight_casting;
          metal_weight_chain = ( (metal_weight_chain / 100 ) * 10 ) + metal_weight_chain;
          total_metal_weight = metal_weight_casting + metal_weight_chain;

          total_metal_weight = ( ( total_metal_weight / 100 ) * ( loss_silver ) ) + total_metal_weight;
        }
        if(metal_type == "Re-Cycled Silver") {
          value_of_metal_auto = ( ( silver_rate + 4 ) / 31.104 ) ;

          // added 10% extra from actual weight of silver metal
          metal_weight_casting = ( (metal_weight_casting / 100 ) * 10 ) + metal_weight_casting;
          metal_weight_chain = ( (metal_weight_chain / 100 ) * 10 ) + metal_weight_chain;
          total_metal_weight = metal_weight_casting + metal_weight_chain;

          total_metal_weight = ( ( total_metal_weight / 100 ) * ( loss_silver ) ) + total_metal_weight;
        }

        // value_of_metal_auto = value_of_metal_auto * ( total_metal_weight == 0 ? 1 : total_metal_weight  );
        value_of_metal_auto = value_of_metal_auto * total_metal_weight;
        $("#designpost-value_of_metal-"+current_section).val(value_of_metal_auto.toFixed(3))

        // var parent_tbody = "#designpost-labor-table-tbody-"+current_section;
        //
        //   for(let i =0; i<$(parent_tbody).children().length; i++) {
        //     var inner_tr = $(parent_tbody).children()[i]
        //     for (let j = 0; j < $(inner_tr).children().length; j++) {
        //       var inner_td = $(inner_tr).children()[j]
        //       if($(inner_td).children().length == 0) {
        //         continue;
        //       }
        //       var inner_input = $(inner_td).children()[0]
        //       if( $(inner_input).attr('name') == "labour_type" ) {
        //         performLabourCalculation(current_section, inner_input, inner_td)
        //       }
        //     }
        //   }

        performLabourCalculation(current_section, $("#designpost-"+current_section+"-row-labour_value_cfp"), "CFP")

        performLabourCalculation(current_section, $("#designpost-"+current_section+"-row-labour_value_total_setting"), "Total Setting Charge")

        performLabourCalculation(current_section, $("#designpost-"+current_section+"-row-plating_casting"), "Plating - Casting")

        performLabourCalculation(current_section, $("#designpost-"+current_section+"-row-plating_chains"), "Plating - Chains")

          // cost_1 = value_of_metal_auto;
          // $("#designpost-cost_1-"+current_section).val(cost_1.toFixed(2))

          var parent_tbody = "#designpost-stone-table-tbody-"+current_section;

            for(let i =0; i<$(parent_tbody).children().length; i++) {
              var inner_tr = $(parent_tbody).children()[i]

              var stone_name = ""
              var stone_cut = ""
              var stone_shape = ""
              var stone_size_l = ""
              var stone_size_w = ""
              var stone_diamond_quality = ""
              // var setting_type = ""
              var price_unit = ""
              var stone_qty = ""
              var stone_value = ""
              var value_added_per = 0

              for (let j = 0; j < $(inner_tr).children().length; j++) {
                var inner_td = $(inner_tr).children()[j]
                if($(inner_td).children().length == 0) {  continue;  }

                var inner_input = $(inner_td).children()[0]

                if( $(inner_input).attr('name') == "stone_name" ) { stone_name =  checkNullValue($(inner_input).val()); }
                if( $(inner_input).attr('name') == "stone_cut" ) { stone_cut =  checkNullValue($(inner_input).val()) ;  }
                if( $(inner_input).attr('name') == "stone_shape" ) {  stone_shape = checkNullValue($(inner_input).val()) ;}
                if( $(inner_input).attr('name') == "stone_size_l" ) { stone_size_l = checkNullValue($(inner_input).val()) ; }
                if( $(inner_input).attr('name') == "stone_size_w" ) { stone_size_w = checkNullValue($(inner_input).val()) ; }
                if( $(inner_input).attr('name') == "stone_diamond_quality" ) { stone_diamond_quality =  checkNullValue($(inner_input).val()) ; }
                // if( $(inner_input).attr('name') == "setting_type" ) { setting_type = checkNullValue($(inner_input).val()) ; }
                if( $(inner_input).attr('name') == "price_unit" ) { price_unit = checkNullValue($(inner_input).val()) ; }
                if( $(inner_input).attr('name') == "stone_qty" ) { stone_qty = checkNullValue($(inner_input).val()) ; }
                if( $(inner_input).attr('name') == "value_added_per" ) { value_added_per = checkNullValue($(inner_input).val()) ; }
                if( $(inner_input).attr('name') == "stone_value" ) { stone_value = checkNullValue($(inner_input).val()) ; }

              }


              if(stone_qty == "" || stone_qty == null || stone_qty == undefined || parseFloat(stone_qty) == NaN || parseFloat(stone_qty) <= 0 ){
                stone_qty = 0;
                performStoneCalculation(inner_td, current_section, stone_qty, price_unit, stone_diamond_quality, stone_shape, stone_size_l, stone_size_w, stone_cut, stone_name)
              }
              else {
                performStoneCalculation(inner_td, current_section, stone_qty, price_unit, stone_diamond_quality, stone_shape, stone_size_l, stone_size_w, stone_cut, stone_name)
              }

              // at the end  ----
              performCalculationWithoutAjax(current_section)


            }
  }


    function performStoneCalculation(this_inner_td, this_current_section, this_stone_qty, this_price_unit, this_stone_diamond_quality, this_stone_shape, this_stone_size_l, this_stone_size_w, this_stone_cut, this_stone_name) {

          $.ajax({
                    url: '{{  url("quotation/quotation_design_1/performStoneCalculation") }}',
                    cache: false,
                    headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                       },
                    type: "post",
                    data: {"stone_qty":this_stone_qty, "price_unit": this_price_unit, "stone_diamond_quality": this_stone_diamond_quality, "stone_shape": this_stone_shape, "stone_size_l": this_stone_size_l, "stone_size_w": this_stone_size_w, "stone_cut": this_stone_cut , "stone_name": this_stone_name},
                    dataType: "json",
                    success: function(obj){
                       if(obj.status) {
                         var total_stone_weight = 0
                          var stone_weight_td = $($(this_inner_td).children()[0]).closest('td').siblings('td.stone_weight')
                          if( $(stone_weight_td).children().length > 0) {
                            var stone_weight_input = $(stone_weight_td).children()[0]
                            total_stone_weight = parseFloat(parseFloat(this_stone_qty) * parseFloat(obj.weight)) ;
                            $(stone_weight_input).val(total_stone_weight )

                            // cost_1 =  parseFloat(cost_1) + parseFloat(total_stone_weight) ;
                            // $("#designpost-cost_1-"+this_current_section).val(parseFloat(cost_1).toFixed(2))

                          }

                          var conversion_rate_inr = parseFloat($("#conversion_rate_inr").val())

                          var total_stone_price = 0
                          var stone_value_td = $($(this_inner_td).children()[0]).closest('td').siblings('td.stone_value')
                          if( $(stone_value_td).children().length > 0) {
                            var stone_value_input = $(stone_value_td).children()[0]
                            // total_stone_price = parseFloat(parseFloat(this_stone_qty) * ( parseFloat(obj.price) / conversion_rate_inr ) ) ;
                            // total_stone_price = parseFloat( ( parseFloat(obj.price) / conversion_rate_inr ) ) ;
                            total_stone_price =  parseFloat( obj.price )   ;
                            $(stone_value_input).val(total_stone_price )
                          }

                          performCalculationWithoutAjax(this_current_section)

                          // performCalculation(this_current_section)



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


    function performLabourCalculation(current_section, this_instance, labour_type) {

          // var labour_type = $(this_instance).val()

          // console.log(this_instance);
          // console.log(labour_type);

          // if(checkValue($("#designpost-product_type-"+current_section).val()) == 0 ) { return; }
          var product_type = $("#designpost-product_type-"+current_section).val()

          // if(checkValue($("#designpost-metal_type-"+current_section).val()) == 0 ) { return; }
          var metal_type = $("#designpost-metal_type-"+current_section).val()

          // if(checkValue($("#designpost-metal-"+current_section).val()) == 0 ) { return; }
          var metal = $("#designpost-metal-"+current_section).val()

          var metal_weight_casting = 0
          if(checkValue($("#designpost-metal_weight_casting-"+current_section).val()) == 0 ) { zeroTheRemiainigValue(current_section); return; }
          else { metal_weight_casting = parseFloat( $("#designpost-metal_weight_casting-"+current_section).val() )   }

          if(labour_type == "CFP") {
            $.ajax({
                      url: '{{  url("quotation/quotation_design_1/performLabourCalculation") }}',
                      cache: false,
                      headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                         },
                      type: "post",
                      data: {"labour_type":labour_type, "product_type": product_type, "metal_type": metal_type, "metal": metal, "metal_weight_casting": metal_weight_casting},
                      dataType: "json",
                      success: function(obj){
                         if(obj.status) {
                            // $("#designtable").append(obj.data);
                            // var labour_value_td = $($(this_instance)).closest('td').siblings('td.labour_value')
                            // if( $(labour_value_td).children().length > 0) {
                            //   var labour_value_input = $(labour_value_td).children()[0]
                            //   $(labour_value_input).attr("value", obj.price)
                            // }
                            //
                            // var labour_value_td = $($(this_instance)).closest('td').siblings('td.labour_value')
                            // if( $(labour_value_td).children().length > 0) {
                            //   var labour_value_input = $(labour_value_td).children()[0]
                            //   $(labour_value_input).attr("value", obj.price)
                            // }

                            // $("#designpost-"+current_section+"-row-labour_value_cfp").attr("value", obj.price)
                            $("#designpost-"+current_section+"-row-labour_value_cfp").val(obj.price)

                            performCalculationWithoutAjax(current_section)


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

          if(labour_type == "Total Setting Charge") {

            // console.log("hello11");

              // performLabourSectionCalculation(current_section, current_section, $($($(this_instance).parent()).children()[2]),  'setting_charge');
              performLabourSectionCalculation(current_section, current_section, this_instance,  'setting_charge');

            // if setting_charge already added
            // if( $($(this_instance).parent()).hasClass("setting_charge") ) {
            //   performLabourSectionCalculation(current_section, current_section, $($($(this_instance).parent()).children()[2]),  'setting_charge');
            // } else {
            //   var setting_charge_select  = ''
            //   setting_charge_select  += '<select name="setting_charge" onchange="performLabourSectionCalculation('+current_section+', '+current_section+', this,  \'setting_charge\')" class="form-control select2-lib-dropdown-setting_charge setting_charge" style="width: 100px;" >'
            //   setting_charge_select  += '</select>'
            //
            //   $($(this_instance).parent()).append(setting_charge_select)
            //   setting_charge_select2()
            //
            //   $($(this_instance).parent()).addClass("setting_charge")
            // }


          }
          else {

            // if( $($(this_instance).parent()).hasClass("setting_charge") ) {
            //
            //   $($(this_instance).parent()).removeClass("setting_charge")
            //   $($($(this_instance).parent()).children()[2]).remove()
            //   $($($(this_instance).parent()).children()[2]).remove()
            //
            // }


          }

          if(checkValue(labour_type) == 1) {
            if(labour_type.toLowerCase().indexOf("plating") >= 0) {

              if(checkValue(metal_type) == 1) {
                if(metal_type.toLowerCase().indexOf("gold") >= 0) {
                    // for gold continue just a static data as pen plating.
                }
                if(metal_type.toLowerCase().indexOf("silver") >= 0) {

                  // only apply calculation for silver

                  if(labour_type.toLowerCase().indexOf("cast") >= 0) {
                      performLabourSectionCalculation(current_section, current_section, this_instance,  'plating_casting');
                      // console.log("hi33");
                  }
                  else if(labour_type.toLowerCase().indexOf("chain") >= 0) {
                    // console.log("hi44");
                      performLabourSectionCalculation(current_section, current_section, this_instance,  'plating_chains');
                  }

                }
              }




              // if setting_charge already added
              // if( $($(this_instance).parent()).hasClass("plating_type") ) {
              //   performLabourSectionCalculation(current_section, current_section, $($($(this_instance).parent()).children()[2]),  'plating_type');
              // } else {
              //   var plating_type_select  = ''
              //   plating_type_select  += '<select name="plating_type" onchange="performLabourSectionCalculation('+current_section+', '+current_section+', this,  \'plating_type\')" class="form-control select2-lib-dropdown-plating_type plating_type" style="width: 100px;" >'
              //   plating_type_select  += '</select>'
              //
              //   $($(this_instance).parent()).append(plating_type_select)
              //   plating_type_select2()
              //
              //   $($(this_instance).parent()).addClass("plating_type")
              // }


            }
            else {

              // if( $($(this_instance).parent()).hasClass("plating_type") ) {
              //
              //   $($(this_instance).parent()).removeClass("plating_type")
              //   $($($(this_instance).parent()).children()[2]).remove()
              //   $($($(this_instance).parent()).children()[2]).remove()
              //
              // }
            }

          }


      }


  function performLabourSectionCalculation(current_section, upper_this_instance, current_this_instance, section_name) {
        // labour_setting_price = 0

        if(section_name == "setting_charge") {

          // console.log("hello22");

          // put 0 at first
          // var labour_value_td = $($(current_this_instance)).closest('td').siblings('td.labour_value')
          // // console.log(labour_value_td);
          // if( $(labour_value_td).children().length > 0) {
          //   var labour_value_input = $(labour_value_td).children()[0]
          //   $(labour_value_input).attr("value", 0)
          // }

          $("#designpost-"+current_section+"-row-labour_value_total_setting").val(0)


          // labour_setting_price = 0

          var setting_charge_value = $(current_this_instance).val()

          // console.log(setting_charge_value);
          // console.log($(current_this_instance).val());
          // console.log($(current_this_instance));

          var total_stone_qty = 0;

          // if(checkValue(setting_charge_value) == 0) { return; }


          // if( typeof setting_charge_value.length == undefined ) { return; }

          // if(setting_charge_value.length > 0) {

            var parent_tbody = "#designpost-stone-table-tbody-"+current_section;

              for(let i =0; i<$(parent_tbody).children().length; i++) {

                // console.log("hi11");
                // labour_setting_price = 0

                var inner_tr = $(parent_tbody).children()[i]

                var stone_name = ""
                // var stone_cut = ""
                // var stone_shape = ""
                var stone_size_l = ""
                var stone_size_w = ""
                var setting_type = ""
                // var stone_diamond_quality = ""
                // var setting_type = ""
                // var price_unit = ""
                var stone_qty = ""

                for (let j = 0; j < $(inner_tr).children().length; j++) {
                  var inner_td = $(inner_tr).children()[j]
                  if($(inner_td).children().length == 0) {  continue;  }

                  var inner_input = $(inner_td).children()[0]

                  if( $(inner_input).attr('name') == "stone_name" ) { stone_name =  checkNullValue($(inner_input).val()); }
                  // if( $(inner_input).attr('name') == "stone_cut" ) { stone_cut =  checkNullValue($(inner_input).val()) ;  }
                  // if( $(inner_input).attr('name') == "stone_shape" ) {  stone_shape = checkNullValue($(inner_input).val()) ;}
                  if( $(inner_input).attr('name') == "stone_size_l" ) { stone_size_l = checkNullValue($(inner_input).val()) ; }
                  if( $(inner_input).attr('name') == "stone_size_w" ) { stone_size_w = checkNullValue($(inner_input).val()) ; }
                  // if( $(inner_input).attr('name') == "stone_diamond_quality" ) { stone_diamond_quality =  checkNullValue($(inner_input).val()) ; }
                  if( $(inner_input).attr('name') == "setting_type" ) { setting_type = checkNullValue($(inner_input).val()) ; }
                  // if( $(inner_input).attr('name') == "price_unit" ) { price_unit = checkNullValue($(inner_input).val()) ; }
                  if( $(inner_input).attr('name') == "stone_qty" ) { stone_qty = checkNullValue($(inner_input).val()) ; }

                }

                // console.log("hi22");
                // console.log(setting_type);

                if( checkValue(setting_type) == 1 ) {

                  // console.log("hi33");

                    setting_charge_value = setting_type;
                  // for wax----------- count quantity of selected stones ..................
                  if(setting_charge_value == "WAX") {
                    var form_data = {"labour_type":"setting_charge", "setting_charge_value": setting_charge_value, "stone_size_l": stone_size_l, "stone_size_w": stone_size_w, "stone_name": stone_name, "stone_qty":stone_qty};
                    // performLabourSettingCalculation(current_section, upper_this_instance, current_this_instance, section_name, form_data)
                    if(checkValue(stone_qty) == '') { continue; }
                    else { performLabourSettingCalculation(current_section, upper_this_instance, current_this_instance, section_name, form_data) }
                  } else {
                    var form_data = {"labour_type":"setting_charge", "setting_charge_value": setting_charge_value, "stone_size_l": stone_size_l, "stone_size_w": stone_size_w, "stone_name": stone_name, "stone_qty":stone_qty};
                    // performLabourSettingCalculation(current_section, upper_this_instance, current_this_instance, section_name, form_data)
                    if(checkValue(stone_size_l) == '' || checkValue(stone_size_w) == '') { continue; }
                    else { performLabourSettingCalculation(current_section, upper_this_instance, current_this_instance, section_name, form_data) }
                  }
                }


              }
          // }
        }

        // if(section_name == "plating_type") {
        //
        //   // var plating_type = $(current_this_instance).val()
        //   // console.log(plating_type);
        //
        //   var plating_type_value = $(current_this_instance).val()
        //
        //   if(checkValue(plating_type_value) == 0) { return; }
        //
        //
        //   // gram calculation ---
        //   if(plating_type_value.toLowerCase().indexOf("gms") >= 0 ) {
        //     //non-chain product caluculation
        //     if(plating_type_value.toLowerCase().indexOf("non") >= 0) {
        //
        //       var plating_type_get_array = plating_type_value.split(",");
        //       var plating_type_get_value = plating_type_get_array[plating_type_get_array.length - 1];
        //
        //       var metal_weight = $("#designpost-metal_weight_casting-"+current_section).val()
        //       if(checkValue(metal_weight) == 0) { metal_weight = 0; }
        //
        //       var labour_value = parseFloat(plating_type_get_value) * parseFloat(metal_weight);
        //
        //       var labour_value_td = $($(current_this_instance)).closest('td').siblings('td.labour_value')
        //       if( $(labour_value_td).children().length > 0) {
        //         var labour_value_input = $(labour_value_td).children()[0]
        //             $(labour_value_input).attr("value", labour_value)
        //       }
        //
        //     }
        //     else { //chain product caluculation
        //       var plating_type_get_array = plating_type_value.split(",");
        //       var plating_type_get_value = plating_type_get_array[plating_type_get_array.length - 1];
        //
        //       var metal_weight = $("#designpost-metal_weight_chain-"+current_section).val()
        //       if(checkValue(metal_weight) == 0) { metal_weight = 0; }
        //
        //       var labour_value = parseFloat(plating_type_get_value) * parseFloat(metal_weight);
        //
        //       var labour_value_td = $($(current_this_instance)).closest('td').siblings('td.labour_value')
        //       if( $(labour_value_td).children().length > 0) {
        //         var labour_value_input = $(labour_value_td).children()[0]
        //         $(labour_value_input).attr("value", labour_value)
        //       }
        //
        //     }
        //   } else if (plating_type_value.toLowerCase().indexOf("square") >= 0) { // square calculation ---
        //
        //     if( $($(current_this_instance).parent()).hasClass("square_value") ) {
        //       var plating_type_get_array = plating_type_value.split(",");
        //       plating_type_get_value = 0;
        //       if(plating_type_get_array.length > 0 ) {
        //         plating_type_get_value = plating_type_get_array[plating_type_get_array.length - 1];
        //       }
        //       performLabourSettingCalculation(current_section, current_section, $($($(current_this_instance).parent()).children()[4]),  'square_value', plating_type_get_value);
        //
        //     } else {
        //       var plating_type_get_array = plating_type_value.split(",");
        //       var plating_type_get_value = plating_type_get_array[plating_type_get_array.length - 1];
        //
        //       var square_value_input  = ''
        //       square_value_input  += '<input name="square_value" onchange="performLabourSettingCalculation('+current_section+', '+current_section+', this,  \'square_value\', '+plating_type_get_value+')" class="form-control " style="width: 100px;" >'
        //
        //       $($(current_this_instance).parent()).append(square_value_input)
        //
        //       $($(current_this_instance).parent()).addClass("square_value")
        //     }
        //
        //   }
        //
        // }


        if(section_name == "plating_casting") {

          // var plating_type = $(current_this_instance).val()
          // console.log(current_this_instance);

          var plating_type_value = $(current_this_instance).val()

          // console.log(plating_type_value);

          if(checkValue(plating_type_value) == 0) { return; }


          // gram calculation ---
          if(plating_type_value.toLowerCase().indexOf("gms") >= 0 ) {
            //non-chain product caluculation
            // if(plating_type_value.toLowerCase().indexOf("non") >= 0) {

              var plating_type_get_array = plating_type_value.split(",");
              var plating_type_get_value = plating_type_get_array[plating_type_get_array.length - 1];

              var metal_weight = 0
              // var metal_weight = $("#designpost-metal_weight_casting-"+current_section).val()
              if(checkValue( $("#designpost-metal_weight_casting-"+current_section).val() ) == 1) {
                metal_weight = $("#designpost-metal_weight_casting-"+current_section).val();
              }

              // console.log("hi33");
              // console.log($("#designpost-metal_weight_casting-"+current_section).val());
              // console.log("hi11");
              // console.log(metal_weight);
              // console.log("hi22");
              // console.log(plating_type_get_value);
              // console.log("hi55");


              var labour_value = parseFloat( parseFloat(plating_type_get_value) * parseFloat(metal_weight) );


              // console.log(labour_value);
              // console.log("hi66");
              //
              // console.log(labour_value);
              // console.log("hi77");

              $("#designpost-"+current_section+"-row-labour_value_plating_casting").val(labour_value.toFixed(2))

              // var labour_value_td = $($(current_this_instance)).closest('td').siblings('td.labour_value')
              // if( $(labour_value_td).children().length > 0) {
              //   var labour_value_input = $(labour_value_td).children()[0]
              //       $(labour_value_input).attr("value", labour_value)
              // }


              $("#designpost-plating_casting-square_value"+current_section).remove();
              $($(current_this_instance).parent()).removeClass("square_value")


              performCalculationWithoutAjax(current_section)

            // }

          } else if (plating_type_value.toLowerCase().indexOf("square") >= 0) { // square calculation ---

            if( $($(current_this_instance).parent()).hasClass("square_value") ) {
              var plating_type_get_array = plating_type_value.split(",");
              plating_type_get_value = 0;
              if(plating_type_get_array.length > 0 ) {
                plating_type_get_value = plating_type_get_array[plating_type_get_array.length - 1];
              }
              performLabourSettingCalculation(current_section, current_section, $("#designpost-plating_casting-square_value"+current_section),  'plating_casting-square_value', plating_type_get_value);

            } else {

              $("#designpost-"+current_section+"-row-labour_value_plating_casting").val(0)


              var plating_type_get_array = plating_type_value.split(",");
              var plating_type_get_value = plating_type_get_array[plating_type_get_array.length - 1];

              // "#designpost-metal_weight_casting-"+current_section

              var square_value_input  = ''
              square_value_input  += '<input name="square_value" id="designpost-plating_casting-square_value'+current_section+'" placeholder="Surface Value" onchange="performLabourSettingCalculation('+current_section+', '+current_section+', this,  \'plating_casting-square_value\', '+plating_type_get_value+')" class="form-control " style="width: 100px;" >'

              $($(current_this_instance).parent()).append(square_value_input)

              $($(current_this_instance).parent()).addClass("square_value")
            }

          }

        }
        if(section_name == "plating_chains") {

          // var plating_type = $(current_this_instance).val()
          // console.log(current_this_instance);

          var plating_type_value = $(current_this_instance).val()

          // console.log(plating_type_value);

          if(checkValue(plating_type_value) == 0) { return; }


          // gram calculation ---
          if(plating_type_value.toLowerCase().indexOf("gms") >= 0 ) {
            //non-chain product caluculation
            // if(plating_type_value.toLowerCase().indexOf("non") >= 0) {

              var plating_type_get_array = plating_type_value.split(",");
              var plating_type_get_value = plating_type_get_array[plating_type_get_array.length - 1];

              var metal_weight = 0
              // var metal_weight = $("#designpost-metal_weight_casting-"+current_section).val()
              if(checkValue( $("#designpost-metal_weight_chain-"+current_section).val() ) == 1) {
                metal_weight = $("#designpost-metal_weight_chain-"+current_section).val();
              }

              var labour_value = parseFloat(plating_type_get_value) * parseFloat(metal_weight);

              $("#designpost-"+current_section+"-row-labour_value_plating_chains").val(labour_value.toFixed(2))

              // var labour_value_td = $($(current_this_instance)).closest('td').siblings('td.labour_value')
              // if( $(labour_value_td).children().length > 0) {
              //   var labour_value_input = $(labour_value_td).children()[0]
              //       $(labour_value_input).attr("value", labour_value)
              // }


              $("#designpost-plating_chains-square_value"+current_section).remove();
              $($(current_this_instance).parent()).removeClass("square_value")


              performCalculationWithoutAjax(current_section)

            // }

          } else if (plating_type_value.toLowerCase().indexOf("square") >= 0) { // square calculation ---

            if( $($(current_this_instance).parent()).hasClass("square_value") ) {
              var plating_type_get_array = plating_type_value.split(",");
              plating_type_get_value = 0;
              if(plating_type_get_array.length > 0 ) {
                plating_type_get_value = plating_type_get_array[plating_type_get_array.length - 1];
              }
              performLabourSettingCalculation(current_section, current_section, $("#designpost-plating_chains-square_value"+current_section),  'plating_chains-square_value', plating_type_get_value);

            } else {

              $("#designpost-"+current_section+"-row-labour_value_plating_chains").val(0)

              var plating_type_get_array = plating_type_value.split(",");
              var plating_type_get_value = plating_type_get_array[plating_type_get_array.length - 1];

              // "#designpost-metal_weight_casting-"+current_section

              var square_value_input  = ''
              square_value_input  += '<input name="square_value" id="designpost-plating_chains-square_value'+current_section+'" placeholder="Surface Value" onchange="performLabourSettingCalculation('+current_section+', '+current_section+', this,  \'plating_chains-square_value\', '+plating_type_get_value+')" class="form-control " style="width: 100px;" >'

              $($(current_this_instance).parent()).append(square_value_input)

              $($(current_this_instance).parent()).addClass("square_value")
            }

          }

        }





      }


  function performLabourSettingCalculation(current_section, upper_this_instance, current_this_instance, section_name, form_data) {

    if(section_name != "setting_charge") { labour_setting_price = 0; }

    if(section_name == "setting_charge") {

      // console.log("hi44");

      $.ajax({
                url: '{{  url("quotation/quotation_design_1/performLabourCalculation") }}',
                cache: false,
                headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                type: "post",
                data: form_data,
                dataType: "json",
                success: function(obj){
                   if(obj.status) {
                      // $("#designtable").append(obj.data);

                      // labour_setting_price = labour_setting_price + obj.price;

                      // console.log(labour_setting_price);

                      // console.log(labour_setting_price);

                      // var labour_value_td = $($(current_this_instance)).closest('td').siblings('td.labour_value')
                      //
                      // // console.log(labour_value_td);
                      //
                      // if( $(labour_value_td).children().length > 0) {
                      //   var labour_value_input = $(labour_value_td).children()[0]
                      //   var labour_value_input_value = $(labour_value_input).val()
                      //   // here i m updating the data from previous value
                      //   labour_value_input_value = parseFloat(labour_value_input_value) + parseFloat(obj.price)
                      //   $(labour_value_input).attr("value", labour_value_input_value.toFixed(2))
                      // }

                      var labour_value_input_value = $("#designpost-"+current_section+"-row-labour_value_total_setting").val()
                      // here i m updating the data from previous value
                      labour_value_input_value = parseFloat(labour_value_input_value) + parseFloat(obj.price)
                      $("#designpost-"+current_section+"-row-labour_value_total_setting").val(labour_value_input_value.toFixed(2))

                      performCalculationWithoutAjax(current_section)

                   } else {
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
    else if ( section_name == 'plating_casting-square_value') {
      var square_input_value = $(current_this_instance).val()
      if(checkValue(square_input_value) == 0) { square_input_value = 0; }

      var labour_value = parseFloat(square_input_value) * parseFloat(form_data) / 625;

      $("#designpost-"+current_section+"-row-labour_value_plating_casting").val(labour_value.toFixed(2))

      performCalculationWithoutAjax(current_section)

      // var labour_value_td = $($(current_this_instance)).closest('td').siblings('td.labour_value')
      // if( $(labour_value_td).children().length > 0) {
      //   var labour_value_input = $(labour_value_td).children()[0]
      //   $(labour_value_input).attr("value", labour_value)
      // }
    }
    else if ( section_name == 'plating_chains-square_value') {
      var square_input_value = $(current_this_instance).val()
      if(checkValue(square_input_value) == 0) { square_input_value = 0; }

      var labour_value = parseFloat(square_input_value) * parseFloat(form_data) / 625;

      $("#designpost-"+current_section+"-row-labour_value_plating_chains").val(labour_value.toFixed(2))

      performCalculationWithoutAjax(current_section)

      // var labour_value_td = $($(current_this_instance)).closest('td').siblings('td.labour_value')
      // if( $(labour_value_td).children().length > 0) {
      //   var labour_value_input = $(labour_value_td).children()[0]
      //   $(labour_value_input).attr("value", labour_value)
      // }
    }

      }


  function perforMetalTypeCalculation(current_section, this_instance) {

    $("#designpost-metal-"+current_section).empty().trigger("change")
    performCalculation(current_section)

    var metal_type = $(this_instance).val()

    if(checkValue(metal_type) == 1) {
      if(metal_type.toLowerCase().indexOf("gold") >= 0) {

          // $("#designpost-plating_casting-gold_plating_text-"+current_section).show()
          // $("#designpost-"+current_section+"-row-plating_casting").select2('destroy')
          // $("#designpost-"+current_section+"-row-plating_casting").hide()
          // $("#designpost-"+current_section+"-row-labour_value_plating_casting").removeAttr("readonly")
          // $("#designpost-"+current_section+"-row-labour_value_plating_casting").attr("value", 0)
          //
          // $("#designpost-plating_chains-gold_plating_text-"+current_section).show()
          // $("#designpost-"+current_section+"-row-plating_chains").select2('destroy')
          // $("#designpost-"+current_section+"-row-plating_chains").hide()
          // $("#designpost-"+current_section+"-row-labour_value_plating_chains").removeAttr("readonly")
          // $("#designpost-"+current_section+"-row-labour_value_plating_chains").attr("value", 0)

          // designpost-1-row-plating_chains_td
          $("#designpost-"+current_section+"-row-plating_chains_td").parent().hide()

          // $("#designpost-plating_casting-gold_plating_text-"+current_section).remove()
          var input_tag = ""
          input_tag  += '<input name="gold_text_chains" style="width: 100px;" class="form-control-plaintext" id="designpost-plating_casting-gold_plating_text-'+current_section+'" value="Pen Plating">';
          $("#designpost-"+current_section+"-row-plating_casting_td").html(input_tag)
          // $("#designpost-"+current_section+"-row-plating_casting").select2('destroy')
          // $("#designpost-"+current_section+"-row-plating_casting").remove()
          $("#designpost-"+current_section+"-row-labour_value_plating_casting").removeAttr("readonly")
          $("#designpost-"+current_section+"-row-labour_value_plating_casting").val(0)

          // $("#designpost-plating_chains-gold_plating_text-"+current_section).remove()
          // var input_tag = ""
          // input_tag += '<input name="gold_text_chains" style="width: 100px;" class="form-control-plaintext" id="designpost-plating_chains-gold_plating_text-'+current_section+'" value="Pen Plating">';
          // $("#designpost-"+current_section+"-row-plating_chains_td").html(input_tag)
          // // $("#designpost-"+current_section+"-row-plating_chains").select2('destroy')
          // // $("#designpost-"+current_section+"-row-plating_chains").remove()
          $("#designpost-"+current_section+"-row-labour_value_plating_chains").removeAttr("readonly")
          $("#designpost-"+current_section+"-row-labour_value_plating_chains").val(0)

      }
      if(metal_type.toLowerCase().indexOf("silver") >= 0) {

        // $("#designpost-plating_casting-gold_plating_text-"+current_section).hide()
        // $("#designpost-"+current_section+"-row-plating_casting").show()
        // plating_casting_select2();
        // $("#designpost-"+current_section+"-row-labour_value_plating_casting").attr("readonly", "readonly")
        // $("#designpost-"+current_section+"-row-labour_value_plating_casting").attr("value", 0)
        //
        // $("#designpost-plating_chains-gold_plating_text-"+current_section).hide()
        // $("#designpost-"+current_section+"-row-plating_chains").show()
        // plating_chains_select2();
        // $("#designpost-"+current_section+"-row-labour_value_plating_chains").attr("readonly", "readonly")
        // $("#designpost-"+current_section+"-row-labour_value_plating_chains").attr("value", 0)

        // $("#designpost-"+current_section+"-row-plating_casting").select2('destroy')
        // $("#designpost-"+current_section+"-row-plating_casting").remove()

        $("#designpost-"+current_section+"-row-plating_chains_td").parent().show()

        var input_tag = ""
        input_tag += 'Plating Casting Products ';
        input_tag += '<select name="plating_casting" onchange="performCalculation('+current_section+')" class="form-control select2-lib-dropdown-plating_casting" style="width: 100px;" id="designpost-'+current_section+'-row-plating_casting"  >';
        input_tag += '</select  >';
        $("#designpost-"+current_section+"-row-plating_casting_td").html(input_tag)
        // $("#designpost-plating_casting-gold_plating_text-"+current_section).remove()
        // $("#designpost-"+current_section+"-row-plating_casting").show()
        plating_casting_select2();
        $("#designpost-"+current_section+"-row-labour_value_plating_casting").attr("readonly", "readonly")
        $("#designpost-"+current_section+"-row-labour_value_plating_casting").val(0)

        // $("#designpost-"+current_section+"-row-plating_chains").select2('destroy')
        // $("#designpost-"+current_section+"-row-plating_chains").remove()
        var input_tag = ""
        input_tag += 'Plating - Chains ';
        input_tag += '<select name="plating_chains" onchange="performCalculation('+current_section+')" class="form-control select2-lib-dropdown-plating_chains" style="width: 100px;" id="designpost-'+current_section+'-row-plating_chains"  >';
        input_tag += '</select  >';
        $("#designpost-"+current_section+"-row-plating_chains_td").html(input_tag)
        // $("#designpost-plating_chains-gold_plating_text-"+current_section).remove()
        // $("#designpost-"+current_section+"-row-plating_chains").show()
        plating_chains_select2();
        $("#designpost-"+current_section+"-row-labour_value_plating_chains").attr("readonly", "readonly")
        $("#designpost-"+current_section+"-row-labour_value_plating_chains").val(0)
      }
    }


  }


function performCalculationWithoutAjax(current_section) {
  var value_of_metal = parseFloat($('#designpost-value_of_metal-'+current_section).val());
  var metal_type = checkNullValue($("#designpost-metal_type-"+current_section).val())

  var total_labour_value = 0;
  var total_labour_value_1 = 0;


  var labour_value_cfp = 0;
  if(checkValue( $("#designpost-"+current_section+"-row-labour_value_cfp").val() ) == 1 ) {
    labour_value_cfp = $("#designpost-"+current_section+"-row-labour_value_cfp").val();
  }

  var labour_value_chain_labour = 0;
  if(checkValue( $("#designpost-"+current_section+"-row-labour_value_chain_labour").val() ) == 1 ) {
    labour_value_chain_labour = $("#designpost-"+current_section+"-row-labour_value_chain_labour").val();
  }

  var labour_value_total_setting = 0;
  if(checkValue( $("#designpost-"+current_section+"-row-labour_value_total_setting").val() ) == 1 ) {
    labour_value_total_setting = $("#designpost-"+current_section+"-row-labour_value_total_setting").val();
  }

  var labour_value_finding = 0;
  if(checkValue( $("#designpost-"+current_section+"-row-labour_value_finding").val() ) == 1 ) {
    labour_value_finding = $("#designpost-"+current_section+"-row-labour_value_finding").val();
  }

  var labour_value_packing = 0;
  if(checkValue( $("#designpost-"+current_section+"-row-labour_value_packing").val() ) == 1 ) {
    labour_value_packing = $("#designpost-"+current_section+"-row-labour_value_packing").val();
  }

  var labour_value_plating_casting = 0;
  if(checkValue( $("#designpost-"+current_section+"-row-labour_value_plating_casting").val() ) == 1 ) {
    labour_value_plating_casting = $("#designpost-"+current_section+"-row-labour_value_plating_casting").val();
  }

  var labour_value_plating_chains = 0;
  if(checkValue( $("#designpost-"+current_section+"-row-labour_value_plating_chains").val() ) == 1 ) {
    labour_value_plating_chains = $("#designpost-"+current_section+"-row-labour_value_plating_chains").val();
  }

  if(metal_type.toLowerCase().indexOf("gold") >= 0) {
    // this will not count for gold
    labour_value_plating_chains  = 0
  }


  total_labour_value = parseFloat(labour_value_cfp) + parseFloat(labour_value_chain_labour) + parseFloat(labour_value_total_setting) + parseFloat(labour_value_finding) + parseFloat(labour_value_packing);
  total_labour_value_1 = parseFloat(total_labour_value) + parseFloat(labour_value_plating_casting) + parseFloat(labour_value_plating_chains) ;


     var parent_tbody = "#designpost-stone-table-tbody-"+current_section;
     var total_stone_weight = 0;
     var total_stone_value_added = 0;
     var total_sale_price = 0;

       for(let i =0; i<$(parent_tbody).children().length; i++) {
         var inner_tr = $(parent_tbody).children()[i]

         var value_added_per = 0
         var stone_weight = 0
         var stone_value = 0

         for (let j = 0; j < $(inner_tr).children().length; j++) {
           var inner_td = $(inner_tr).children()[j]
           if($(inner_td).children().length == 0) {
             continue;
           }
           var inner_input = $(inner_td).children()[0]

           if( $(inner_input).attr('name') == "stone_weight" ) {
             stone_weight = checkNullValue($(inner_input).val());
           }
           if( $(inner_input).attr('name') == "stone_value" ) {
             stone_value = checkNullValue($(inner_input).val());
           }
           if( $(inner_input).attr('name') == "value_added_per" ) {
             value_added_per = checkNullValue($(inner_input).val());
           }

         }

         if(checkValue(stone_weight) == 1 || stone_weight == 0 ) {
           total_stone_weight = parseFloat(total_stone_weight) + parseFloat(stone_weight);

           if(checkValue(value_added_per) == 1) {

             var conversion_rate_inr = parseFloat($("#conversion_rate_inr").val())

             // sale price calculation
             var sale_price_td = $($(inner_tr).children()[0]).closest('td').siblings('td.sale_price')
             if( $(sale_price_td).children().length > 0) {
               var sale_price_input = $(sale_price_td).children()[0]
               // var sale_price_value =  parseFloat(stone_weight) * parseFloat(stone_value_added_value)  ;
               var sale_price_value =  parseFloat(stone_value) + ( ( parseFloat(stone_value) / 100 ) * parseFloat(value_added_per) )  ;
               $(sale_price_input).val(parseFloat(sale_price_value).toFixed(2))

                total_sale_price = parseFloat(total_sale_price) + parseFloat(sale_price_value);

                var stone_value_added_td = $($(inner_tr).children()[0]).closest('td').siblings('td.stone_value_added')
                if( $(stone_value_added_td).children().length > 0) {

                  // stone_value_added calculation
                  var stone_value_added_input = $(stone_value_added_td).children()[0]
                  var stone_value_added_value = parseFloat(stone_weight) * parseFloat(sale_price_value)

                  stone_value_added_value = parseFloat(stone_value_added_value) / parseFloat(conversion_rate_inr);
                  $(stone_value_added_input).val(parseFloat(stone_value_added_value).toFixed(2))

                   total_stone_value_added = parseFloat(total_stone_value_added) + parseFloat(stone_value_added_value);

                }

             }

          }

         }

       }

       var cost_1 = 0;
       var cost_2 = parseFloat(total_stone_value_added);

       var value_additionl_per_for_cost_1 = 0


       if(metal_type.toLowerCase().indexOf("gold") >= 0) {
         // labour_value_plating_casting =  0
         // labour_value_plating_chains =  0
         cost_1 = parseFloat( value_of_metal + total_labour_value_1  ) ;
         cost_2 = parseFloat(cost_2);
         value_additionl_per_for_cost_1 = parseFloat($("#value_additionl_per_for_cost_1_gold").val())
       }
       else if(metal_type.toLowerCase().indexOf("silver") >= 0) {
         cost_1 = parseFloat( value_of_metal + total_labour_value  ) ;
         cost_2 = parseFloat(cost_2) + parseFloat(labour_value_plating_casting) + parseFloat(labour_value_plating_chains);
         value_additionl_per_for_cost_1 = parseFloat($("#value_additionl_per_for_cost_1_silver").val())
       }

      $("#designpost-cost_1-"+current_section).val(cost_1.toFixed(2))
      $("#designpost-cost_2-"+current_section).val(cost_2.toFixed(2))

       value_addition_cost_1 = ( ( parseFloat(cost_1) / 100 ) * parseFloat(value_additionl_per_for_cost_1) );
       $("#designpost-value_addition_cost_1-"+current_section).val(value_addition_cost_1.toFixed(2))


       var ex_factory_price = 0
       ex_factory_price =  parseFloat( parseFloat(cost_1) + parseFloat(value_addition_cost_1) );

       if(metal_type.toLowerCase().indexOf("gold") >= 0) {
         // console.log("hi11");
         ex_factory_price = parseFloat( parseFloat(ex_factory_price) + parseFloat(total_stone_value_added)  ) ;
       }
       else if(metal_type.toLowerCase().indexOf("silver") >= 0) {
         // console.log("hi22");
         // console.log(ex_factory_price);
         // console.log(total_stone_value_added);
         // console.log(labour_value_plating_casting);
         // console.log(labour_value_plating_chains);
         ex_factory_price = parseFloat(parseFloat(ex_factory_price) + parseFloat(total_stone_value_added) + parseFloat(labour_value_plating_casting) + parseFloat(labour_value_plating_chains) ) ;
       }

       $("#designpost-ex_factory_price-"+current_section).val(ex_factory_price.toFixed(2))


       var discount_per = 0;
       if(checkValue( $("#designpost-discount_per-"+current_section).val() ) == 1 ) {
         discount_per = $("#designpost-discount_per-"+current_section).val();
       }

       var price_after_discount = parseFloat(ex_factory_price) - parseFloat( ( parseFloat(ex_factory_price) / 100 ) * parseFloat(discount_per) );
       $("#designpost-price_after_discount-"+current_section).val(price_after_discount.toFixed(2))


}




       function performAllCalculation() {

          for(let j=0; j<$(".section_id-class").length; j++)
          {
            var id = $(".section_id-class")[j].defaultValue;
            performCalculation(id)
          }
       }


       function saveAlldata() {

          for(let j=0; j<$(".section_id-class").length; j++)
          {
            var id = $(".section_id-class")[j].defaultValue;

            // modify first parameter if it is not work as 'this' parameter
            editform($(".section_id-class")[j], id, 'auto_save')
          }
       }

       // Auto Save the data in every 50 seconds
       setInterval(saveAlldata, 1000*50);


</script>

<script>

   function callDuplicateMethod(last_id, last_insert_id, this_instance)
   {

      if($("#quotation-form-id").val() == 0  || $("#designpost-designheaderid-1").val() == 0  ) {
         alert("Please Save the Description first.");
         return;
      }

      $.ajax({
                url: '{{  url("quotation/quotation_design_1/duplicateNewDesignFormRow") }}',
                cache: false,
                headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                type: "post",
                data: {"id":last_id, "last_insert_id": last_insert_id},
                dataType: "json",
                success: function(obj){
                   if(obj.status) {
                      // $("#designtable").append(obj.data);
                      $(this_instance).parent().parent().parent().parent().after(obj.data);
                      // $(this_instance).parent().parent().parent().after(obj.data);
                      selectLib()
                      zoomImages();

                      // selectLib()

                      product_type_select2();
                      metal_type_select2();
                      metal_name_select2();
                      labour_type_select2();
                      setting_charge_select2();
                      // plating_type_select2();
                      plating_casting_select2();
                      plating_chains_select2();

                      stone_name_select2();
                      stone_cut_select2();
                      stone_shape_select2();
                      stone_size_l_select2();
                      stone_size_w_select2();
                      stone_diamond_quality_select2();
                      setting_type_select2();
                      price_unit_select2();

                      updateRowNoMainTable()

                   } else {
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


  function downloadFile() {
    if($("#quotation-form-id").val() == 0  || $("#designpost-designheaderid-1").val() == 0  ) {
       alert("Please Save the Description first.");
       return;
    } else {
      window.location.href = window.location.origin + '/quotation/quotation_design/export?quotation_id=' + $("#quotation-form-id").val() + '&quoation_form_type=Anna-EFB Network&page=excel'
    }
  }


  function zeroTheRemiainigValue(current_section) {
    $("#designpost-value_of_metal-"+current_section).val(0)

    $("#designpost-"+current_section+"-row-labour_value_cfp").val(0)
    $("#designpost-"+current_section+"-row-labour_value_chain_labour").val(0)
    $("#designpost-"+current_section+"-row-labour_value_total_setting").val(0)
    $("#designpost-"+current_section+"-row-labour_value_finding").val(0)
    $("#designpost-"+current_section+"-row-labour_value_packing").val(0)
    $("#designpost-"+current_section+"-row-labour_value_plating_casting").val(0)
    $("#designpost-"+current_section+"-row-labour_value_plating_chains").val(0)

    $("#designpost-cost_1-"+current_section).val(0)
    $("#designpost-cost_2-"+current_section).val(0)
    $("#designpost-value_addition_cost_1-"+current_section).val(0)
    $("#designpost-ex_factory_price-"+current_section).val(0)
    $("#designpost-price_after_discount-"+current_section).val(0)


  }





</script>
