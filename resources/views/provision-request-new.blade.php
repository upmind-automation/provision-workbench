@php
    use App\Models\ProviderConfiguration;
    use Upmind\ProvisionBase\Laravel\Html\HtmlField;
    use Upmind\ProvisionBase\Laravel\Html\OptionData;
    use Upmind\ProvisionBase\Registry\Data\CategoryRegister;
    use Upmind\ProvisionBase\Registry\Data\FunctionRegister;
    use Upmind\ProvisionBase\Registry\Data\ProviderRegister;
    /** @var \Upmind\ProvisionBase\Registry\Registry $registry */
@endphp

@extends('layouts.main')

@section('title', 'New Request')
@section('icon')
    <i class="blue play circle icon"></i>
@endsection

@section('content')
    <p>Each execution of a provision function is represented as a provision request. Select the category, provider, configuration and function below, then fill out the function parameters and execute.</p>
    <div class="provision-request-create">
        {{-- CATEGORY --}}
        <form class="ui form" method="GET" action="{{ route('provision-request-new') }}">
            @component('components.html-field', [
                'field_label' => 'Category',
                'field_type' => HtmlField::TYPE_SELECT,
                'field_id' => 'category_code',
                'field_name' => 'category_code',
                'field_classes' => isset($category) ? ['disabled field'] : [],
                'field_options' => $registry->getCategories()
                    ->map(function (CategoryRegister $category) {
                        return new OptionData([
                            'label' => $category->getAbout()->name,
                            'value' => $category->getIdentifier(),
                        ]);
                    })
                    ->sortBy('label')
                    ->prepend(new OptionData([
                        'label' => '---',
                        'value' => null
                    ])),
                'field_required' => true,
                'field_value' => isset($category) ? $category->getIdentifier() : null,
                'field_errors' => $errors->getBag('default')->get('category_code'),
            ])
            @endcomponent
            @if(!isset($category))
                <div class="ui field">
                    <button class="ui primary button right labeled icon button" type="submit">Select Provider <i class="arrow down icon"></i></button>
                </div>
            @endif
        </form>
        {{-- PROVIDER --}}
        @if(isset($category))
            <form class="ui form" method="GET" action="{{ route('provision-request-new') }}">
                <input type="hidden" name="category_code" value="{{ $category->getIdentifier() }}"/>
                @component('components.html-field', [
                    'field_label' => 'Provider',
                    'field_type' => HtmlField::TYPE_SELECT,
                    'field_id' => 'provider_code',
                    'field_name' => 'provider_code',
                    'field_classes' => isset($provider) ? ['disabled field'] : [],
                    'field_options' => $category->getProviders()
                        ->map(function (ProviderRegister $provider) {
                            return new OptionData([
                                'label' => $provider->getAbout()->name,
                                'value' => $provider->getIdentifier(),
                            ]);
                        })
                        ->sortBy('label')
                        ->prepend(new OptionData([
                            'label' => '---',
                            'value' => null
                        ])),
                    'field_required' => true,
                    'field_value' => isset($provider) ? $provider->getIdentifier() : null,
                    'field_errors' => $errors->getBag('default')->get('provider_code'),
                ])
                @endcomponent
                @if(!isset($provider))
                    <div class="ui field">
                        <button class="ui primary button right labeled icon button" type="submit">Select Configuration <i class="arrow down icon"></i></button>
                    </div>
                @endif
            </form>
            {{-- PROVIDER CONFIGURATION --}}
            @if(isset($provider))
                <form
                    class="ui form"
                    method="GET"
                    @if($configurations->isEmpty())
                        action="{{ route('provider-configuration-new', ['category_code' => $category->getIdentifier(), 'provider_code' => $provider->getIdentifier()]) }}"
                    @else
                        action="{{ route('provision-request-new') }}"
                    @endif
                >
                    @if($configurations->isEmpty())
                        @component('components.html-field-container', [
                            'field_label' => 'Configuration',
                        ])
                            <button class="ui primary button right labeled icon button" type="submit">Create New <i class="plus circle icon"></i></button>
                        @endcomponent
                    @else
                        @component('components.html-field', [
                            'field_label' => 'Configuration',
                            'field_type' => HtmlField::TYPE_SELECT,
                            'field_id' => 'configuration_id',
                            'field_name' => 'configuration_id',
                            'field_classes' => isset($configuration) ? ['disabled field'] : [],
                            'field_options' => $configurations
                                ->map(function (ProviderConfiguration $configuration) {
                                    return new OptionData([
                                        'group_label' => sprintf(
                                            '%s / %s',
                                            $configuration->getCategory()->getAbout()->name,
                                            $configuration->getProvider()->getAbout()->name,
                                        ),
                                        'label' => $configuration->name,
                                        'value' => $configuration->id,
                                    ]);
                                })
                                ->sortBy('label')
                                ->prepend(new OptionData([
                                    'label' => '---',
                                    'value' => null
                                ])),
                            'field_required' => true,
                            'field_value' => $configuration->id ?? null,
                            'field_errors' => $errors->getBag('default')->get('configuration_id'),
                        ])
                        @endcomponent
                    @endif
                    @if(!isset($configuration) && $configurations->isNotEmpty())
                        <div class="ui field">
                            <button class="ui primary button right labeled icon button" type="submit">Select Function <i class="arrow down icon"></i></button>
                        </div>
                    @endif
                </form>
                {{-- FUNCTION --}}
                @if(isset($configuration))
                    <form class="ui form" method="GET" action="{{ route('provision-request-new') }}">
                        <input type="hidden" name="configuration_id" value="{{ $configuration->id }}"/>
                        @if($request->has('provision_request_id'))
                            <input type="hidden" name="provision_request_id" value="{{ $request->get('provision_request_id') }}"/>
                        @endif
                        @if($request->has('use_result_data'))
                            <input type="hidden" name="use_result_data" value="{{ $request->get('use_result_data') }}"/>
                        @endif
                        @component('components.html-field', [
                            'field_label' => 'Function',
                            'field_type' => HtmlField::TYPE_SELECT,
                            'field_id' => 'function_name',
                            'field_name' => 'function_name',
                            'field_classes' => isset($function) ? ['disabled field'] : [],
                            'field_options' => $configuration->getCategory()
                                ->getFunctions()
                                ->map(function (FunctionRegister $function) {
                                    return new OptionData([
                                        'label' => sprintf('%s()', $function->getName()),
                                        'value' => $function->getName(),
                                    ]);
                                })
                                ->prepend(new OptionData([
                                    'label' => '---',
                                    'value' => null
                                ])),
                            'field_required' => true,
                            'field_value' => isset($function) ? $function->getName() : null,
                            'field_errors' => $errors->getBag('default')->get('function_name'),
                        ])
                        @endcomponent
                        @if(!isset($function))
                            <div class="ui field">
                                <button class="ui primary button right labeled icon button" type="submit">Enter Parameters <i class="arrow down icon"></i></button>
                            </div>
                        @endif
                    </form>
                    {{-- PARAMETERS --}}
                    @if(isset($function))
                        <form class="ui form" method="POST" action="{{ route('provision-request-store') }}">
                            @csrf
                            <input type="hidden" name="configuration_id" value="{{ $configuration->id }}"/>
                            <input type="hidden" name="function_name" value="{{ $function->getName() }}"/>
                            <div class="ui secondary segment grouped fields">
                                <h3 class="ui dividing header">Parameters</h3>
                                @foreach($function->getParameter()->getRules()->toHtmlFields() as $html_field)
                                    @component('components.html-field', [
                                        'field_label' => $html_field->name(),
                                        'field_type' => $html_field->type(),
                                        'field_id' => 'parameter_data_' . $html_field->name(),
                                        'field_name' => 'parameter_data[' . $html_field->name() . ']',
                                        'field_options' => $html_field->options(),
                                        'field_attributes' => $html_field->attributes(),
                                        'field_validation_rules' => $html_field->validationRules(),
                                        'field_required' => $html_field->required(),
                                        'field_value' => Arr::get($parameter_data, $html_field->name()),
                                        'field_errors' => $errors->getBag('parameter_data')->get($html_field->name()),
                                        'field_autofocus' => $loop->first,
                                    ])
                                    @endcomponent
                                @endforeach
                            </div>
                            <div class="ui field">
                                <button class="ui primary button right labeled icon button" type="submit">Execute <i class="play circle icon"></i></button>
                            </div>
                        </form>
                    @endif
                @endif
            @endif
        @endif
    </div>
    <script>
        // $('#configuration_id')
        //     .dropdown({
        //         fullTextSearch: true,
        //         onChange: function (value, text, $choice) {
        //             console.log(value, text, $choice);
        //         },
        //     });
    </script>
@endsection
