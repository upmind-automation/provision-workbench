<div class="field @if($field_errors ?? []) error @endif @if($field_required ?? false) required @endif">
    @if(isset($field_label))
        <label for="{{ $field_id ?? null }}">
            {{ $field_label }}
            @if($field_validation_rules ?? [])
                <span class="ui inline icon" data-tooltip="{{ implode(' | ', $field_validation_rules) }}" data-inverted>
                    <i class="blue info circle icon"></i>
                </span>
            @endif
        </label>
    @endif
    {{ $slot }}
</div>
@if ($field_errors ?? [])
    @foreach($field_errors ?? [] as $error)
        <div class="ui red pointing label">
            {{ $error }}
            <i class="close icon" onclick="this.parentElement.classList.add('hidden')"></i>
        </div>
    @endforeach
@endif
