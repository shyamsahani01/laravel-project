@extends('admin.layout.app')

@section('content')
<style>
.FixedHeightContainer
{
  height: 500px;
  padding:3px;
  background:#000;
}
.Content
{
  height:500px;
 overflow:auto;
    background:#fff;
}
</style>

<div class="main-panel">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                    <div class="card">
                        <div class="card-header card-header-primary" style="background: white;">
                            <h4 class="card-title " style="color: black;font-size: 18px;font-weight: bold;margin-top: 10px;text-shadow: 5px 5px 5px lightgrey, 3px 3px 5px lightgrey;">{{ $title }}</h4>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ url('/attendanceessl/Overtimeexport') }}">
                                <div class="row">
                                   {{--  <div class="col-md-3">
                                        <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                                            <input placeholder="Employee Name" type="text" name="employee_name" value="{{ request()->employee_name }}" class="form-control">
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                                            <input placeholder="Select date" type="date" name="start_date"
                                                value="{{ request()->start_date }}" class="form-control" max="{{  \Carbon\Carbon::now()->todatestring() }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="date-picker-example" class="md-form md-outline input-with-post-icon datepicker">
                                            <input placeholder="Select date" name="end_date" type="date"
                                                value="{{ request()->end_date }}" class="form-control" max="{{  \Carbon\Carbon::now()->todatestring() }}">
                                        </div>
                                    </div>
                                    @php
                                        $yesterday_date = \Carbon\Carbon::yesterday()->todatestring();
                                        $today_date = \Carbon\Carbon::now()->todatestring();
                                    @endphp
                                    <div class="col-md-4">
                                        <div class="">
                                         <a href="javascript:void(0)" title="Export" ><button type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"></i></button> </a>
                                         <a href="{{ url('/attendanceessl/export?start_date='.$yesterday_date.'&end_date='.$today_date) }}"  title="Refresh" class="btn btn-danger"><i class="fa fa-refresh"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('footer-scripts')

@endsection
