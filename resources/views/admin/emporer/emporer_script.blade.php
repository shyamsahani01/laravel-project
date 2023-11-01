
<!-- Datatables -->
<link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('/admin/assets/newTheme/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">


<!-- Datatables -->
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>


<!-- modal button code -->
<div class="modal fade" id="selectDesignImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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



 <script>


 // function zoomImages() {
 //   $(".zoom-images").imagezoomsl({
 //       zoomrange: [5, 5],
 //       magnifiersize: [250, 250]
 //   });
 // }


 function displayImage(id, type) {
   if(type == '3D') {
     $("#modal_product_image").attr("src", $("#design-3D-"+id).attr('src'))
   }
   else if(type == 'LD') {
     $("#modal_product_image").attr("src", $("#design-LD-"+id).attr('src'))
   }
   else {
     $("#modal_product_image").attr("src", $("#design-"+id).attr('src'))
   }

   $("#selectDesignImage").modal("show")
 }

 function getParameterDescription(data, type, this_pointer, data_type, parent_data) {
   $.ajax({
         url: '{{  url("/emporer/get-parameter-description") }}',
         cache: false,
         headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
         type: "get",
         data: {"data" : data, "data_type" : data_type, "parent_data" : parent_data },
         dataType: "json",
         beforeSend: function (obj) {
           // $('#loader').removeClass('hidden')
         },
         success: function(obj){
           console.log(obj)

            if(obj.status) {
              // console.log("hi11")
              if(type == 'table') {
                $(this_pointer).html(data + " (" + obj.data.PDesc + ")")
                $(this_pointer).removeClass("parameter-desc")
              }
              if(type == 'input') {
                $(this_pointer).val(data + " (" + obj.data.PDesc + ")")
                $(this_pointer).removeClass("parameter-desc")
              }
               // alert("OT updated successfully.")

            }else {
               // alert(obj.msg)
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



</script>
