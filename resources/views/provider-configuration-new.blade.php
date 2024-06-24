@php
    use Upmind\ProvisionBase\Laravel\Html\FormField;
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
            'field_type' => FormField::TYPE_INPUT_TEXT,
            'field_id' => 'configuration_name',
            'field_name' => 'name',
            'field_required' => true,
            'field_value' => Request::input('name') ?? $name,
            'field_errors' => $errors->getBag('default')->get('name'),
        ])
        @endcomponent
        <div class="ui secondary segment grouped fields">
            <h3 class="ui header">Configuration Data</h3>
            @foreach($provider->getConstructor()->getParameter()->getRules()->toHtmlForm()->elements() as $form_field)
                @component('components.html-field', [
                    'field_label' => $form_field->name(),
                    'field_type' => $form_field->type(),
                    'field_id' => 'field_values_' . $form_field->name(),
                    'field_name' => 'field_values[' . $form_field->name() . ']',
                    'field_options' => $form_field->options(),
                    'field_attributes' => $form_field->attributes(),
                    'field_validation_rules' => $form_field->validationRules(),
                    'field_required' => $form_field->required(),
                    'field_value' => Request::input('field_values.' . $form_field->name()) ?? Arr::get($field_values, $form_field->name()),
                    'field_errors' => $errors->getBag('field_values')->get($form_field->name()),
                ])
                @endcomponent
            @endforeach
        </div>
        <div class="ui field">
            <button class="ui positive button right labeled icon" type="submit">Create<i class="save icon"></i></button>
        </div>
    </form>
@endsection
