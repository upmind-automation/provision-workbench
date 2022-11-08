@php
    use Upmind\ProvisionBase\Laravel\Html\Form;
    use Upmind\ProvisionBase\Laravel\Html\FormElement;
    use Upmind\ProvisionBase\Laravel\Html\FormGroup;
    use Upmind\ProvisionBase\Laravel\Html\FormField;
@endphp
<form class="ui form" @if(isset($method)) method="{{ $method }}" @endif @if(isset($action)) action="{{ $action }}" @endif id="{{ $id }}">
    @csrf
    @if(isset($hidden_values))
        @foreach ($hidden_values as $k => $v)
            <input type="hidden" name="{{ $k }}" value="{{ $v }}"/>
        @endforeach
    @endif

    @foreach($form->elements() as $element)
        @if ($element instanceof FormGroup)
            @component('components.form-group', [
                'group' => $element,
                'values' => data_get($values, $element->relativeName()),
                'name_pattern' => $name_pattern ?? '%s',
                'disabled' => $disabled ?? false
            ])
            @endcomponent
        @else
            @component('components.form-field', [
                'field' => $element,
                'value' => data_get($values, $element->relativeName()),
                'name_pattern' => $name_pattern ?? '%s',
                'disabled' => $disabled ?? false
            ])
            @endcomponent
        @endif
    @endforeach
    {{ $slot }}
</form>