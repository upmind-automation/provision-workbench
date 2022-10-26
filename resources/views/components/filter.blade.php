@if(Request::get($filter_param) == $filter_value)
    <strong>{{ $slot }}</strong> <a data-tooltip="Remove filter" href="{{ Request::fullUrlWithQuery([$filter_param => '']) }}"><i class="zoom-out icon link black"></i></a>
@else
    {{ $slot }} <a data-tooltip="Add filter" href="{{ Request::fullUrlWithQuery([$filter_param => $filter_value]) }}"><i class="small zoom-in icon link black"></i></a>
@endif