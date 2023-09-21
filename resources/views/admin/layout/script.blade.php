<div id="loader" class="lds-dual-ring hidden overlay"></div>



<!-- Bootstrap -->
<script src="{{ asset('/admin/assets/newTheme/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ asset('/admin/assets/newTheme/vendors/fastclick/lib/fastclick.js')}}"></script>
<!-- NProgress -->
<script src="{{ asset('/admin/assets/newTheme/vendors/nprogress/nprogress.js')}}"></script>
<!-- iCheck -->
<script src="{{ asset('/admin/assets/newTheme/vendors/iCheck/icheck.min.js')}}"></script>
<!-- Datatables -->
<!-- <script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
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
<script src="{{ asset('/admin/assets/newTheme/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script> -->
<script src="{{ asset('/admin/assets/newTheme/vendors/jszip/dist/jszip.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{ asset('/admin/assets/newTheme/vendors/pdfmake/build/vfs_fonts.js')}}"></script>
<!-- Custom Theme Scripts -->
<script src="{{ asset('/admin/assets/newTheme/build/js/custom.min.js')}}"></script>

<link href="{{ asset('/admin/assets/newTheme/vendors/Stylish-Magnifying-Glass/demo/assets/style.css')}}" rel="stylesheet">
<script src="{{ asset('/admin/assets/newTheme/vendors/Stylish-Magnifying-Glass/demo/assets/zoomsl.js')}}"></script>



</body>
</html>




    <script>




  $("#menu_toggle-icon").on("click", function () {
    $("#left-sidebar").toggleClass("hide-left-sidebar")
    $("#top-nav-content").toggleClass("remove-left-margin")
    $("#right_col-content").toggleClass("remove-left-margin")

  })



    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');
        $sidebar_img_container = $sidebar.find('.sidebar-background');
        $full_page = $('.full-page');
        $sidebar_responsive = $('body > .navbar-collapse');
        window_width = $(window).width();
        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();
        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
            $('.fixed-plugin .dropdown').addClass('open');
          }
        }
        $('.fixed-plugin a').click(function(event) {
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });
        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');
          $(this).siblings().removeClass('active');
          $(this).addClass('active');
          var new_color = $(this).data('color');
          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }
          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }
          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });
        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');
          var new_color = $(this).data('background-color');
          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });
        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');
          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');
          var new_image = $(this).find("img").attr('src');
          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }
          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');
            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }
          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');
            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }
          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });
        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');
          $input = $(this);
          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }
            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }
            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }
            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }
            background_image = false;
          }
        });
        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');
// https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js
// https://code.jquery.com/jquery-3.5.1.js
// https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js
          $input = $(this);
          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;
            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();
          } else {
            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');
            setTimeout(function() {
              $('body').addClass('sidebar-mini');
              md.misc.sidebar_mini_active = true;
            }, 300);
          }
          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);
          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);
        });
      });
    });
  </script>
  <script>
    // $(document).ready(function() {
    //   // Javascript method's body can be found in assets/js/demos.js
    //   md.initDashboardPageCharts();
    //
    // });
  </script>
