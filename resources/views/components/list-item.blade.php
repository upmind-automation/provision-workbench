@php
    use Illuminate\Support\Str;
@endphp

<div class="item @if(!isset($item_url)) cursor-default @endif">
    @if(isset($item_url))
        <a class="content" href="{{ $item_url }}" @if (!Str::startsWith($item_url, url(''))) target="_blank" @endif>
            <span>
                <span class="header">
                    @if(isset($item_icon))<i class="black {{ $item_icon }} icon"></i>@endif
                    {{ $item_label }}
                </span>
                @if(isset($item_description))<span class="description" @if(isset($item_icon)) style="margin-left:2rem;" @endif><small>{{ $item_description }}</small></span>@endif
            </span>
        </a>
    @else
        <span class="content">
            <span>
                <span class="header">
                    @if(isset($item_icon))<i class="{{ $item_icon }} icon"></i>@endif
                    {{ $item_label }}
                </span>
                @if(isset($item_description))<span class="description" @if(isset($item_icon)) style="margin-left:2rem;" @endif><small>{{ $item_description }}</small></span>@endif
            </span>
        </span>
    @endif
</div>