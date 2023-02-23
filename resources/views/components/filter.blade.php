@if(Request::has($filter_param) && Request::get($filter_param) == $filter_value)
    @if($strong ?? false)<strong>{{ $slot }}</strong>@else{{ $slot }}@endif @if($remove ?? false)<a data-tooltip="Remove filter" href="{{ Request::fullUrlWithQuery([$filter_param => '']) }}"><i class="zoom-out icon link black"></i></a>@endif
@else
    {{ $slot }} <a data-tooltip="Add filter" href="{{ Request::fullUrlWithQuery([$filter_param => $filter_value]) }}"><i class="small zoom-in icon link black"></i></a>
@endif