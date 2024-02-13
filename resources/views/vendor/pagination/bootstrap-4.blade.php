<div class="page" style="margin-right: -89px;">
@php
$filter = 'employee_code='.request()->employee_code.'&employee_name='.request()->employee_name.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&status='.request()->status.'&shift='.request()->shift.'&company='.request()->company.'&export_data='.request()->export_data.'&show='.request()->show;
@endphp

@if(request()->segment(1) == 'pf' || request()->segment(1) == 'esi' || request()->segment(3) == 'emp_attendance_report' || request()->segment(2) == 'emp_ot_lesshours' || request()->segment(2) == 'compliance_sheet' )
@php
$filter = 'start_date='.request()->start_date.'&end_date='.request()->end_date.'&company='.request()->company.'&employee_name='.request()->employee_name.'&month='.request()->month.'&year='.request()->year.'&show='.request()->show;
@endphp
@endif

@if(request()->segment(1) == 'fg'  )
@php
$filter = 'start_date='.request()->start_date.'&end_date='.request()->end_date.'&show='.request()->show.'&company='.request()->company;
@endphp
@endif



@if(Request::segment(1) == 'emporer' && Request::segment(2) == 'orders' )
@php
$str = "";
$str .= 'show='.request()->show;
$str .= '&order_start_date='.request()->order_start_date;
$str .= '&order_end_date='.request()->order_end_date;
$str .= '&customer_code='.request()->customer_code;
$str .= '&order_no='.request()->order_no;
$str .= '&expected_order_start_date='.request()->expected_order_start_date;
$str .= '&purchase_order_no='.request()->purchase_order_no;
$str .= '&company='.request()->company;
$str .= '&customer_code='.request()->customer_code;
$filter = $str;
@endphp
@endif

@if(Request::segment(1) == 'emporer' && Request::segment(2) == 'orders-design' )
@php
$str = "";
$str .= 'show='.request()->show;
$str .= '&order_start_date='.request()->order_start_date;
$str .= '&order_end_date='.request()->order_end_date;
$str .= '&customer_code='.request()->customer_code;
$str .= '&order_no='.request()->order_no;
$str .= '&expected_order_start_date='.request()->expected_order_start_date;
$str .= '&purchase_order_no='.request()->purchase_order_no;
$str .= '&company='.request()->company;
$str .= '&customer_code='.request()->customer_code;
$filter = $str;
@endphp
@endif

@if(Request::segment(1) == 'emporer' && Request::segment(2) == 'design' )
@php
$str = "";
$str .= 'show='.request()->show;
$str .= '&design_start_date='.request()->design_start_date;
$str .= '&design_end_date='.request()->design_end_date;
$str .= '&category='.request()->category;
$str .= '&designer_code='.request()->designer_code;
$str .= '&description='.request()->description;
$str .= '&design_code='.request()->design_code;
$filter = $str;
@endphp
@endif

@if(Request::segment(1) == 'emporer' && Request::segment(2) == 'bag' )
@php
$str = "";
$str .= 'show='.request()->show;
$str .= '&bag_open_start_date='.request()->bag_open_start_date;
$str .= '&bag_open_end_date='.request()->bag_open_end_date;
$str .= '&design_code='.request()->design_code;
$str .= '&order_no='.request()->order_no;
$str .= '&bag_no='.request()->bag_no;
$filter = $str;
@endphp
@endif

@if(Request::segment(1) == 'emporer' && Request::segment(2) == 'transaction' )
@php
$str = "";
$str .= 'show='.request()->show;
$str .= '&transaction_start_date='.request()->transaction_start_date;
$str .= '&transaction_end_date='.request()->transaction_end_date;
$str .= '&from_location='.request()->from_location;
$str .= '&to_location='.request()->to_location;
$str .= '&transaction_type='.request()->transaction_type;
$str .= '&voucher_no='.request()->voucher_no;
$filter = $str;
@endphp
@endif

@if(Request::segment(1) == 'emporer' && Request::segment(2) == 'parameter' )
@php
$str = "";
$str .= 'show='.request()->show;
$str .= '&type='.request()->type;
$str .= '&category='.request()->category;
$str .= '&sub_category='.request()->sub_category;
$str .= '&description='.request()->description;
$str .= '&status='.request()->status;
$filter = $str;
@endphp
@endif

@if(Request::segment(1) == 'emporer' && Request::segment(2) == 'finish_good' )
@php
$str = "";
$str .= 'show='.request()->show;
$str .= '&start_date='.request()->start_date;
$str .= '&end_date='.request()->end_date;
$str .= '&from_location='.request()->from_location;
$str .= '&to_location='.request()->to_location;
$str .= '&transaction_type='.request()->transaction_type;
$str .= '&voucher_no='.request()->voucher_no;
$filter = $str;
@endphp
@endif

@if(Request::segment(1) == 'emporer' && Request::segment(2) == 'finish_good_bm' )
@php
$str = "";
$str .= 'show='.request()->show;
$str .= '&start_date='.request()->start_date;
$str .= '&end_date='.request()->end_date;
$str .= '&voucher_no='.request()->voucher_no;
$filter = $str;
@endphp
@endif

@if(Request::segment(1) == 'emporer' && Request::segment(2) == 'invoice' )
@php
$str = "";
$str .= 'show='.request()->show;
$str .= '&start_date='.request()->start_date;
$str .= '&end_date='.request()->end_date;
$str .= '&invoice_no='.request()->invoice_no;
$str .= '&company='.request()->company;
$str .= '&customer_code='.request()->customer_code;
$filter = $str;
@endphp
@endif


@if(Request::segment(1) == 'emporer' &&  Request::segment(2) == 'report' && Request::segment(3) == 'what-is-where' )
@php
$str = "";
$str .= 'show='.request()->show;
$str .= '&order_type='.request()->order_type;
$str .= '&year='.request()->year;
$str .= '&order_start_date='.request()->order_start_date;
$str .= '&order_end_date='.request()->order_end_date;
$str .= '&expected_order_start_date='.request()->expected_order_start_date;
$str .= '&expected_order_end_date='.request()->expected_order_end_date;
$str .= '&customer_code='.request()->customer_code;
$str .= '&company_code='.request()->company_code;
$str .= '&order_no='.request()->order_no;
$filter = $str;
@endphp
@endif


@if($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    @php $seturl1 = $paginator->previousPageUrl().'&'.$filter; @endphp
                    <a class="page-link" href="{{ $seturl1 }}" rel="prev" aria-label="@lang('pagination.previous')"> {!! __('pagination.previous') !!}</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                @php
                $count = 0;
                @endphp
                    @foreach ($element as $page => $url)
                    @php
                    $count++;
                    @endphp
                    @if ($count >= 1)
                      @php
                        // break;
                      @endphp
                      @endif
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            @php $seturl = $url.'&'.$filter; @endphp
                            <li class="page-item"><a class="page-link" href="{{ $seturl }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                    @php $seturl2 = $paginator->nextPageUrl().'&'.$filter; @endphp
                    <a class="page-link" href="{{ $seturl2 }}" rel="next" aria-label="@lang('pagination.next')"> {!! __('pagination.next') !!}</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
</div>
<div class="form-group pull-left showing" style="margin-top:37px;">
    <p class="text-sm text-gray-700 leading-5">
        <span class="font-medium">{{ $paginator->firstItem() }}</span>
       {!! __('to') !!}
        <span class="font-medium">{{ $paginator->total() }}</span>
        {!! __('results') !!}
    </p>
</div>
