      <div class="top_nav" id="top-nav-content">
         <div class="nav_menu">
            <div class="nav toggle">
               <!-- <a id="menu_toggle"><i class="fa fa-bars"></i></a> -->
               <a id="menu_toggle-icon"><i class="fa fa-bars"></i></a>
            </div>
            <nav class="nav navbar-nav">
               <ul class=" navbar-right">
                  <li class="nav-item dropdown open" style="padding-left: 15px;">
                     <a href="javascript:void(0);" class="user-profile" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                       @php
                          $userName = auth()->user()->name;
                          $nameArr = explode(' ', $userName);
                          $newName = "";
                          $i=0;
                          @endphp
                          @foreach($nameArr as $data)
                             @php
                                $newName = ucwords($data[0]);
                                $i++;
                             @endphp
                             @if($i>=1)
                                @php
                                   break;
                                @endphp
                             @endif
                          @endforeach
                       {{$newName}}
                     </a>
                     <div class="dropdown-menu dropdown-usermenu pull-right" style="top: 2px !important; left: 58px !important;">
                        <a class="dropdown-item @if(auth()->user()->emrDB == 'Mahapura'){{ 'active' }}@endif"
                          @if(auth()->user()->emrDB != 'Mahapura') href="/emporer/set-emrDB?emrDB=Mahapura" @else href="javascript:void(0);" @endif
                           ><i class="fa fa-diamond pull-right"></i>Mahapura</a>
                        <a class="dropdown-item @if(auth()->user()->emrDB == 'Sitapura'){{ 'active' }} @endif"
                          @if(auth()->user()->emrDB != 'Sitapura') href="/emporer/set-emrDB?emrDB=Sitapura" @else href="javascript:void(0);" @endif
                          ><i class="fa fa-diamond pull-right"></i>Sitapura</a>
                        <a class="dropdown-item" href="{{ url('/logout') }}" ><i class="fa fa-sign-out pull-right"></i> Log Out  </a>
                     </div>

                  </li>
               </ul>
            </nav>
         </div>
      </div>
