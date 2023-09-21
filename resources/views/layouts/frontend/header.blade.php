<header class="navbar navbar-bright navbar-fixed-top" role="banner">

<div class="container" > <!-- If Needed Left and Right Padding in 'md' and 'lg' screen means use container class -->
  <div class="row" >
    <div class="col-md-4 col-xs-4">
      <a href="{{url('/')}}">   
        <img height="100" width="120" src="{{asset('img/pinkcitylogo.png')}}">
      </a>
      
    </div>
    <div class="col-md-8 mt-2 col-xs-8">
      <h3 class="text-header logo-text">PinkCity JewelHouse Vendor Portal Management</h3>
   </div>
   <div class="pull-right user_header">
       Welcome : @if(auth()->check()) {{auth()->user()->name}} @else {!! Helper::VendorData(collect(request()->segments())->last()) !!} @endif <a href="{{ url('/logout') }}">  |  Logout </a>
  </div>

 </div>
</div>
</header>



