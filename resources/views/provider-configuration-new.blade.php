@php
    use Upmind\ProvisionBase\Laravel\Html\FormField;
    use Upmind\ProvisionBase\Laravel\Html\FormGroup;
    /** @var \Upmind\ProvisionBase\Registry\Data\CategoryRegister $category */
    /** @var \Upmind\ProvisionBase\Registry\Data\ProviderRegister $provider */
    /** @var \Illuminate\Support\ViewErrorBag $errors */
@endphp

@extends('layouts.main')

@section('title', 'New ' . $provider->getAbout()->name . ' Configuration')
@section('icon')
    <i class="cog icon"></i>
@endsection

@section('content')
    <form
        class="ui form"
        method="POST"
        action="{{ route('provider-configuration-store', [
            'category_code' => $provider->getCategory()->getIdentifier(),
            'provider_code' => $provider->getIdentifier()
        ]) }}"
    >
        @csrf
        @component('components.html-field', [
            'field_label' => 'Name',
            'field_type' => FormField::TYPE_INPUT_TEXT,
            'field_id' => 'configuration_name',
            'field_name' => 'name',
            'field_required' => true,
            'field_value' => Request::input('name') ?? $name,
            'field_errors' => $errors->get('name'),
        ])
        @endcomponent
        <div class="ui secondary segment grouped fields">
            <h3 class="ui header">Configuration Data</h3>
            @foreach($provider->getConstructor()->getParameter()->getRules()->toHtmlForm()->elements() as $element)
                @if ($element instanceof FormGroup)
                    @component('components.form-group', [
                        'group' => $element,
                        'values' => Request::input('field_values.' . $element->name()) ?? Arr::get($field_values, $element->name()),
                        'name_pattern' => 'field_values[%s]',
                    ])
                    @endcomponent
                    @error($element->name())
                        <div class="ui red pointing label">
                            {{ $message }}
                            <i class="close icon" onclick="this.parentElement.classList.add('hidden')"></i>
                        </div>
                    @enderror
                @else
                    @component('components.form-field', [
                        'field' => $element,
                        'value' => Request::input('field_values.' . $element->name()) ?? Arr::get($field_values, $element->name()),
                        'name_pattern' => 'field_values[%s]',
                    ])
                    @endcomponent
                @endif
            @endforeach
        </div>
        <div class="ui field">
            <button class="ui positive button right labeled icon" type="submit">Create<i class="save icon"></i></button>
        </div>
    </form>
@endsection
