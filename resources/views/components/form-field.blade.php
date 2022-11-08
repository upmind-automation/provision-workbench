@php
    use Illuminate\Support\Str;
    use Upmind\ProvisionBase\Laravel\Html\FormElement;
    use Upmind\ProvisionBase\Laravel\Html\FormGroup;
    use Upmind\ProvisionBase\Laravel\Html\FormField;

    $field_id = sprintf($name_pattern, $field->name());
    $field_name = sprintf($name_pattern, $field->name());
    $field_disabled = $disabled ?? false;

    $is_in_required_group = true;
    $parent = $field->group();
    while ($parent instanceof FormGroup) {
        if ($is_in_required_group = $parent->required()) {
            break;
        }

        $parent = $parent->group();
    }

    if ($field->relativeName() === '*' && $is_in_required_group && empty($value)) {
        $value = [null]; // create at least one field
    }
@endphp
@if($field->relativeName() !== '*')
    {{-- Single field --}}
    @component('components.html-field', [
        'field_label' => $field->relativeName(),
        'field_type' => $field->type(),
        'field_id' => $field_id,
        'field_name' => $field_name,
        'field_options' => $field->options(),
        'field_attributes' => $field->attributes(),
        'field_validation_rules' => $field->validationRules(),
        'field_required' => $field->required(),
        'field_value' => $value,
        // 'field_errors' => $errors->getBag('parameter_data')->get($html_field->name()),
        'field_errors' => [],
        // 'field_autofocus' => count($loops) === 1 && ($loops[0]->first ?? false),
        'field_autofocus' => false,
        'field_disabled' => $field_disabled,
    ])
    @endcomponent
@else
    {{-- Array of fields --}}
    @foreach($value as $i => $v)
        @component('components.html-field', [
            'field_label' => $i,
            'field_type' => $field->type(),
            'field_id' => Str::replaceLast('*', $i, $field_id),
            'field_name' => Str::replaceLast('*', $i, $field_name),
            'field_options' => $field->options(),
            'field_attributes' => $field->attributes(),
            'field_validation_rules' => $field->validationRules(),
            'field_required' => $field->required(),
            'field_value' => $v,
            // 'field_errors' => $errors->getBag('parameter_data')->get($html_field->name()),
            'field_errors' => [],
            // 'field_autofocus' => count($loops) === 1 && ($loops[0]->first ?? false),
            'field_autofocus' => false,
            'field_disabled' => $field_disabled,
        ])
        @endcomponent
    @endforeach
    @if (!$field_disabled)
        <template id="template-{{ $field_id }}">
            @component('components.html-field', [
                'field_label' => '**i**',
                'field_type' => $field->type(),
                'field_id' => Str::replaceLast('*', '**i**', $field_id),
                'field_name' => Str::replaceLast('*', '**i**', $field_name),
                'field_options' => $field->options(),
                'field_attributes' => $field->attributes(),
                'field_validation_rules' => $field->validationRules(),
                'field_required' => $field->required(),
                'field_value' => null,
                // 'field_errors' => $errors->getBag('parameter_data')->get($html_field->name()),
                'field_errors' => [],
                // 'field_autofocus' => count($loops) === 1 && ($loops[0]->first ?? false),
                'field_autofocus' => false,
                'field_disabled' => $field_disabled,
                'field_hidden' => true,
            ])
            @endcomponent
        </template>
        <a class="ui icon button" onclick="addFormField('{{ $field_id }}')">
            <i class="icon plus circle"></i>
            {{ Str::singular($field->group()->relativeName()) }}
        </a>
        <script>
            if (typeof window.formFieldIncrements == 'undefined') {
                window.formFieldIncrements = [];
            }
            window.formFieldIncrements['{{ $field_id }}'] = {{ Arr::last(array_keys($value)) + 1 }};
        </script>
    @endif
@endif