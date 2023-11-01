<div class="col-md-3 left_col" id="left-sidebar">






   <div class="left_col scroll-view">
      <div class="navbar nav_title" style="border: 0;">
      <a href="{{ url('/home') }}" class="site_title" style="text-align: center;"><i><img src="{{asset('img/pinkcityemaillogo.png')}}" height="50" width="60" class="center" alt="image name "></i></a>
      </div>
      <div class="clearfix"></div>
      <!-- menu profile quick info -->
      <div class="profile clearfix">
      </div>
      <!-- /menu profile quick info -->
      <br />
      <!-- sidebar menu -->
      <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
         <div class="menu_section">
            <ul class="nav side-menu">
               @if(auth()->user()->role == 'superadmin' || auth()->user()->role == 'attendance')
               <li class=" @if (Request::segment(1) == 'home') active @endif nav-menu-bar-li"><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Dashboard </a></li>
               <!-- <li class=" @if (Request::segment(1) == 'home') active @endif nav-menu-bar-li"><a href="{{ url('/home') }}"><i class="fa-solid fa-gauge-high fa-fw"></i> Dashboard </a></li> -->
               @endif
               @if(auth()->user()->role == 'superadmin')
               <!-- <li class=" @if (Request::segment(1) == 'vendor-list') active @endif " nav-menu-bar-li><a href="{{ url('vendor-list') }}" ><i class="fa fa-list"></i> Vendor List</a></li> -->
               <li class=" @if (Request::segment(1) == 'adminusers') active @endif nav-menu-bar-li " ><a href="{{ url('adminusers') }}" ><i class="fa fa-list"></i> Admin List</a></li>
               @endif
               </li>
               @if(auth()->user()->role == 'buying' || auth()->user()->role == 'superadmin')
               <li  class=" buying-menu nav-menu-buying-bar-li  @if (Request::segment(1) == 'stockladger' || Request::segment(1) == 'purchaseorder' ) active @endif  " >
                  <a><i class="fa fa-shopping-cart "></i> Buying<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu buying-menu-ul disabled-menu " >
                     <!-- <li class=" @if (Request::segment(1) == 'stockladger') active @endif nav-menu-bar-li" ><a href="{{ url('/stockladger') }}" ><i class="fa fa-globe"></i>Stock Ledger</a></li> -->
                     <!-- <li class=" @if (Request::segment(1) == 'purchaseorder') active @endif nav-menu-bar-li" ><a href="{{ url('/purchaseorder') }}"><i class="fa fa-shopping-cart"></i> Purchase Order</a></li> -->
                     <li class=" @if (Request::segment(1) == 'stockladger') active @endif nav-menu-bar-li" ><a href="{{ url('/stockladger') }}" >Stock Ledger</a></li>
                     <li class=" @if (Request::segment(1) == 'purchaseorder') active @endif nav-menu-bar-li" ><a href="{{ url('/purchaseorder') }}">Purchase Order</a></li>
                  </ul>
               </li>
               <!-- <li class=" @if (Request::segment(1) == 'stockladger') active @endif nav-menu-bar-li" ><a href="{{ url('/stockladger') }}" ><i class="fa fa-globe"></i>Stock Ledger</a></li>
               <li class=" @if (Request::segment(1) == 'purchaseorder') active @endif nav-menu-bar-li" ><a href="{{ url('/purchaseorder') }}"><i class="fa fa-shopping-cart"></i> Purchase Order</a></li> -->
               @endif

               @if(auth()->user()->role == 'attendance' || auth()->user()->role == 'superadmin')
               @php
                $yesterday_date = \Carbon\Carbon::yesterday()->todatestring();
                $today_date = \Carbon\Carbon::now()->todatestring();
               @endphp
               <li id="hr-menu" class=" hr-menu nav-menu-bar-li @if (Request::segment(1) == 'attendance' ||  Request::segment(2) == 'essl' || Request::segment(2) == 'export' || Request::segment(2) == 'export-overtimeview' ||  Request::segment(1) == 'reports') active @endif " >
                  <a><i class="fa fa-user"></i> HR<span class="fa fa-chevron-down"></span></a>
                  <ul id="hr-menu-ul" class="hr-menu-ul nav child_menu disabled-menu" >
                    <li class=" @if (Request::segment(1) == 'attendance' ||  Request::segment(2) == 'essl' || Request::segment(2) == 'export' )  @endif ">
                       <a>Attendance <span class="fa fa-chevron-down"></span></a>
                       <ul class="nav child_menu ">
                         <li class=" @if (Request::segment(1) == 'attendance' )  @endif " ><a href="{{ url('/attendance') }}"  style="font-weight: normal;">Attendance Record ERP</a></li>
                         <li class=" @if (Request::segment(2) == 'essl' )  @endif " ><a href="{{ url('/attendance/essl?start_date='.$yesterday_date.'&end_date='.$today_date) }}" style="font-weight: normal;">Check-In/Out Detail ESSL</a></li>
                         <li class=" @if (Request::segment(2) == 'export' )  @endif " ><a href="{{ url('/attendanceessl/export?start_date='.$yesterday_date.'&end_date='.$today_date) }}"  style="font-weight: normal;">Check-In/Out ESSL Export</a></li>
                       </ul>
                    </li>
                     <li class=" @if (Request::segment(2) == 'export-overtimeview' ) @endif " ><a href="{{ url('/essl/export-overtimeview?start_date='.$yesterday_date.'&end_date='.$today_date) }}" >OverTime Data Export</a></li>
                     @if(auth()->user()->role == 'reports' || auth()->user()->role == 'superadmin')
                     <li class=" @if (Request::segment(1) == 'reports' )  @endif " ><a href="{{ url('/reports') }}">HR Reports</span></a></li>
                     @endif
                     <li class=" @if (Request::segment(2) == 'emp_report' ) @endif " ><a href="{{ url('/hr/employee_report') }}" >Employee Details</a></li>
                       <li><a href="{{ url('/hr/employee_attendance/emp_attendance_report') }}" >Employee Attendance Report</a></li>
                       <li><a href="{{ url('/hr/emp_ot_lesshours/ot_lesshours_report') }}" >OT & Less Hours Report</a></li>
                       <li><a href="{{ url('/hr/bonus_report') }}" >Bonus Report</a></li>
                       <li><a href="{{ url('/hr/leave_details') }}" >Leave Details</a></li>
                       <!-- <li><a href="{{ url('/hr/emp_ot_lesshours/lesshours_report') }}" >Less Hours Report</a></li> -->
                  </ul>
               </li>
               @endif


               @if(auth()->user()->role == 'attendance' || auth()->user()->role == 'superadmin')
               <li id="py-menu" class=" py-menu nav-menu-bar-li @if (Request::segment(1) == 'pf' ||  Request::segment(1) == 'esi' ) active @endif " >
                  <a><i class="fa fa-credit-card"></i>PayRoll<span class="fa fa-chevron-down"></span></a>
                  <ul id="py-menu-ul" class="py-menu-ul nav child_menu disabled-menu" >
                    <li class=" @if (Request::segment(1) == 'pf' )  @endif " >
                        <a>PF <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                           <li class=" @if (Request::segment(2) == 'pf_challan' ) @endif " ><a href="{{ url('/pf/pf_challan') }}"  style="font-weight: normal;">PF Challan</a></li>
                           <li class=" @if (Request::segment(2) == 'pf_statement' ) @endif " ><a href="{{ url('/pf/pf_statement') }}"  style="font-weight: normal;">PF Statement</a></li>
                        </ul>
                     </li>
                     <li>
                        <a class=" @if (Request::segment(1) == 'esi' ) @endif " > ESI <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                           <li class=" @if (Request::segment(2) == 'esi_challan' ) @endif " ><a href="{{ url('/esi/esi_challan') }}"  style="font-weight: normal;">ESI Challan</a></li>
                           <li class=" @if (Request::segment(2) == 'esi_statement' ) @endif " ><a href="{{ url('/esi/esi_statement') }}"  style="font-weight: normal;">ESI Statement</a></li>
                        </ul>
                     </li>
                     <li>
                        <a class=" @if (Request::segment(2) == 'bank_sheet' ) @endif " > Bank Sheet <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                           <li class=" @if (Request::segment(3) == 'hdfc_bank' ) @endif " ><a href="{{ url('/hr/bank_sheet/hdfc_bank') }}"  style="font-weight: normal;">HDFC Bank</a></li>
                           <li class=" @if (Request::segment(3) == 'other_bank' ) @endif " ><a href="{{ url('/hr/bank_sheet/other_bank') }}"  style="font-weight: normal;">Other Bank</a></li>
                        </ul>
                     </li>
                     <li class=" @if (Request::segment(2) == 'salary_sheet' ) @endif " ><a href="{{ url('/hr/salary_sheet') }}" >Salary Sheet</a></li>
                     <li class=" @if (Request::segment(2) == 'salary_sheet_accounts' ) @endif " ><a href="{{ url('/hr/salary_sheet_accounts') }}" >Salary Sheet - Accounts</a></li>
                     <li class=" @if (Request::segment(2) == 'salary_register' ) @endif " ><a href="{{ url('/hr/salary_register') }}" >Salary Register</a></li>
                     <li><a href="{{ url('/payroll/salary_com') }}" >Salary Component Classification</a></li>
                      <li><a href="{{ url('/hr/emp_ot_lesshours/ot_lesshours_report') }}" >OT & Less Hours Report</a></li>
                      <li><a href="{{ url('/hr/compliance_sheet') }}" >Compliance Sheet</a></li>
                     </ul>
               </li>
               @endif



               @if( auth()->user()->role == 'superadmin')
               <li  class=" fg-menu  nav-menu-fg-bar-li  @if (Request::segment(1) == 'fg') active @endif  " >
                  <a><i class="fa fa-file-text "></i> FG Reports<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu fg-menu-ul disabled-menu " >
                     <li class=" @if (Request::segment(2) == 'unit1' || Request::segment(1) == 'fg'  )  @endif " ><a href="{{ url('/fg/unit1/list') }}">Unit - I</span></a></li>
                     <li class=" @if (Request::segment(2) == 'unit2' || Request::segment(1) == 'fg'  )  @endif  " ><a href="{{ url('/fg/unit2/list') }}">Unit - II</span></a></li>
                  </ul>
               </li>
               @endif


               @if(auth()->user()->role == 'superadmin' || auth()->user()->role == 'buying' )
               <!-- <li class=" @if (Request::segment(1) == 'quotation') active @endif "><a href="{{ url('quotation/list') }}" ><i class="fa fa-list-alt"></i> Quotation </a></li> -->
               @endif


                 @if( auth()->user()->role == 'superadmin' )
                 <!-- <li  class=" pd-menu  nav-menu-fg-bar-li  @if (Request::segment(1) == 'production') active @endif  " >
                    <a><i class="fa fa-file-text "></i> Production<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu pd-menu-ul disabled-menu " >
                       <li class=" @if (Request::segment(2) == 'pd-orders' || Request::segment(1) == 'production'  )  @endif " ><a href="{{ url('/production/pd-orders/list') }}">Production Orders</span></a></li>
                    </ul>
                 </li> -->
                 @endif


                  @if( auth()->user()->role == 'superadmin' || auth()->user()->role == 'reports' )
                  <li  class=" emporer-menu  nav-menu-fg-bar-li  @if (Request::segment(1) == 'emporer') active @endif  " >
                     <a><i class="fa fa-diamond "></i> Emporer <span class="fa fa-chevron-down"></span></a>
                     <!-- <a><i class="fa fa-diamond "></i> Emporer <span class="fa fa-chevron-down"></span></a> -->
                     <ul class="nav child_menu emporer-menu-ul disabled-menu " >
                        <li class=" @if (Request::segment(2) == 'design'   ) active  @endif " ><a href="{{ url('/emporer/design/list') }}">Design</span></a></li>
                        <!-- <li class=" @if (Request::segment(2) == 'orders'  ) active  @endif " ><a href="{{ url('/emporer/orders/list') }}">Orders</span></a></li> -->
                        <li class=" @if (Request::segment(2) == 'orders'  || Request::segment(2) == 'bag' ) active @endif ">
                           <a>Orders <span class="fa fa-chevron-down"></span></a>
                           <ul class="nav child_menu ">
                             <li class=" @if (Request::segment(3) == 'list' )  @endif " ><a href="{{ url('/emporer/orders/list') }}"  >Orders List</a></li>
                             <li class=" @if (Request::segment(3) == 'list' )  @endif " ><a href="{{ url('/emporer/bag/list') }}" >Bag</a></li>
                             <li class=" @if (Request::segment(2) == 'finish_good'  ) active  @endif " ><a href="{{ url('/emporer/finish_good/list') }}">Finish Good</span></a></li>
                             <li class=" @if (Request::segment(2) == 'finish_good_bm'  ) active  @endif " ><a href="{{ url('/emporer/finish_good_bm/list') }}">Finish Good - Bag Movement</span></a></li>
                             <!-- <li class=" @if (Request::segment(3) == 'list' )  @endif " ><a href="{{ url('/emporer/bagTransaction/list') }}" >Bag Transaction</a></li> -->
                           </ul>
                        </li>
                        <!-- <li class=" @if (Request::segment(2) == 'bag'  ) active  @endif " ><a href="{{ url('/emporer/bag/list') }}">Bag</span></a></li> -->
                        <li class=" @if (Request::segment(2) == 'transaction'  ) active  @endif " ><a href="{{ url('/emporer/transaction/list') }}">Transaction</span></a></li>
                        <li class=" @if (Request::segment(2) == 'parameter'  ) active  @endif " ><a href="{{ url('/emporer/parameter/list') }}">Parameter</span></a></li>

                        <li class=" @if (Request::segment(2) == 'report'  ) active @endif ">
                           <a>Report <span class="fa fa-chevron-down"></span></a>
                           <ul class="nav child_menu ">
                             <li class=" @if (Request::segment(3) == 'what-is-where' )  @endif " ><a href="{{ url('/emporer/report/what-is-where') }}"  >What Is Where</a></li>
                           </ul>
                        </li>

                     </ul>
                  </li>
                  @endif

                  @if( auth()->user()->role == 'superadmin' )
                  <li  class=" other-menu  nav-menu-other-bar-li  @if (Request::segment(1) == 'essl' || Request::segment(1) == 'jadePowerBiReport' || Request::segment(2) == 'pd-orders' || Request::segment(1) == 'quotation' ) active @endif  " >
                     <a><i class="fa fa-file-text "></i> Other <span class="fa fa-chevron-down"></span></a>
                     <ul  class="other-menu-ul nav child_menu disabled-menu" >
                       <li class=" @if (Request::segment(1) == 'essl' )  @endif " >
                       <a> ESSL<span class="fa fa-chevron-down"></span></a>
                       <ul class="nav child_menu  " >
                          <li class=" @if (Request::segment(2) == 'essl-department' )  @endif " ><a href="{{ url('/essl/essl_department/list') }}">Department</span></a></li>
                          <li class=" @if (Request::segment(2) == 'essl-employee' )  @endif " ><a href="{{ url('/essl/essl_employee/list') }}">Employee</span></a></li>

                          <li class=" @if (Request::segment(2) == 'check_in_local' )  @endif ">
                             <a>Employee Check In Local <span class="fa fa-chevron-down"></span></a>
                             <ul class="nav child_menu ">
                               <li class=" @if (Request::segment(3) == 'list' )  @endif " ><a href="{{ url('/essl/check_in_local/list') }}"  >List</a></li>
                               <li class=" @if (Request::segment(3) == 'add' )  @endif " ><a href="{{ url('/essl/check_in_local/add') }}" >Add</a></li>
                             </ul>
                          </li>
                       </ul>
                      </li>
                      <li class=" @if (Request::segment(1) == 'jadePowerBiReport') active @endif "><a href="{{ url('/jadePowerBiReport/list') }}" >Jade Report </a></li>
                      <li class=" @if (Request::segment(2) == 'pd-orders' || Request::segment(1) == 'production'  )  @endif " ><a href="{{ url('/production/pd-orders/list') }}">Production Orders</span></a></li>
                      <li class=" @if (Request::segment(1) == 'quotation') active @endif "><a href="{{ url('quotation/list') }}" > Quotation </a></li>
                    </ul>
                  </li>
                  @endif


                 @if( auth()->user()->role == 'superadmin')
                 <!-- <li  class=" pd-menu  nav-menu-fg-bar-li  @if (Request::segment(1) == 'essl') active @endif  " >
                    <a><i class="fa fa-file-text "></i> ESSL<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu pd-menu-ul disabled-menu " >
                       <li class=" @if (Request::segment(2) == 'essl-department' )  @endif " ><a href="{{ url('/essl/essl_department/list') }}">Department</span></a></li>
                       <li class=" @if (Request::segment(2) == 'essl-employee' )  @endif " ><a href="{{ url('/essl/essl_employee/list') }}">Employee</span></a></li>

                       <li class=" @if (Request::segment(2) == 'check_in_local' )  @endif ">
                          <a>Employee Check In Local <span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu ">
                            <li class=" @if (Request::segment(3) == 'list' )  @endif " ><a href="{{ url('/essl/check_in_local/list') }}"  >List</a></li>
                            <li class=" @if (Request::segment(3) == 'add' )  @endif " ><a href="{{ url('/essl/check_in_local/add') }}" >Add</a></li>
                          </ul>
                       </li>

                    </ul>
                 </li> -->
                 @endif


                 @if( auth()->user()->role == 'superadmin')
                 <!-- <li  class=" pd-menu  nav-menu-fg-bar-li  @if (Request::segment(1) == 'essl') active @endif  " >
                    <a><i class="fa fa-file-text "></i> Emporer<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu pd-menu-ul disabled-menu " >
                       <li class=" @if (Request::segment(2) == 'essl-department' )  @endif " ><a href="{{ url('/essl/essl_department/list') }}">Orders</span></a></li>
                       <li class=" @if (Request::segment(2) == 'essl-employee' )  @endif " ><a href="{{ url('/essl/essl_employee/list') }}">Bag Order</span></a></li>


                    </ul>
                 </li> -->
                 @endif

                 @if( auth()->user()->role == 'superadmin')
                 <!-- <li class=" @if (Request::segment(1) == 'jadePowerBiReport') active @endif "><a href="{{ url('/jadePowerBiReport/list') }}" ><i class="fa fa-list-alt"></i>Jade Report </a></li> -->

                 @endif


            </ul>
         </div>
      </div>
      <!-- /sidebar menu -->
   </div>
</div>
