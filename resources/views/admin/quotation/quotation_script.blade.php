
<!-- confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Design</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <h5 class="modal-title" >Are you sure ?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" id="deleteForm-button" onclick="deleteForm(0)" class="btn btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>


<!-- confirm Modal -->
<div class="modal fade" id="confirmDuplicateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Duplicate Design</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <h5 class="modal-title" >Are you sure ?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" id="duplicateForm-button" onclick="duplicateForm(0)" class="btn btn-success">Yes</button>
      </div>
    </div>
  </div>
</div>

<!-- modal button code -->
<div class="modal fade" id="selectDesignModalImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">View Design</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <img src="/admin/assets/img/city-profile.jpg" id="modal_product_image" class="modal_product_image_center">
      </div>
     </div>
  </div>
</div>
<!-- modal button code -->
<div class="modal fade" id="selectDesignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Select Design</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <button type="button" onclick="closeSelectDesignModal()" class="btn btn-primary" data-toggle="modal" href="#design3DModal">3D Design</button>
       <button type="button" onclick="closeSelectDesignModal()" class="btn btn-primary" data-toggle="modal" href="#design2DModal">2D Design</button>
       <button type="button" onclick="closeSelectDesignModal()" class="btn btn-primary" data-toggle="modal" href="#designSystemModal">System</button>
      </div>
     </div>
  </div>
</div>

<!-- 3D modal code -->
<div class="modal fade" id="design3DModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">3D Design</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form method="GET" id="3d_design_form" action="">
            <input type="hidden" name="design_row_id" class="design_row_id" id="2d_design_row_id" value="" >
            <div class="x_content">
               <div class="row" style="margin-left: 8px;">
                  <div class="col-md-3 col-sm-12  form-group">
                     <select name="design_category" class="form-control">
                        <option value="">Design Category</option>
                        @if( isset($design_category_data) )
                          @foreach($design_category_data as $key => $value)
                          <option value="{{ $value->design_category }}">{{ $value->design_category }} </option>
                          @endforeach
                        @endif
                     </select>
                  </div>
                  <div class="col-md-3 col-sm-12  form-group">
                     <input type="text" name="design_code" placeholder="Design Code" class="form-control" value="">
                  </div>
                  <div class="col-md-4 col-sm-12  form-group">
                     <input type="text" name="description" placeholder="Description" class="form-control" value="">
                  </div>
                  <div class="col-md-2 col-sm-6">
                     <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
                  </div>
               </div>
            </div>
         </form>
         <div class="card-body">
            <div class="table-responsive scroll_table_design">
               <table id="3d_design_table" class="table table-striped table-bordered" style="width:100%;">
                  <thead>
                     <tr style="text-align: center">
                        <th style="width: 40%;">Image</th>
                        <th>Design Code</th>
                        <th>Design Category</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody id="3d_design_table-tbody">
                     <tr>
                        <td colspan="4">No Result Found</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
     </div>
  </div>
</div>

<!-- 2D modal code -->
<div class="modal fade" id="design2DModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">2D Design</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="GET" id="2d_design_form" action="">
           <input type="hidden" name="design_row_id" class="design_row_id" id="2d_design_row_id" value="" >
            <div class="x_content">
               <div class="row" style="margin-left: 8px;">
                  <div class="col-md-3 col-sm-12  form-group">
                     <select name="product_category" class="form-control">
                        <option value="">Product Category</option>
                        @if( isset($product_category_data) )
                          @foreach($product_category_data as $key => $value)
                          <option value="{{ $value->product_category }}">{{ $value->product_category }} </option>
                          @endforeach
                        @endif
                     </select>
                  </div>
                  <div class="col-md-3 col-sm-12  form-group">
                     <input type="text" name="design_code" placeholder="Design Code" class="form-control" value="">
                  </div>
                  <div class="col-md-4 col-sm-12  form-group">
                     <input type="text" name="description" placeholder="Description" class="form-control" value="">
                  </div>
                  <div class="col-md-2 col-sm-6">
                     <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i></button>
                  </div>
               </div>
            </div>
         </form>
         <div class="card-body">
            <div class="table-responsive scroll_table_design">
               <table id="2d_design_table" class="table table-striped table-bordered" style="width:100%;">
                  <thead>
                     <tr style="text-align: center">
                        <th style="width: 40%;">Image</th>
                        <th>Design Code</th>
                        <th>Product Category</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody id="2d_design_table-tbody">
                     <tr>
                        <td colspan="4">No Result Found</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
     </div>
  </div>
