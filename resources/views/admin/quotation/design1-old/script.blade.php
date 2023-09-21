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


   function addMoreData(id) {
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
               success: function(obj){
                  if(obj.status) {

                     $("#designpost-last-row-"+id).before(obj.data)
                     $(".designpost-tbody-class-"+id).attr("rowspan", current_row+1)
                     $("#designpost-current_row-"+id).attr("value", current_row+1)
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
               success: function(obj){
                  if(obj.status) {
                     $("#designtable").append(obj.data);
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



   function editform(id, form_type)
   {

      var formData = new FormData();
       formData.append('id', $("#designpost-id-"+id).val());
       formData.append('quotation_table_id', $("#quotation-form-id").val());
      // if($('#designpost-image-'+id)[0].files.length > 0) {
      //   formData.append('image', $('#designpost-image-'+id)[0].files[0]);
      // }
       formData.append('image', $('#designpost-image-'+id).val());
       formData.append('image_type', $('#designpost-image_type-'+id).val());
       formData.append('description', $('#designpost-description-'+id).val());
       formData.append('product_type', $('#designpost-product_type-'+id).val());
       formData.append('size', $('#designpost-size-'+id).val());
       formData.append('model_number', $('#designpost-model_number-'+id).val());
       formData.append('their_code', $('#designpost-their_code-'+id).val());
       formData.append('order_qty', $('#designpost-order_qty-'+id).val());
       formData.append('metal', $('#designpost-metal-'+id).val());
       formData.append('metal_per_gms', $('#designpost-metal_per_gms-'+id).val());
       formData.append('metal_weight', $('#designpost-metal_weight-'+id).val());
       formData.append('metal_value_including_wastage', $('#designpost-metal_value_including_wastage-'+id).val());

       formData.append('total_labour', $('#designpost-total_labour-'+id).val());
       formData.append('metal_labour_cost', $('#designpost-metal_labour_cost-'+id).val());
       formData.append('value_addition_silver', $('#designpost-value_addition_silver-'+id).val());
       formData.append('rhodium', $('#designpost-rhodium-'+id).val());
       formData.append('gold_plating', $('#designpost-gold_plating-'+id).val());
       formData.append('pd', $('#designpost-pd-'+id).val());
       formData.append('total_stone_value', $('#designpost-total_stone_value-'+id).val());
       formData.append('price_in_usd', $('#designpost-price_in_usd-'+id).val());
       formData.append('price_in_euro', $('#designpost-price_in_euro-'+id).val());

       formData.append('total_stone', $('#designpost-total_stone-'+id).val());
       formData.append('tcw', $('#designpost-tcw-'+id).val());
       formData.append('extra_column_1', $('#designpost-extra_column_1-'+id).val());
       formData.append('extra_column_2', $('#designpost-extra_column_2-'+id).val());

       formData.append('current_row', $("#designpost-current_row-"+id).val());

       var current_row_of_id = parseInt($("#designpost-current_row-"+id).val())


       for(let i=0; i<=current_row_of_id; i++) {
          if($('#designpost-'+id+'-row-labour_type-'+i+'').val() == undefined ) {
             continue;
          }
          else {

            formData.append('table_id[]', $('#designpost-'+id+'-row-table_id-'+i+'').val());
            formData.append('labour_type[]', $('#designpost-'+id+'-row-labour_type-'+i+'').val());
            formData.append('labour_value[]', $('#designpost-'+id+'-row-labour_value-'+i+'').val());
            formData.append('labour_rate[]', $('#designpost-'+id+'-row-labour_rate-'+i+'').val());
            formData.append('gem_variation[]', $('#designpost-'+id+'-row-gem_variation-'+i+'').val());
            formData.append('stone[]', $('#designpost-'+id+'-row-stone-'+i+'').val());
            formData.append('shape[]', $('#designpost-'+id+'-row-shape-'+i+'').val());
            formData.append('cut[]', $('#designpost-'+id+'-row-cut-'+i+'').val());
            formData.append('setting[]', $('#designpost-'+id+'-row-setting-'+i+'').val());
            formData.append('setting_rate[]', $('#designpost-'+id+'-row-setting_rate-'+i+'').val());
            formData.append('l[]', $('#designpost-'+id+'-row-l-'+i+'').val());
            formData.append('w[]', $('#designpost-'+id+'-row-w-'+i+'').val());
            formData.append('qty[]', $('#designpost-'+id+'-row-qty-'+i+'').val());
            formData.append('weight[]', $('#designpost-'+id+'-row-weight-'+i+'').val());
            formData.append('price[]', $('#designpost-'+id+'-row-price-'+i+'').val());
            formData.append('stone_value[]', $('#designpost-'+id+'-row-stone_value-'+i+'').val());
            formData.append('purchase_price[]', $('#designpost-'+id+'-row-purchase_price-'+i+'').val());
            formData.append('sale_price[]', $('#designpost-'+id+'-row-sale_price-'+i+'').val());

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
            formData.append('metal_kittco_gold', $('#designpost-metal_kittco_gold-1').val());
            formData.append('metal_kittco_silver', $('#designpost-metal_kittco_silver-1').val());
            formData.append('usd_conversion', $('#designpost-usd_conversion-1').val());

                 $.ajax({
                    url: '{{  url("quotation/quotation_design_1/header_update") }}',
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
      console.log("current_row_of_id : "+ current_row_of_id)
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





     // function getValueFromInputArray(row, name) {
     //   var temp_value = 0;
     //
     //   var current_row_of_id = parseInt($("#designpost-current_row-"+row).val())
     //   for(let i=0; i<=current_row_of_id; i++) {
     //      if($('#designpost-'+row+'-row-'+name+'-'+i+'').val() == undefined ) {
     //        console.log("hi44"+temp_value)
     //         continue;
     //      }
     //      else {
     //        var inputValue =  $('#designpost-'+row+'-row-'+name+'-'+i+'').val()
     //        if(parseFloat(inputValue) == NaN || parseFloat(inputValue) == 0) {
     //          console.log("hi33"+temp_value)
     //           continue;
     //        }
     //        else {
     //          temp_value = parseFloat(temp_value) + parseFloat(inputValue);
     //          console.log("hi11"+temp_value)
     //        }
     //      }
     //   }
     //   console.log("hi22"+temp_value)
     //
     // return temp_value;
     //
     // }



     </script>

     <script>


          // function performCalculation(id) {
          //   var metal_kittco_silver = $("#designpost-metal_kittco_silver-1").val();
          //   metal_kittco_silver = parseFloat(metal_kittco_silver);
          //   if(checkValue($("#designpost-metal_kittco_silver-1").val()) == 0 ) {
          //     // alert("Metal Kitco Silver should be number only.")
          //     return;
          //   }
          //
          //
          //   var metal_per_gms = 0;
          //   metal_per_gms = (metal_kittco_silver) / (31.1)
          //   $("#designpost-metal_per_gms-"+id).val(metal_per_gms)
          //
          //
          //   var metal_weight = $("#designpost-metal_weight-"+id).val();
          //   metal_weight = parseFloat(metal_weight);
          //   if(checkValue($("#designpost-metal_weight-"+id).val()) == 0 ) {
          //     // alert("Metal Weight should be number only.")
          //     return;
          //   }
          //
          //   var metal_value_including_wastage = 0;
          //   metal_value_including_wastage = metal_weight * metal_per_gms * 1.1;
          //   $("#designpost-metal_value_including_wastage-"+id).val(metal_value_including_wastage)
          //
          //   var total_labour = 0;
          //   var total_labour_sum  = getValueFromInputArray(id, 'labour_rate');
          //   $("#designpost-total_labour-"+id).val(total_labour_sum)
          //
          // }


          function checkValue(value) {
              // var check = false;
              var check = 0;
                // console.log('parseFloat(value) : ' + parseFloat(value));
                // console.log("value : " + value);
                if(parseFloat(value) == NaN || parseFloat(value) <= 0  ||  value <= 0 || value == "" ||  value == undefined) {
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




            function performCalculation(current_section) {


              if(checkValue($("#designpost-metal_kittco_silver-1").val()) == 0 ) {
                // alert("Metal Kitco Silver should be number only.")
                return;
              }
              var metal_kittco_silver = $("#designpost-metal_kittco_silver-1").val();
              // calculation ----------------
              var metal_per_gms = parseFloat(metal_kittco_silver) / (31.1);
              $("#designpost-metal_per_gms-"+current_section).val(metal_per_gms.toFixed(2))

              if(checkValue($("#designpost-metal_weight-"+current_section).val()) == 0 ) {
                // alert("Metal Weight should be number only.")
                return;
              }
              var metal_weight = $("#designpost-metal_weight-"+current_section).val();
              // calculation ----------------
              var metal_value_including_wastage = parseFloat(metal_weight) * parseFloat(metal_per_gms) * 1.1;
              $("#designpost-metal_value_including_wastage-"+current_section).val(metal_value_including_wastage.toFixed(2))

              var total_labour_sum = 0;
              // calculation ----------------
              var current_row_of_id = parseInt($("#designpost-current_row-"+current_section).val())
                 for(let i=0; i<=current_row_of_id; i++) {
                   if(checkValue( $('#designpost-'+current_section+'-row-labour_rate-'+i+'').val() ) == 0  ) {
                      continue;
                      console.log("hi11 : " );
                   }
                   else {
                     console.log("hi22 : " );
                     total_labour_sum = parseFloat(total_labour_sum) + parseFloat($('#designpost-'+current_section+'-row-labour_rate-'+i+'').val())
                   }
                   console.log("total_labour_sum : " + total_labour_sum );
                 }
             $("#designpost-total_labour-"+current_section).val(parseFloat(total_labour_sum).toFixed(2))

             // calculation ----------------
             var metal_labour_cost = parseFloat(total_labour_sum) + parseFloat(metal_value_including_wastage) ;
             $("#designpost-metal_labour_cost-"+current_section).val(metal_labour_cost.toFixed(2))

             // calculation ----------------
             var value_addition_silver = ( parseFloat(metal_labour_cost) / 100 ) * 15 ;
             $("#designpost-value_addition_silver-"+current_section).val(value_addition_silver.toFixed(2))

             if(checkValue($("#designpost-rhodium-"+current_section).val()) == 0 ) {
               // alert("Metal Weight should be number only.")
               return;
             }
             if(checkValue($("#designpost-gold_plating-"+current_section).val()) == 0 ) {
               // alert("Metal Weight should be number only.")
               return;
             }
             if(checkValue($("#designpost-pd-"+current_section).val()) == 0 ) {
               // alert("Metal Weight should be number only.")
               return;
             }
             var rhodium = parseFloat($("#designpost-rhodium-"+current_section).val());
             var gold_plating = parseFloat($("#designpost-gold_plating-"+current_section).val());
             var pd = parseFloat($("#designpost-pd-"+current_section).val());

             var total_stone_value_sum = 0;
             // calculation ----------------
             var current_row_of_id = parseInt($("#designpost-current_row-"+current_section).val())
                for(let i=0; i<=current_row_of_id; i++) {
                  if(checkValue( $('#designpost-'+current_section+'-row-stone_value-'+i+'').val() ) == 0 ) {
                     continue;
                  }
                  else {
                    total_stone_value_sum =  parseFloat(total_stone_value_sum) + parseFloat($('#designpost-'+current_section+'-row-stone_value-'+i+'').val())
                  }
                }
            $("#designpost-total_stone_value-"+current_section).val(parseFloat(total_stone_value_sum).toFixed(2))

            // var total_stone_value_sum = 0;
            //
            // if(checkValue($("#designpost-total_stone_value-"+current_section).val()) == 0 ) {
            //   // alert("Metal Weight should be number only.")
            //   return;
            // }
            // total_stone_value_sum = parseFloat($("#designpost-total_stone_value-"+current_section).val());

            // calculation ----------------
            var price_in_usd = parseFloat(total_stone_value_sum) + parseFloat(pd) + parseFloat(gold_plating) + parseFloat(rhodium) + parseFloat(value_addition_silver) + parseFloat(metal_labour_cost);
            $("#designpost-price_in_usd-"+current_section).val(price_in_usd.toFixed(2))

            // calculation ----------------
            var price_in_euro = parseFloat(price_in_usd) * 0.96;
            $("#designpost-price_in_euro-"+current_section).val(price_in_euro.toFixed(2))


            var current_row_of_id = parseInt($("#designpost-current_row-"+current_section).val())
               for(let i=0; i<=current_row_of_id; i++) {
                 if(checkValue($('#designpost-'+current_section+'-row-price-'+i+'').val() ) == 0 ) {
                    continue;
                 }
                 else {

                   if(checkValue( $('#designpost-'+current_section+'-row-weight-'+i+'').val()) == 0 ) {
                     // alert("Metal Weight should be number only.")
                     return;
                     // continue;
                   }
                   if(checkValue( $('#designpost-'+current_section+'-row-price-'+i+'').val()) == 0 ) {
                     // alert("Metal Weight should be number only.")
                     return;
                     // continue;
                   }
                   var weight = $('#designpost-'+current_section+'-row-weight-'+i+'').val()
                   var price = $('#designpost-'+current_section+'-row-price-'+i+'').val()
                   var stone_value = parseFloat(weight) * parseFloat(price);
                   $('#designpost-'+current_section+'-row-stone_value-'+i+'').val(stone_value.toFixed(2))

                   if(checkValue( $('#designpost-'+current_section+'-row-purchase_price-'+i+'').val()) == 0 ) {
                     // alert("Metal Weight should be number only.")
                     return;
                     // continue;
                   }
                   var purchase_price = $('#designpost-'+current_section+'-row-purchase_price-'+i+'').val()
                   var sale_price = parseFloat(purchase_price) * 1.5;
                   $('#designpost-'+current_section+'-row-sale_price-'+i+'').val(sale_price.toFixed(2))

                 }
               }


               var total_stone_sum = 0;
               // calculation ----------------
               var current_row_of_id = parseInt($("#designpost-current_row-"+current_section).val())
                  for(let i=0; i<=current_row_of_id; i++) {
                    if( checkValue( $('#designpost-'+current_section+'-row-qty-'+i+'').val() ) == 0 ) {
                       continue;
                    }
                    else {
                      total_stone_sum =  parseFloat(total_stone_sum) + parseFloat($('#designpost-'+current_section+'-row-qty-'+i+'').val())
                    }
                  }
              $("#designpost-total_stone-"+current_section).val(parseFloat(total_stone_sum).toFixed(2))

              var tcw_sum = 0;
              // calculation ----------------
              var current_row_of_id = parseInt($("#designpost-current_row-"+current_section).val())
                 for(let i=0; i<=current_row_of_id; i++) {
                   if(checkValue( $('#designpost-'+current_section+'-row-weight-'+i+'').val() ) == 0 ) {
                      continue;
                   }
                   else {
                     tcw_sum =  parseFloat(tcw_sum) + parseFloat($('#designpost-'+current_section+'-row-weight-'+i+'').val())
                   }
                 }
             $("#designpost-tcw-"+current_section).val(parseFloat(tcw_sum).toFixed(2))


             var extra_column_1_sum = 0;
             extra_column_1_sum = parseFloat(extra_column_1_sum)  + parseFloat(metal_value_including_wastage) + parseFloat(total_labour_sum) + parseFloat(value_addition_silver) + parseFloat(rhodium) + parseFloat(gold_plating) + parseFloat(pd);
             // calculation ----------------
             var current_row_of_id = parseInt($("#designpost-current_row-"+current_section).val())
                for(let i=0; i<=current_row_of_id; i++) {
                  if(checkValue( $('#designpost-'+current_section+'-row-stone_value-'+i+'').val() ) == 0 ) {
                     continue;
                  }
                  else {
                    extra_column_1_sum =  parseFloat(extra_column_1_sum) + parseFloat($('#designpost-'+current_section+'-row-stone_value-'+i+'').val())
                  }
                }
            $("#designpost-extra_column_1-"+current_section).val(parseFloat(extra_column_1_sum).toFixed(2))

            // calculation ----------------
            var extra_column_2 = parseFloat(extra_column_1_sum) - parseFloat(price_in_usd) ;
            $("#designpost-extra_column_2-"+current_section).val(extra_column_2.toFixed(2))


          }


       function performAllCalculation() {

          for(let j=0; j<$(".section_id-class").length; j++)
          {
             var id = $(".section_id-class")[j].defaultValue;
             var current_row_of_id = parseInt($("#designpost-current_row-"+id).val())
                for(let i=0; i<=current_row_of_id; i++) {
                  if($('#designpost-product_type-'+id+'').val() == undefined ) {
                     continue;
                  }
                  else {
                    performCalculation(id)
                  }
                }
          }
       }



   function callDuplicateMethod(last_id, last_insert_id)
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


 function duplicateData(id, i) {
      var current_row = $("#designpost-current_row-"+id).val();
      current_row = parseInt(current_row);
      var formData = new FormData();


       formData.append('row_id', id);
       formData.append('current_row', current_row);

       formData.append('labour_type[]', $('#designpost-'+id+'-row-labour_type-'+i+'').val());
       formData.append('labour_value[]', $('#designpost-'+id+'-row-labour_value-'+i+'').val());
       formData.append('labour_rate[]', $('#designpost-'+id+'-row-labour_rate-'+i+'').val());
       formData.append('gem_variation[]', $('#designpost-'+id+'-row-gem_variation-'+i+'').val());
       formData.append('stone[]', $('#designpost-'+id+'-row-stone-'+i+'').val());
       formData.append('shape[]', $('#designpost-'+id+'-row-shape-'+i+'').val());
       formData.append('cut[]', $('#designpost-'+id+'-row-cut-'+i+'').val());
       formData.append('setting[]', $('#designpost-'+id+'-row-setting-'+i+'').val());
       formData.append('setting_rate[]', $('#designpost-'+id+'-row-setting_rate-'+i+'').val());
       formData.append('l[]', $('#designpost-'+id+'-row-l-'+i+'').val());
       formData.append('w[]', $('#designpost-'+id+'-row-w-'+i+'').val());
       formData.append('qty[]', $('#designpost-'+id+'-row-qty-'+i+'').val());
       formData.append('weight[]', $('#designpost-'+id+'-row-weight-'+i+'').val());
       formData.append('price[]', $('#designpost-'+id+'-row-price-'+i+'').val());
       formData.append('stone_value[]', $('#designpost-'+id+'-row-stone_value-'+i+'').val());
       formData.append('purchase_price[]', $('#designpost-'+id+'-row-purchase_price-'+i+'').val());
       formData.append('sale_price[]', $('#designpost-'+id+'-row-sale_price-'+i+'').val());


    $.ajax({
                url: '{{  url("quotation/quotation_design_1/duplicateMoreData") }}',
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



</script>
