@php
    use Illuminate\Support\Str;
    use Upmind\ProvisionBase\Laravel\Html\FormField;

    if (isset($field_options)) {
        // ensure options in the same group are adjacent to eachother
        $field_options = collect($field_options)
            ->groupBy('group_label')
            ->reduce(function ($all, $group) {
                if (empty($group->first()->group_label)) {
                    return $group->merge($all); // prepend options that don't have a group
                }

                return $all->merge($group);
            }, collect());
    }
@endphp

@component('components.html-field-container', [
    'field_id' => $field_id,
    'field_label' => $field_label,
    'field_required' => $field_required ?? false,
    'field_validation_rules' => $field_validation_rules ?? [],
    'field_errors' => $field_errors ?? [],
    'field_read_only' => $field_read_only ?? false,
])
    @switch ($field_type)
        @case(FormField::TYPE_TEXTAREA)
            <textarea
                id="{{ $field_id }}"
                name="{{ $field_name }}"
                class="@if($field_disabled ?? false) disabled @endif {{ implode(' ', $field_classes ?? []) }}"
                @foreach ($field_attributes ?? [] as $attribute => $value)
                    {{ $attribute }}="{{ $value }}"
                @endforeach
                @if($field_styles ?? [])
                    style="{{ implode(';', $field_styles) }}"
                @endif
                @if ($field_required ?? false)
                    required
                @endif
                @if ($field_read_only ?? false)
                    readonly
                @endif
                @if($field_disabled ?? false)
                    disabled
                @endif
                @if($field_autofocus ?? false)
                    autofocus
                @endif
            >{{ trim($field_value ?? '') }}</textarea>
            @break
        @case(FormField::TYPE_CHECKBOX)
            <div class="ui @if ($field_read_only ?? false) read-only @endif fitted checkbox">
                <!-- Default value false for checkbox --><input type="hidden" name="{{ $field_name }}" value="0">
                <input
                    type="checkbox"
                    id="{{ $field_id }}"
                    name="{{ $field_name }}"
                    class="@if($field_disabled ?? false) disabled @endif {{ implode(' ', $field_classes ?? []) }}"
                    @foreach ($field_attributes ?? [] as $attribute => $value)
                        {{ $attribute }}="{{ $value }}"
                    @endforeach
                    @if($field_styles ?? [])
                        style="{{ implode(';', $field_styles) }}"
                    @endif
                    value="1"
                    @if($field_value)
                        checked
                    @endif
                    {{-- @if ($field_required ?? false)
                        required
                    @endif --}}
                    @if ($field_read_only ?? false)
                        readonly
                    @endif
                    @if($field_disabled ?? false)
                        disabled
                    @endif
                    @if($field_autofocus ?? false)
                        autofocus
                    @endif
                />
                <label></label>
            </div>
            @break
        @case(FormField::TYPE_INPUT_RADIO)
            @foreach($field_options ?? [] as $option)
                @php
                    /** @var \Upmind\ProvisionBase\Laravel\Html\OptionData $option */
                @endphp
                <div class="ui @if ($field_read_only ?? false) read-only @endif checkbox">
                    <input
                        type="radio"
                        id="{{ $field_id }}-{{ $option->value }}"
                        name="{{ $field_name }}"
                        class="@if($field_disabled ?? false) disabled @endif {{ implode(' ', $field_classes ?? []) }}"
                        @foreach ($field_attributes ?? [] as $attribute => $value)
                            {{ $attribute }}="{{ $value }}"
                        @endforeach
                        @if($field_styles ?? [])
                            style="{{ implode(';', $field_styles) }}"
                        @endif
                        value="{{ $option->value }}"
                        @if((string)$field_value === (string)$option->value)
                            selected
                        @endif
                        @if ($field_required ?? false)
                            required
                        @endif
                        @if ($field_read_only ?? false)
                            readonly
                        @endif
                        @if($field_disabled ?? false)
                            disabled
                        @endif
                        @if($field_autofocus ?? false)
                            @if($loop->first) autofocus @endif
                        @endif
                    />
                    <label for="{{ $field_id }}-{{ $option->value }}">{{ $option->label }}</label>
                </div>
            @endforeach
            @break
        @case(FormField::TYPE_SELECT)
            <select
                id="{{ $field_id }}"
                name="{{ $field_name }}"
                class="ui dropdown @if ($field_read_only ?? false) disabled @endif @if($field_disabled ?? false) disabled @endif {{ implode(' ', $field_classes ?? []) }}"
                @foreach ($field_attributes ?? [] as $attribute => $value)
                    {{ $attribute }}="{{ $value }}"
                @endforeach
                @if($field_styles ?? [])
                    style="{{ implode(';', $field_styles) }}"
                @endif
                @if ($field_required ?? false)
                    required
                @endif
                @if ($field_read_only ?? false)
                    readonly
                @endif
                @if($field_disabled ?? false)
                    disabled
                @endif
                @if($field_autofocus ?? false)
                    autofocus
                @endif
            >
                @foreach($field_options ?? [] as $option)
                    @php
                        /** @var \Upmind\ProvisionBase\Laravel\Html\OptionData $option */
                        $previous_group_label = $field_options[$loop->index - 1]->group_label ?? null;
                    @endphp
                    @if($previous_group_label && $previous_group_label != $option->group_label)
                        </optgroup>
                    @endif
                    @if($option->group_label && $option->group_label != $previous_group_label)
                        <optgroup label="{{ $option->group_label }}">
                    @endif
                        <option
                            id="{{ $field_id }}-{{ $option->value }}"
                            value="{{ $option->value }}"
                            @if((string)$field_value === (string)$option->value)
                                selected
                            @endif
                        >{{ $option->label }}</option>
                    @if($option->group_label && $loop->last)
                        </optgroup>
                    @endif
                @endforeach
            </select>
            @break
        @case(FormField::TYPE_INPUT_PASSWORD)
            <div class="ui icon input">
                <input
                    type="password"
                    id="{{ $field_id }}"
                    name="{{ $field_name }}"
                    class="{{ implode(' ', $field_classes ?? []) }}"
                    @foreach ($field_attributes ?? [] as $attribute => $value)
                        {{ $attribute }}="{{ $value }}"
                    @endforeach
                    @if($field_styles ?? [])
                        style="{{ implode(';', $field_styles) }}"
                    @endif
                    value="{{ $field_value }}"
                    @if ($field_required ?? false)
                        required
                    @endif
                    @if ($field_read_only ?? false)
                        readonly
                    @endif
                    @if($field_disabled ?? false)
                        disabled
                    @endif
                    @if($field_autofocus ?? false)
                        autofocus
                    @endif
                />
                <i
                    id="{{ $field_id }}-reveal"
                    class="eye circular link icon"
                    onclick="
                        document.getElementById('{{ $field_id }}').type = 'text';
                        this.style='visibility:hidden';
                        document.getElementById('{{ $field_id }}-hide').style='';
                    "
                ></i>
                <i
                    id="{{ $field_id }}-hide"
                    class="eye slash circular link icon"
                    onclick="
                        document.getElementById('{{ $field_id }}').type = 'password';
                        this.style='visibility:hidden';
                        document.getElementById('{{ $field_id }}-reveal').style='';
                    "
                    style="visibility:hidden"
                ></i>
            </div>
            @break
        @default
            <input
                type="{{ Str::after($field_type, 'input_') }}"
                id="{{ $field_id }}"
                name="{{ $field_name }}"
                class="{{ implode(' ', $field_classes ?? []) }}"
                @foreach ($field_attributes ?? [] as $attribute => $value)
                    {{ $attribute }}="{{ $value }}"
                @endforeach
                @if($field_styles ?? [])
                    style="{{ implode(';', $field_styles) }}"
                @endif
                value="{{ $field_value }}"
                @if ($field_required ?? false)
                    required
                @endif
                @if ($field_read_only ?? false)
                    readonly
                @endif
                @if($field_disabled ?? false)
                    disabled
                @endif
                @if($field_autofocus ?? false)
                    autofocus
                @endif
            />
            @break
    @endswitch
@endcomponent