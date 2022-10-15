@unless ($breadcrumbs->isEmpty())
    <div class="ui breadcrumb">
        {{-- <a class="section" href="{{ route('home') }}">Home</a> --}}
        @foreach ($breadcrumbs as $breadcrumb)
            @if(!$loop->first)<i class="right angle icon divider"></i>@endif
            @if (!is_null($breadcrumb->url) && !$loop->last)
                <a class="section" href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
            @else
                <div class="section @if($loop->last) active @endif">{{ $breadcrumb->title }}</div>
            @endif
        @endforeach
    </div>
@endunless