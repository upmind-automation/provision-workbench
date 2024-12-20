@php
    use Upmind\ProvisionBase\Laravel\Html\FormGroup;

    /** @var string $name_pattern */
    /** @var Upmind\ProvisionBase\Laravel\Html\FormGroup $group */
    /** @var array $values */

    $group_id = sprintf($name_pattern, $group->name());
    $disabled = $disabled ?? false;
    $has_values = is_array($values ?? null) && !empty(array_filter($values));

    $is_in_required_group = true;
    $parent = $group->group();
    while ($parent instanceof FormGroup) {
        if ($is_in_required_group = $parent->required()) {
            break;
        }

        $parent = $parent->group();
    }

    if ($group->relativeName() === '*' && $is_in_required_group && empty($values)) {
        $values = [[]]; // create at least one group
    }
@endphp
<div class="ui secondary segment grouped fields">
    @if($group->required() || $has_values)
        <div class="field @if($group->required()) required @endif">
            <label class="ui dividing header">
                @if($group->validationRules()[$group->name()] ?? [])
                    <span style="font-size:1em; margin-right:0;" class="ui inline icon" data-tooltip="{{ implode(' | ', $group->validationRules()[$group->name()]) }}" data-inverted>
                        {{ $group->relativeName() }}
                        <i style="margin-right:0.25rem;" class="blue info circle icon"></i>
                    </span>
                @else
                    {{ $group->relativeName() }}
                @endif
            </label>
            @foreach($group->elements() as $element)
                @if ($element instanceof FormGroup)
                    @component('components.form-group', [
                        'group' => $element,
                        'values' => data_get($values, $element->relativeName()),
                        'name_pattern' => $name_pattern ?? '%s',
                        'disabled' => $disabled,
                    ])
                    @endcomponent
                @else
                    @component('components.form-field', [
                        'field' => $element,
                        'value' => data_get($values, $element->relativeName()),
                        'name_pattern' => $name_pattern ?? '%s',
                        'disabled' => $disabled,
                    ])
                    @endcomponent
                @endif
            @endforeach
        </div>
    @else
        <template id="template-{{ $group_id }}">
            <div class="field">
                <label class="ui dividing header">
                    @if($group->validationRules()[$group->name()] ?? [])
                        <span style="font-size:1em; margin-right:0;" class="ui inline icon" data-tooltip="{{ implode(' | ', $group->validationRules()[$group->name()]) }}" data-inverted>
                            {{ $group->relativeName() }}
                            <i style="margin-right:0.25rem;" class="blue info circle icon"></i>
                        </span>
                    @else
                        {{ $group->relativeName() }}
                    @endif
                </label>
                @foreach($group->elements() as $element)
                    @if ($element instanceof FormGroup)
                        @component('components.form-group', [
                            'group' => $element,
                            'values' => data_get($values, $element->relativeName()),
                            'name_pattern' => $name_pattern ?? '%s',
                            'disabled' => $disabled,
                        ])
                        @endcomponent
                    @else
                        @component('components.form-field', [
                            'field' => $element,
                            'value' => data_get($values, $element->relativeName()),
                            'name_pattern' => $name_pattern ?? '%s',
                            'disabled' => $disabled,
                        ])
                        @endcomponent
                    @endif
                @endforeach
            </div>
        </template>
        <a class="ui icon button" onclick="revealFormField('template-{{ $group_id }}'); this.remove();">
            <i class="icon plus circle"></i>
            {{ $group->relativeName() }}
        </a>
    @endif
</div>