</div>

<!-- system modal code -->
<div class="modal fade" id="designSystemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">System</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="GET" id="system_design_form"  action="">
           <input type="hidden" name="design_row_id" class="design_row_id" id="system_design_row_id" value="" >
           <input type="hidden" name="design_type"  id="system_design_row_id" value="system" >
            <div class="x_content">
               <div class="row" style="margin-left: 8px;">
                  <div class="col-md-4 col-sm-12  form-group">
                     <label>Select File</label>
                     <input type="file" name="image" onchange="addImageFromSystem()" class="form-control" accept="image/*" >
                  </div>
               </div>
            </div>
         </form>
      </div>
     </div>
  </div>
</div>



  <script>
  function selectLib() {
      $( ".select2-lib-dropdown" ).select2();
  }

  function customer_name_select2() {
      $(".select2-lib-dropdown-customer_name").select2({
        placeholder: "Select a Customer",
        ajax: {
          url: '/getDataList',
          data: function (params) {
            var query = {
              search: params.term,
              type: 'customer_name'
            }
            return query;
          },
          dataType: 'json',
          processResults: function (data) {
              return data;
          }
        }
      })
  }

  customer_name_select2();


  // product_type_array=[{id:"Anklet", text:"Anklet"},
  //                         {id:"Baju Band", text:"Baju Band"},
  //                         {id:"Beads", text:"Beads"},
  //                         {id:"Bracelet", text:"Bracelet"},
  //                         {id:"Brooch", text:"Brooch"},
  //                         {id:"Button", text:"Button"},
  //                         {id:"Chain", text:"Chain"},
  //                         {id:"Charms", text:"Charms"},
  //                         {id:"Cuff", text:"Cuff"},
  //                         {id:"Cuff Link", text:"Cuff Link"},
  //                         {id:"Earrings", text:"Earring"},
  //                         {id:"Earring Cuff Link", text:"Earring Cuff Link"},
  //                         {id:"Finding", text:"Finding"},
  //                         {id:"Hair Pin", text:"Hair Pin"},
  //                         {id:"Lock", text:"Lock"},
  //                         {id:"Loop", text:"Loop"},
  //                         // {id:"Mang Tika", text:"Mang Tika"},
  //                         // {id:"Mouth Orgon", text:"Mouth Orgon"},
  //                         {id:"Necklace", text:"Necklace"},
  //                         {id:"Nose Pin", text:"Nose Pin"},
  //                         // {id:"Others", text:"Others"},
  //                         // {id:"Pen", text:"Pen"},
  //                         {id:"Pendant", text:"Pendant"},
  //                         {id:"Ring", text:"Ring"},
  //                         {id:"Set", text:"Set"},
  //                         // {id:"Spec", text:"Spec"},
  //                         // {id:"Stone Painting Design", text:"Stone Painting Design"},
  //                         {id:"Toe Ring", text:"Toe Ring"},
  //                         {id:"Twister Wire", text:"Twister Wire"}
  //                       ];
  // function product_type_select2() {
  //     $(".select2-lib-dropdown-product_type").select2({
  //       placeholder: "Product",
  //       data : product_type_array
  //       // ajax: {
  //       //   url: '/getDataList',
  //       //   data: function (params) {
  //       //     var query = {
  //       //       search: params.term,
  //       //       type: 'product_type',
  //       //     }
  //       //     return query;
  //       //   },
  //       //   dataType: 'json',
  //       //   processResults: function (data) {
  //       //       return data;
  //       //   }
  //       // }
  //     })
  // }
  // product_type_select2();


  function product_type_select2() {
      $(".select2-lib-dropdown-product_type").select2({
        placeholder: "Product",
        // data : product_type_array
        ajax: {
          url: '/getDataList',
          data: function (params) {
            var query = {
              search: params.term,
              type: 'product_type',
            }
            return query;
          },
          dataType: 'json',
          processResults: function (data) {
              return data;
          }
        }
      })
  }
  product_type_select2();


  function metal_type_select2() {
      $(".select2-lib-dropdown-metal_type").select2({
        placeholder: "Metal Type",
        ajax: {
          url: '/getDataList',
          data: function (params) {
            var query = {
              search: params.term,
              type: 'metal_type',
            }
            return query;
          },
          dataType: 'json',
          processResults: function (data) {
              return data;
          }
        }
      })
  }
  metal_type_select2();


  function metal_name_select2() {
      $(".select2-lib-dropdown-metal_name").select2({
        placeholder: "Metal",
        ajax: {
          url: '/getDataList',
          data: function (params) {
            var metal_type_td = $($(this)).closest('td').siblings('td.metal_type')
            var metal_type_val = ""
            if( $(metal_type_td).children().length > 0) {
              var metal_type_input = $(metal_type_td).children()[0]
              metal_type_val = $(metal_type_input).val()
            }
            var query = {
              search: params.term,
              type: 'metal_name',
              metal_type: metal_type_val,
            }
            return query;
          },
          dataType: 'json',
          processResults: function (data) {
              return data;
          }
        }
      })
  }
  metal_name_select2();


  // var labour_type_array=[
  //                         {id:"Chain Labour", text:"Chain Labour"},
  //                         {id:"CFP", text:"CFP"},
  //                         {id:"Total Setting Charge", text:"Total Setting Charge"},
  //                         {id:"Finding", text:"Finding"},
  //                         {id:"Packing, PD and other Miss.", text:"Packing, PD and other Miss."},
  //                         // {id:"Plating Type-Casting", text:"Plating Type-Casting"},
  //                         // {id:"Plating Type-Chains", text:"Plating Type-Chains"}
  //                         {id:"Plating Type", text:"Plating Type"}
  //                       ];
  // function labour_type_select2() {
  //     $(".select2-lib-dropdown-labour_type").select2({
  //       placeholder: "Unit",
  //       data : labour_type_array
  //     })
  // }
  // labour_type_select2();


  function labour_type_select2() {
      $(".select2-lib-dropdown-labour_type").select2({
        placeholder: "Unit",
        ajax: {
          url: '/getDataList',
          data: function (params) {
            var query = {
              search: params.term,
              type: 'labour_type',
            }
            return query;
          },
          dataType: 'json',
          processResults: function (data) {
              return data;
          }
        }
      })
  }
  labour_type_select2();


  function setting_charge_select2() {
      $(".select2-lib-dropdown-setting_charge").select2({
        placeholder: "Setting Charge",
        ajax: {
          url: '/getDataList',
          data: function (params) {
            var query = {
              search: params.term,
              type: 'setting_charge',
            }
            return query;
          },
          dataType: 'json',
          processResults: function (data) {
              return data;
          }
        }
      })
  }
  setting_charge_select2();


  // function plating_type_select2() {
  //     $(".select2-lib-dropdown-plating_type").select2({
  //       // dropdownCssClass : 'bigdrop',
  //       placeholder: "Plating Type",
  //       ajax: {
  //         url: '/getDataList',
  //         data: function (params) {
  //           var query = {
  //             search: params.term,
  //             type: 'plating_type',
  //           }
  //           return query;
  //         },
  //         dataType: 'json',
  //         processResults: function (data) {
  //             return data;
  //         }
  //       }
  //     })
  // }
  // plating_type_select2();


  function plating_casting_select2() {
      $(".select2-lib-dropdown-plating_casting").select2({
        // dropdownCssClass : 'bigdrop',
        placeholder: "Casting",
        ajax: {
          url: '/getDataList',
          data: function (params) {
            var query = {
              search: params.term,
              type: 'plating_casting',
            }
            return query;
          },
          dataType: 'json',
          processResults: function (data) {
              return data;
          }
        }
      })
  }
  plating_casting_select2();


  function plating_chains_select2() {
      $(".select2-lib-dropdown-plating_chains").select2({
        // dropdownCssClass : 'bigdrop',
        placeholder: "Chains",
        ajax: {
          url: '/getDataList',
          data: function (params) {
            var query = {
              search: params.term,
              type: 'plating_chains',
            }
            return query;
          },
          dataType: 'json',
          processResults: function (data) {
              return data;
          }
        }
      })
  }
  plating_chains_select2();


  function stone_name_select2() {
      $(".select2-lib-dropdown-stone_name").select2({
        placeholder: "Stone",
        ajax: {
          url: '/getDataList',
          data: function (params) {
            var query = {
              search: params.term,
              type: 'stone_name',
            }
            return query;
          },
          dataType: 'json',
          processResults: function (data) {
              return data;
          }
        }
      })
  }
  stone_name_select2();


  function stone_cut_select2() {
      $(".select2-lib-dropdown-stone_cut").select2({
        placeholder: "Stone Cut",
        ajax: {
          url: '/getDataList',
          data: function (params) {
            var query = {
              search: params.term,
              type: 'stone_cut',
            }
            return query;
          },
          dataType: 'json',
          processResults: function (data) {
              return data;
          }
        }
      })
  }
  stone_cut_select2();


  function stone_shape_select2() {
      $(".select2-lib-dropdown-stone_shape").select2({
        placeholder: "Shape",
        ajax: {
          url: '/getDataList',
          data: function (params) {
            var query = {
              search: params.term,
              type: 'stone_shape',
            }
            return query;
          },
          dataType: 'json',
          processResults: function (data) {
              return data;
          }
        }
      })
  }
  stone_shape_select2();

  function stone_size_l_select2() {
      $(".select2-lib-dropdown-stone_size_l").select2({
        placeholder: "Length",
        ajax: {
          url: '/getDataList',
          data: function (params) {
            var query = {
              search: params.term,
              type: 'stone_size_l',
            }
            return query;
          },
          dataType: 'json',
          processResults: function (data) {
              return data;
          }
        }
      })
  }
  stone_size_l_select2();

  function stone_size_w_select2() {
      $(".select2-lib-dropdown-stone_size_w").select2({
        placeholder: "Width",
        ajax: {
          url: '/getDataList',
          data: function (params) {
            var query = {
              search: params.term,
              type: 'stone_size_w',
            }
            return query;
          },
          dataType: 'json',
          processResults: function (data) {
              return data;
          }
        }
      })
  }
  stone_size_w_select2();



  function stone_diamond_quality_select2() {
      $(".select2-lib-dropdown-stone_diamond_quality").select2({
        placeholder: "Quality",
        ajax: {
          url: '/getDataList',
          data: function (params) {
            var query = {
              search: params.term,
              type: 'stone_diamond_quality',
            }
            return query;
          },
          dataType: 'json',
          processResults: function (data) {
              return data;
          }
        }
      })
  }
  stone_diamond_quality_select2();


  function setting_type_select2() {
      $(".select2-lib-dropdown-setting_type").select2({
        placeholder: "Setting",
        ajax: {
          url: '/getDataList',
          data: function (params) {
            var query = {
              search: params.term,
              type: 'setting_type',
            }
            return query;
          },
          dataType: 'json',
          processResults: function (data) {
              return data;
          }
        }
      })
  }
  setting_type_select2();

  function price_unit_select2() {
    $(".select2-lib-dropdown-price_unit").select2({
      placeholder: "Unit",
      ajax: {
        url: '/getDataList',
        data: function (params) {
          var query = {
            search: params.term,
            type: 'price_unit',
          }
          return query;
        },
        dataType: 'json',
        processResults: function (data) {
            return data;
        }
      }
    })
  }
  price_unit_select2();

  </script>



