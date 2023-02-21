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

@section('title', sprintf('View %s() Result', $function->getName()))

@section('title-message')
    <span data-tooltip="{{ $provision_request->updated_at }}" data-inverted>
        <strong>Executed {{ $provision_request->updated_at->diffForHumans() }}</strong>
    </span>
@endsection

@section('content')
    <div class="provision-request-show">
        <div class="ui basic buttons">
            <a class="ui icon button" href="{{ route('provision-request-new', ['provision_request_id' => $provision_request->id, 'function_name' => '', 'use_result_data' => $provision_request->isSuccess()]) }}">Next Request <i class="blue play circle icon"></i></a>
            <a class="ui icon button" href="{{ route('provision-request-new', ['provision_request_id' => $provision_request->id, 'function_name' => $provision_request->function_name, 'use_result_data' => false]) }}">Duplicate <i class="primary copy icon"></i></a>
            <a class="ui icon button" href="{{ route('provision-request-index', ['configuration_id' => $provision_request->configuration_id, 'function_name' => $provision_request->function_name]) }}">Related Requests <i class="zoom-in icon"></i></a>
            <a class="ui icon button" href="{{ route('provision-request-retry', ['provision_request' => $provision_request, '_token' => csrf_token()]) }}">Retry <i class="redo circle icon"></i></a>
            <a class="ui icon button" id="provision-request-delete-button">Delete <i class="red trash icon"></i></a>
        </div>
        @if($provision_request->isSuccess())
            @component('components.message', [
                'message_colour' => 'green',
                'message_icon' => 'check circle outline',
                'message_header' => 'Ok',
                'message_text' => $provision_request->result_message,
                'message_label_icon' => 'clock',
                'message_label' => $provision_request->execution_time . 's',
                'message_cursor' => 'pointer',
                'message_id' => 'provision-result-message',
                'message_tooltip' => 'View details',
            ])
            @endcomponent
        @elseif($provision_request->isError())
            @component('components.message', [
                'message_colour' => 'red',
                'message_icon' => 'times circle outline',
                'message_header' => 'Error',
                'message_text' => $provision_request->result_message,
                'message_label_icon' => 'clock',
                'message_label' => $provision_request->execution_time . 's',
                'message_cursor' => 'pointer',
                'message_id' => 'provision-result-message',
                'message_tooltip' => 'View details',
            ])
            @endcomponent
        @else
            @component('components.message', [
                'message_colour' => 'secondary',
                'message_icon' => 'notched circle loading',
                'message_header' => 'Pending',
            ])
            @endcomponent
        @endif
        @if($provision_request->isSuccess())
            @if(!empty($result_data))
                <table class="ui celled definition table" style="font-size:1rem;">
                    {{-- <thead>
                        <tr class="center aligned">
                            <th class="four wide"></th>
                            <th class="twelve wide">Result Data</th>
                        </tr>
                    </thead> --}}
                    <tbody>
                        @foreach(Arr::dot($result_data) as $prop => $value)
                            <tr>
                                @if(is_array(Arr::get($result_data_rules, $prop)))
                                    <td class="collapsing">
                                        {{ $prop }}
                                        <span class="ui inline icon" data-tooltip="{{ implode(' | ', Arr::get($result_data_rules, $prop)) }}" data-inverted>
                                            <i class="blue info circle icon"></i>
                                        </span>
                                    </td>
                                @else
                                    {{-- Display a warning for unvalidated (unexpected) return values --}}
                                    <td class="collapsing warning" data-tooltip="Unexpected return data property!" data-inverted>
                                        {{ $prop }}
                                        <span class="ui inline icon">
                                            <i class="small icon exclamation triangle"></i>
                                        </span>
                                    </td>
                                @endif
                                <td class="@if((is_string($value) || is_numeric($value)) && !empty($value)) selectable @endif word-break-all">
                                    @if((is_string($value) || is_numeric($value)) && !empty($value))
                                        @component('components.copy-text'){{ $value }}@endcomponent
                                    @else
                                        <em>{{ json_encode($value) }}</em>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- @component('components.form', [
                    'form' => $function->getReturn()->getRules()->toHtmlForm(),
                    'id' => 'result_data',
                    'name_pattern' => 'result_data[%s]',
                    'values' => $result_data,
                    'disabled' => true,
                ])
                @endcomponent --}}
            @endif
        @endif
        <h2 class="ui dividing header">
            Provision Request
        </h2>
        <form class="ui form">
            @component('components.html-field-container', [
                'field_label' => 'Category',
            ])
                <a class="ui icon input" data-tooltip="View category" href="{{ route('category-show', ['category_code' => $provision_request->category_code]) }}">
                    <input type="text" value="{{ $provision_request->getCategoryName() }}" disabled>
                </a>
            @endcomponent
            @component('components.html-field-container', [
                'field_label' => 'Provider',
            ])
                <a class="ui icon input" data-tooltip="View provider" href="{{ route('provider-show', ['category_code' => $provision_request->category_code, 'provider_code' => $provision_request->provider_code]) }}">
                    <input type="text" value="{{ $provision_request->getProviderName() }}" disabled>
                </a>
            @endcomponent
            @component('components.html-field-container', [
                'field_label' => 'Configuration',
            ])
                <a class="ui icon input" data-tooltip="View configuration" href="{{ route('provider-configuration-show', ['configuration' => $configuration ?? $provision_request->configuration_id]) }}">
                    <input type="text" value="{{ $configuration->name ?? null }}" disabled>
                </a>
            @endcomponent
            @component('components.html-field-container', [
                'field_label' => 'Function',
            ])
                <div class="ui icon input">
                    <input type="text" value="{{ $provision_request->getFunctionName() }}()" disabled>
                </div>
            @endcomponent
            {{-- <div class="ui secondary segment grouped fields">
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
                        'field_required' => false,
                        'field_value' => Arr::get($provision_request->flat_parameter_data, $html_field->name()),
                        'field_errors' => $errors->getBag('parameter_data')->get($html_field->name()),
                        'field_disabled' => true,
                    ])
                    @endcomponent
                @endforeach
            </div> --}}
            <div class="ui secondary segment grouped fields">
                <h3 class="ui dividing header">Parameters</h3>
                @component('components.form', [
                    'form' => $function->getParameter()->getRules()->toHtmlForm(),
                    'method' => 'POST',
                    'action' => route('provision-request-store'),
                    'id' => 'parameter_data',
                    'name_pattern' => 'parameter_data[%s]',
                    'values' => $provision_request->parameter_data,
                    'disabled' => true,
                ])
                @endcomponent
            </div>
        </form>
    </div>

    <div class="ui large modal" id="provision-result-modal">
        <i class="close icon"></i>
        <div class="header">Provision Result</div>
        <div class="scrolling content">
            @if($provision_request->isSuccess())
                @component('components.message', [
                    'message_colour' => 'green',
                    'message_icon' => 'check circle outline',
                    'message_header' => 'Ok',
                    'message_text' => $provision_request->result_message,
                    'message_label_icon' => 'clock',
                    'message_label' => $provision_request->execution_time . 's',
                ])
                @endcomponent
            @elseif($provision_request->isError())
                @component('components.message', [
                    'message_colour' => 'red',
                    'message_icon' => 'times circle outline',
                    'message_header' => 'Error',
                    'message_text' => $provision_request->result_message,
                    'message_label_icon' => 'clock',
                    'message_label' => $provision_request->execution_time . 's',
                ])
                @endcomponent
            @else
                @component('components.message', [
                    'message_colour' => 'secondary',
                    'message_icon' => 'notched circle loading',
                    'message_header' => 'Pending',
                ])
                @endcomponent
            @endif
            <div class="ui basic padded segment">
                <div class="ui accordion">
                    <div class="title">
                        <i class="dropdown icon"></i>
                        Params
                    </div>
                    <div class="content">
                        @component('components.json', ['data' => $provision_request->parameter_data])@endcomponent
                    </div>
                    @if($provision_request->hasResult())
                        <div class="title active">
                            <i class="dropdown icon"></i>
                            Result Data
                        </div>
                        <div class="content active">
                            @component('components.json', ['data' => $result_data])@endcomponent
                        </div>
                        <div class="title @if(!$result_debug || (!$result_data && !$logs)) active @endif">
                            <i class="dropdown icon"></i>
                            Result Debug
                        </div>
                        <div class="content @if(!$result_debug || (!$result_data && !$logs)) active @endif">
                            @component('components.json', ['data' => $result_debug])@endcomponent
                        </div>
                        <div class="title active">
                            <i class="dropdown icon"></i>
                            Logs
                        </div>
                        <div class="content active">
                            @component('components.json', ['data' => $logs ?: null])@endcomponent
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="actions">
            <div class="ui black deny button">Close</div>
        </div>
    </div>
    <div class="ui modal" id="provision-request-delete-modal">
        <i class="close icon"></i>
        <div class="header">Confirm Delete</div>
        <div class="content">Are you sure you wish to delete this provision request?</div>
        <div class="actions">
            <form method="POST" action="{{ route('provision-request-destroy', ['provision_request' => $provision_request]) }}">
                @method('DELETE')
                @csrf
                <div class="ui black deny button">Cancel</div>
                <button class="ui negative right labeled icon button">Delete<i class="trash icon"></i></button>
            </form>
        </div>
    </div>
    <script>
        $('.ui.checkbox').checkbox();
        $('.ui.dropdown').dropdown();
        $('.ui.accordion').accordion({
            exclusive: false
        });
        showCopyToolTip($('.copy-text'));
        $('#provision-result-modal').modal('attach events', '#provision-result-message', 'show');
        $('#provision-request-delete-modal').modal('attach events', '#provision-request-delete-button', 'show');
    </script>
@endsection
