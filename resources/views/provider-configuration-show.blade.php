@php
    use Upmind\ProvisionBase\Laravel\Html\HtmlField;
    use Upmind\ProvisionBase\Registry\Data\ProviderRegister;
    /** @var \Upmind\ProvisionBase\Registry\Data\CategoryRegister $category */
    /** @var \Upmind\ProvisionBase\Registry\Data\ProviderRegister $provider */
    /** @var \App\Models\ProviderConfiguration $configuration */
@endphp

@extends('layouts.main')

@section('title', 'Manage ' . $provider->getAbout()->name . ' Configuration')

@section('icon')
    <i class="cog icon"></i>
@endsection

@section('title-message')
    <span data-tooltip="{{ $configuration->updated_at }}">
        <strong>Updated {{ $configuration->updated_at->diffForHumans() }}</strong>
    </span>
@endsection

@section('content')
    <div class="ui basic buttons">
        <a class="ui icon button" href="{{ route('provision-request-new', ['configuration_id' => $configuration->id]) }}">Run Function <i class="blue play circle icon"></i></a>
        <a class="ui icon button" href="{{ route('provision-request-index', ['configuration_id' => $configuration->id]) }}">Related Requests <i class="zoom-in icon"></i></a>
        <a class="ui icon button" onclick="$('#configuration_delete_modal').modal('show');">Delete <i class="red trash icon"></i></a>
    </div>
    <h2>Update Configuration</h2>
    <form class="ui form @if(Request::get('created') || Request::get('updated'))success @endif" method="POST" action="{{ route('provider-configuration-update', ['configuration' => $configuration]) }}">
        <div class="ui success message">
            <i class="close icon" onclick="this.parentElement.classList.add('hidden')"></i>
            <div class="header">
                @if(Request::get('created'))
                    Configuration Created
                @else
                    Configuration Updated
                @endif
            </div>
        </div>
        @method('PUT')
        @csrf
        @component('components.html-field', [
            'field_label' => 'Name',
            'field_type' => HtmlField::TYPE_INPUT_TEXT,
            'field_id' => 'configuration_name',
            'field_name' => 'name',
            'field_required' => true,
            'field_value' => Request::input('name') ?? $configuration->name,
            'field_errors' => $errors->getBag('default')->get('name'),
        ])
        @endcomponent
        <div class="ui secondary segment grouped fields">
            <h3 class="ui header dividing">Data</h3>
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
                    'field_value' => Request::input('field_values.' . $html_field->name()) ?? $configuration->data[$html_field->name()] ?? null,
                    'field_errors' => $errors->getBag('field_values')->get($html_field->name()),
                ])
                @endcomponent
            @endforeach
        </div>
        <div class="ui field">
            <button class="ui primary button right labeled icon button" type="submit">Update<i class="save icon"></i></button>
        </div>
    </form>

    <div class="ui modal" id="configuration_delete_modal">
        <i class="close icon"></i>
        <div class="header">Confirm Delete</div>
        <div class="content">Are you sure you wish to delete {{ $provider->getAbout()->name }} configuration <strong>{{ $configuration->name }}</strong>?</div>
        <div class="actions">
            <form method="POST" action="{{ route('provider-configuration-destroy', ['configuration' => $configuration]) }}">
                @method('DELETE')
                @csrf
                <div class="ui black deny button">Cancel</div>
                <button class="ui negative right labeled icon button">Delete<i class="trash icon"></i></button>
            </form>
        </div>
    </div>
@endsection