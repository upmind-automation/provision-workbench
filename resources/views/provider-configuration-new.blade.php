@php
    use Upmind\ProvisionBase\Laravel\Html\HtmlField;
    use Upmind\ProvisionBase\Registry\Data\ProviderRegister;
    /** @var \Upmind\ProvisionBase\Registry\Data\CategoryRegister $category */
    /** @var \Upmind\ProvisionBase\Registry\Data\ProviderRegister $provider */
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
            'field_type' => HtmlField::TYPE_INPUT_TEXT,
            'field_id' => 'configuration_name',
            'field_name' => 'name',
            'field_required' => true,
            'field_value' => Request::input('name'),
            'field_errors' => $errors->getBag('default')->get('name'),
        ])
        @endcomponent
        <div class="ui secondary segment grouped fields">
            <h3 class="ui header">Configuration Data</h3>
            @foreach($provider->getConstructor()->getParameter()->getRules()->toHtmlFields() as $html_field)
                @component('components.html-field', [
                    'field_label' => $html_field->name(),
                    'field_type' => $html_field->type(),
                    'field_id' => 'field_values_' . $html_field->name(),
                    'field_name' => 'field_values[' . $html_field->name() . ']',
                    'field_options' => $html_field->options(),
                    'field_attributes' => $html_field->attributes(),
                    'field_validation_rules' => $html_field->validationRules(),
                    'field_required' => $html_field->required(),
                    'field_value' => Request::input('field_values.' . $html_field->name()),
                    'field_errors' => $errors->getBag('field_values')->get($html_field->name()),
                ])
                @endcomponent
            @endforeach
        </div>
        <div class="ui field">
            <button class="ui positive button right labeled icon" type="submit">Create<i class="save icon"></i></button>
        </div>
    </form>
@endsection
