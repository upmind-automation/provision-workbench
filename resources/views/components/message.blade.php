@if(isset($message_href)) <a href="{{ $message_href }}" @else <div @endif @if(isset($message_id)) id="{{ $message_id }}" @endif class="ui @if(isset($message_icon)) icon @endif message @if(isset($message_colour)) {{ $message_colour }} @endif" @if(isset($message_cursor)) style="cursor: {{ $message_cursor }}" @endif @if(isset($message_tooltip)) data-tooltip="{{ $message_tooltip }}" @endif>
    @if(isset($message_icon))
        <i class="{{ $message_icon }} icon"></i>
    @endif
    <div class="content">
        @if(isset($message_header))
            <div class="header">
                {{ $message_header }}
            </div>
        @endif
        @if(isset($message_text))
            <p>{{ $message_text }}</p>
        @endif
        {{ $slot }}
    </div>
    @if(isset($message_label))
        <span class="ui top right attached label @if(isset($message_colour)){{ $message_colour }}@endif">
            @if(isset($message_label_icon))<i class="icon clock"></i>@endif {{ $message_label }}
        </span>
    @endif
@if(isset($message_href)) </a @else </div @endif >