<script>
$("#3d_design_form").on("submit", function(e) {
     e.preventDefault();
     $.ajax({
              url: '{{  url("quotation/get_3d_design_data") }}',
              cache: false,
              headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
              type: "post",
              data: $('#3d_design_form').serialize(),
              dataType: "json",
              // processData: false,
              // contentType: false,
              beforeSend: function (obj) {
                $('#loader').removeClass('hidden')
              },
              success: function(obj){
                $('#loader').addClass('hidden')
                var html_data = ""
                 if(obj.status) {

                     if(obj.data.length > 0) {
                        for(let i=0; i<obj.data.length; i++) {
                           html_data += "<tr style='text-align: center;'>"
                           html_data += "  <td> <img src='https://erp.pinkcityindia.com"+obj.data[i].image+"'  class=\"table-design_img zoom-images\" ></td>"
                           html_data += "  <td>"+ (obj.data[i]['design_3d_code'] == null ? "" : obj.data[i]['design_3d_code']) +"</td>"
                           html_data += "  <td>"+obj.data[i].design_category+"</td>"
                           // html_data += '  <td><a href="javascript:void(0)" onclick="getDesignImage(\''+obj.data[i].name+'\', \'3d\', '+$(".design_row_id").val()+')" class="btn btn-success btn_space"><i class="fa fa-flash"></i></a></td>'
                           html_data += '  <td><a href="javascript:void(0)" onclick="getDesignImage(\''+obj.data[i].name+'\', \'3d\', '+$(".design_row_id").val()+', \''+obj.data[i].design_category+'\')" class="btn btn-success design1-form1-btn">Submit</a></td>'
                        html_data += "<tr>"
                        }
                        $("#3d_design_table-tbody").html(html_data)

                        zoomImages();
                     }
                     else {
                        $("#3d_design_table-tbody").html("<tr><td colspan='4'>No Result Found</td></tr>")
                     }
                    // alert(obj.msg)
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
  })
$("#2d_design_form").on("submit", function(e) {
       e.preventDefault();
       $.ajax({
                url: '{{  url("quotation/get_2d_design_data") }}',
                cache: false,
                headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                type: "post",
                data: $('#2d_design_form').serialize(),
                dataType: "json",
                // processData: false,
                // contentType: false,
                beforeSend: function (obj) {
                  $('#loader').removeClass('hidden')
                },
                success: function(obj){
                  $('#loader').addClass('hidden')
                  var html_data = ""
                   if(obj.status) {

                     if(obj.data.length > 0) {
                      for(let i=0; i<obj.data.length; i++) {
                        html_data += "<tr style='text-align: center;'>"
                        html_data += "  <td> <img src='https://erp.pinkcityindia.com"+obj.data[i].image+"' class=\"table-design_img zoom-images\" ></td>"
                        html_data += "  <td>"+ (obj.data[i]['design_code'] == null ? "" : obj.data[i]['design_code']) +"</td>"
                        html_data += "  <td>"+obj.data[i].product_category+"</td>"
                        // html_data += '  <td><a href="javascript:void(0)" onclick="getDesignImage(\''+obj.data[i].name+'\', \'2d\', '+$(".design_row_id").val()+')" class="btn btn-success btn_space"><i class="fa fa-flash"></i></a></td>'
                        html_data += '  <td><a href="javascript:void(0)" onclick="getDesignImage(\''+obj.data[i].name+'\', \'2d\', '+$(".design_row_id").val()+', \''+obj.data[i].product_category+'\')" class="btn btn-success design1-form1-btn">Submit</a></td>'
                        html_data += "<tr>"
                      }
                       $("#2d_design_table-tbody").html(html_data)

                       zoomImages();
                     }
                     else {
                        $("#2d_design_table-tbody").html("<tr><td colspan='4'>No Result Found</td></tr>")
                     }

                      // alert(obj.msg)
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
    })
  function updateDesignRawID(id) {
        $(".design_row_id").attr("value", id)
        $("#3d_design_table-tbody").html("<tr><td colspan='4'>No Result Found</td></tr>")
        $("#2d_design_table-tbody").html("<tr><td colspan='4'>No Result Found</td></tr>")
        $("#system_design_form").trigger("reset")
        $("#3d_design_form").trigger("reset")
        $("#2d_design_form").trigger("reset")

  }
 function getDesignImage(design_unique_name, design_type, row_id, product_type)
 {
    $.ajax({
             url: '{{  url("quotation/getDesignImage") }}',
             cache: false,
             headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
             type: "post",
             data: {"design_unique_name": design_unique_name, "design_type": design_type, "row_id": row_id},
             dataType: "json",
             beforeSend: function (obj) {
               $('#loader').removeClass('hidden')
             },
             success: function(obj){
               $('#loader').addClass('hidden')
               var html_data = ""
                if(obj.status) {
                   $("#designpost-image-"+row_id).attr("value", obj.data)
                   $("#designpost-image_type-"+row_id).attr("value", design_type)
                   var image_tag = "";
                   image_tag += '<img  id="designpost-img_src-'+row_id+'" src="{{ env("APP_URL"); }}/storage/design_img/'+obj.data+'" class="table-design_img zoom-images">';
                   $("#designpost-image_src-"+row_id).html(image_tag)
                   $("#design3DModal").modal('hide')
                   $("#design2DModal").modal('hide')

                   // for Anna Design
                   $("#designpost-product_code-"+row_id).attr("value", design_unique_name);


                   var check_1 = 0;

                   // check_product_type(product_type, row_id)

                   // $("#designpost-product_type-"+row_id).val(product_type)
                   // $("#designpost-product_type-"+row_id).trigger("change")

                   if(product_type == "Earring") {
                     product_type = "Earrings"
                   }

                   check_product_type(product_type, row_id)



                   // for(let i = 0; i<product_type_array.length; i++) {
                   //   if(product_type_array[i].text == product_type) { check_1 = 1; break;}
                   //   // if(product_type_array[i].id == product_type) { check_1 = 1; break;}
                   // }
                   //
                   // if(check_1 == 1) {
                   //   $("#designpost-product_type-"+row_id).val(product_type)
                   //   $("#designpost-product_type-"+row_id).trigger("change")
                   //   // $("#designpost-product_type-"+row_id).empty().trigger("change")
                   // }

                   zoomImages();
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

function check_product_type(product_type, row_id) {

  $.ajax({
           url: '{{  url("/getDataList") }}',
           cache: false,
           headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
           type: "get",
           data: {"product_type": product_type, "row_id": row_id, "type": "check_product_type"},
           dataType: "json",
           beforeSend: function (obj) {
             // $('#loader').removeClass('hidden')
           },
           success: function(obj){
             // $('#loader').addClass('hidden')
             var html_data = ""
              if(obj.status) {
                var newOption = $("<option selected='selected'></option>").val(product_type).text(product_type)
                $("#designpost-product_type-"+row_id).append(newOption).trigger('change');
              }else {
                 $("#designpost-product_type-"+row_id).val('').trigger('change');
              }
           },
           error: function(obj){
             // $('#loader').addClass('hidden')
              var error_msg = ""
              $.each(obj.responseJSON.errors, function (key, val) {
                  error_msg +=  val[0] + "\n";
              });
              alert(error_msg)
           },
       });

}

function closeSelectDesignModal() {
 $("#selectDesignModal").modal('hide')
}
function addImageFromSystem() {
 var formData = new FormData($("#system_design_form")[0]);
 $.ajax({
          url: '{{  url("quotation/getDesignImage") }}',
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
            var html_data = ""
            var row_id = $(".design_row_id").val()
             if(obj.status) {
               $("#designpost-image-"+row_id).attr("value", obj.data)
               $("#designpost-image_type-"+row_id).attr("value", "system")
               var image_tag = "";
               image_tag += '<img id="designpost-img_src-'+row_id+'" src="{{ env("APP_URL"); }}/storage/design_img/'+obj.data+'" class="table-design_img zoom-images">';
               $("#designpost-image_src-"+row_id).html(image_tag)
               $("#designSystemModal").modal('hide')

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
}
$("#system_design_form").on("submit", function (e) {
 e.preventDefault();
})

function displayImageModal(row_id) {
  var default_img_src="{{ env('APP_URL'); }}/img/image-not-found.jpg";
  var row_id_img_src = $("#designpost-img_src-"+row_id).attr("src")
  if(row_id_img_src == undefined) {
    $("#modal_product_image").attr("src", default_img_src)
  } else {
    $("#modal_product_image").attr("src", row_id_img_src)
  }
  $("#selectDesignModalImage").modal("show")
  // console.log(row_id);
}

</script>

<!-- Production -->
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<script>

var toolTip_data = "For Regular Gold : Autual Value + 20 <br>"
toolTip_data += "For Re-Cycled Gold : Autual Value + 30 "
tippy("#gold_rate_toolTip", {
  content: toolTip_data,
  allowHTML: true,
});

toolTip_data = "For Regular Silver : Autual Value + 2 <br>"
toolTip_data += "For Re-Cycled Silver : Autual Value + 4  "
tippy("#silver_rate_toolTip", {
  content: toolTip_data,
  allowHTML: true,
});

toolTip_data = "Design Code Or Product Code From 3D & 2D Images"
tippy("#design_code_html", {
  content: toolTip_data,
  allowHTML: true,
});

toolTip_data = `<p>
                  For Regular & Re-Cycled Gold :: <br>
                  1. ( ( (Gold value with cap added ) / 31.104 ) / 24 ) * Gold Karet <br>
                  2. Now add Metal Weight Casting with 5% cap (default)<br>
                            & Metal Weight Chain with 5% cap (default)<br>
                      The Metal Loss % in both of them
                      If metal is White gold when add White Gold Loss
                            else add Gold Loss <br>
                  3. Multiple 1st valve with 2nd value <br>
                  <br>
                  For Regular & Re-Cycled Silver :: <br>
                  1. Silver value with cap added  / 31.104  <br>
                  2. Now add Metal Weight Casting with 10% cap (default)<br>
                            & Metal Weight Chain with 10% cap (default)<br>
                      The Silver Loss % in both of them <br>
                  3. Multiply 1st valve with 2nd value <br>
                </p> `;
tippy("#value_Of_Metal_html", {
  content: toolTip_data,
  maxWidth: 550,
  allowHTML: true,
});


toolTip_data = `1. CPF :: <br>
                  It will depend on <br>
                   i. Product Type ii. Metal Varients  iii. Metal Weight Casting<br>
                    Metal Weight Casting is min and max value must be between <br>
                  For More Details Check Labour Charge Detail on ERP <br>
                  2. Chain Labour :: Manual entry <br>
                  3. Total Setting Charge :: <br>
                      i. For "WAX"  - It will depend on stone quantity <br>
                      ii. For all other Setting Charge  -  It will depend on Stone Size ( Length & Width) <br>
                      For More Details Check Setting Charge Detials on ERP <br>
                  4. Finding :: <br>
                  5. Packing, PD and other Miss. :: Manual entry <br>
                  6. Plating Type ::  <br>
                     Both Casting and Chain Plating added in single list. <br>
                     Here are two Unit Of Measurement are used for Calculation <br>
                     1. Gram <br>
                      Gram Price * Metal Weight Casting <br>
                      or Gram Price * Metal Weight Chain <br>
                     2. Square Inch <br>
                    There will be input box where user can insert Square Inch value <br>
                    (Square Inch Input value / 625) * Metal Weight Casting <br>
                    or (Square Inch Input value / 625) * Metal Weight Chain <br>
                    `;
tippy("#labour_html", {
  content: toolTip_data,
   maxWidth: 800,
  allowHTML: true,
});


toolTip_data = `<p>
                    Stone Weight From ERP DB * Stone Qty <br>
                    For More Details Check Stone Price on ERP <br>
                  </p>`;
tippy("#stone_weight_html", {
  content: toolTip_data,
  allowHTML: true,
});

toolTip_data = `<p>
                    Stone Purchase Price From ERP DB  <br>
                    For More Details Check Stone Price on ERP <br>
                  </p>`;
tippy("#stone_purchase_price_html", {
  content: toolTip_data,
  allowHTML: true,
});

toolTip_data = `<p>
                  ( (Purchase Price/ 100 ) * Value Added % ) + (Purchase Price) <br>
                  For More Details Check Stone Price on ERP <br>
                  </p>`;
tippy("#sale_price_html", {
  content: toolTip_data,
  allowHTML: true,
});

toolTip_data = `<p>( Sale Price * Stone Weight ) / Conversion Rate </p>`;
tippy("#stone_value_added_per_html", {
  content: toolTip_data,
  allowHTML: true,
});

toolTip_data = `<p>
                  Value of Metal + Total Labour Value <br>
                  For Silver product Plating Charge Will not count <br>
                  For Gold product Pen Plating Charge Will count <br>
                  </p>`;
tippy("#cost_1_html", {
  content: toolTip_data,
  allowHTML: true,
});

toolTip_data = `<p>
                  Total Stone Value  + ( Plating Charge if product is silver)
                  </p>`;
tippy("#cost_2_html", {
  content: toolTip_data,
  allowHTML: true,
});

toolTip_data = `<p>
                  Cost 1 + ( ( Cost 1 / 100 ) * Value Additionl % For Cost 1 )
                  </p>`;
tippy("#value_additionl_Cost1_html", {
  content: toolTip_data,
   maxWidth: 550,
  allowHTML: true,
});

toolTip_data = `<p>Total Stone Value Added <br></p>`;
tippy("#stone_quotation_price_html", {
  content: toolTip_data,
  allowHTML: true,
});


toolTip_data = `<p>Cost 1 + Value Additionl (Cost 1) + Total Stone Value  + ( Plating Charge if product is silver) </p>`;
tippy("#ex_factory_price_html", {
  content: toolTip_data,
  allowHTML: true,
});

toolTip_data = `<p>Ex-Factory Price after apllied discount</p>`;
tippy("#price_after_discount_html", {
  content: toolTip_data,
  allowHTML: true,
});

toolTip_data = `<p>Chain Labour Should be calculated by coasting team
                    and Should be updated here.</p>`;
tippy(".chain_labour_toolTip", {
  content: toolTip_data,
  allowHTML: true,
});

</script>


<script>

function zoomImages() {
  $(".zoom-images").imagezoomsl({
      zoomrange: [5, 5],
      magnifiersize: [250, 250]
  });
}

$("#menu_toggle-icon").on("click", function () {
  // for select 2 dropdown width
  selectLib()

})

$(document).ready(function() {

      $(function() {
        selectLib()
        zoomImages();

        customer_name_select2();
      });
  })


</script>
