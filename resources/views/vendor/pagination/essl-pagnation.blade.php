<div class="page" style="margin-right: -125px;">
@php 

$filter = 'show='.request()->show.'&employee_code='.request()->employee_code.'&employee_name='.request()->employee_name.'&start_date='.request()->start_date.'&end_date='.request()->end_date.'&status='.request()->status.'&shift='.request()->shift.'&company='.request()->company.'&export_data='.request()->export_data;
@endphp 
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
                    @foreach ($element as $page => $url)
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
        {!! __('Showing') !!}
        <span class="font-medium">{{ $paginator->firstItem() }}</span>
        {!! __('to') !!}
        <span class="font-medium">{{ $paginator->lastItem() }}</span>
        {!! __('of') !!}
        <span class="font-medium">{{ $paginator->total() }}</span>
        {!! __('results') !!}
    </p>
</div>