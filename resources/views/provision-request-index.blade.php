@php
    use App\Models\ProvisionRequest;
    /** @var \Upmind\ProvisionBase\Registry\Data\ProviderRegister $provider */

    $wide = true;
@endphp

@extends('layouts.main')

@section('title', 'Provision Requests')

@section('title-message')
    <strong>{{ $provision_requests->total() }} results</strong>
@endsection

@section('icon')
    <i class="zoom-in icon"></i>
@endsection

@section('content')
    <div class="ui basic buttons">
        <a class="ui icon button" href="{{ route('provision-request-new', ['category_code' => Request::get('category_code'), 'provider_code' => Request::get('provider_code'), 'function_name' => Request::get('function_name'), 'configuration_id' => Request::get('configuration_id')]) }}">Run Function <i class="blue play circle icon"></i></a>
    </div>
    <table class="ui striped selectable table">
        <thead>
            @if($filters)
                <tr>
                    <td colspan="8" style="border-bottom: 1px solid rgba(34,36,38,.1);">
                        <strong><large>Filters:</large></strong>
                        @foreach($filters as $key => $filter)
                            <a class="ui label blue" href="{{ Request::fullUrlWithQuery([$key => '']) }}" data-tooltip="Remove filter">
                                {{ $filter_labels[$key] }}: {{ Request::input($key) }}
                                <i class="delete icon"></i>
                            </a>
                        @endforeach
                    </td>
                </tr>
            @endif
            <tr>
                <th>Category</th>
                <th>Provider</th>
                <th>Function</th>
                <th>Configuration</th>
                <th>Status</th>
                <th>Execution Time</th>
                <th>Executed</th>
                <th></th>
            <tr>
        </thead>
        <tbody>
            @if($provision_requests->isEmpty())
                <tr>
                    <td colspan="8" class="center aligned">No requests</td>
                </tr>
            @endif
            @foreach($provision_requests as $provision_request)
                <tr>
                    <td class="collapsing">
                        @component('components.filter', ['filter_param' => 'category_code', 'filter_value' => $provision_request->category_code])
                            <a data-tooltip="View Category" style="color:black;" href="{{ route('category-show', ['category_code' => $provision_request->category_code]) }}">
                                @if ($provision_request->getCategoryIcon()) <i class="{{ $provision_request->getCategoryIcon() }} icon"></i> @endif
                                {{ $provision_request->getCategoryName() }}
                            </a>
                        @endcomponent
                    </td>
                    <td class="collapsing">
                        @component('components.filter', ['filter_param' => 'provider_code', 'filter_value' => $provision_request->provider_code])
                            <a data-tooltip="View Provider" style="color:black;" href="{{ route('provider-show', ['category_code' => $provision_request->category_code, 'provider_code' => $provision_request->provider_code]) }}">
                                @if ($provision_request->getProviderIcon()) <i class="{{ $provision_request->getProviderIcon() }} icon"></i> @endif
                                {{ $provision_request->getProviderName() }}
                            </a>
                        @endcomponent
                    </td>
                    <td class="collapsing">
                        @component('components.filter', ['filter_param' => 'function_name', 'filter_value' => $provision_request->function_name])
                            {{ $provision_request->getFunctionName() }}()
                        @endcomponent
                    </td>
                    <td>
                        @component('components.filter', ['filter_param' => 'configuration_id', 'filter_value' => $provision_request->configuration_id])
                            <a data-tooltip="View Configuration" style="color:black;" href="{{ route('provider-configuration-show', ['configuration' => $provision_request->configuration_id]) }}">
                                {{ $provision_request->getConfigurationName() }}
                            </a>
                        @endcomponent
                    </td>
                    <td class="collapsing center aligned">
                        @component('components.filter', ['filter_param' => 'result_status', 'filter_value' => $provision_request->result_status])
                            <span @if($provision_request->result_message) data-tooltip="{{ $provision_request->result_message }}" data-inverted @endif class="ui small @if($provision_request->isSuccess()) green @elseif($provision_request->isError()) red @endif label" style="min-width:4rem;">
                                {{ ucfirst($provision_request->result_status ?? 'Pending') }}
                            </span>
                        @endcomponent
                    </td>
                    <td class="collapsing">
                        {{ round($provision_request->execution_time, 2) }} secs
                    </td>
                    <td class="collapsing">
                        <span data-tooltip="{{ $provision_request->updated_at }}" data-inverted>{{ $provision_request->updated_at->diffForHumans() }}</span>
                    </td>
                    <td class="collapsing">
                        <div class="ui tiny basic buttons">
                            <a class="ui icon button" href="{{ route('provision-request-show', ['provision_request' => $provision_request]) }}" data-tooltip="View request"><i class="eye icon"></i></a>
                            <a class="ui icon button" href="{{ route('provision-request-new', ['provision_request_id' => $provision_request->id, 'function_name' => $provision_request->function_name, 'use_result_data' => false]) }}" data-tooltip="Duplicate request"><i class="copy icon"></i></a>
                            <a class="ui icon button" id="provision-request-delete-button-{{ $provision_request->id }}" data-tooltip="Delete request"><i class="trash icon"></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th class="center aligned" colspan="8">
                    {{ $provision_requests->links('components.pagination') }}
                </th>
            </tr>
        </tfoot>
    </table>

    @foreach($provision_requests as $provision_request)
        <div class="ui modal" id="provision-request-delete-modal-{{ $provision_request->id }}">
            <i class="close icon"></i>
            <div class="header">Confirm Delete</div>
            <div class="content">Are you sure you wish to delete this provision request?</div>
            <div class="actions">
                <form method="POST" action="{{ route('provision-request-destroy', ['provision_request' => $provision_request, 'r' => Request::fullUrlWithQuery([])]) }}">
                    @method('DELETE')
                    @csrf
                    <div class="ui black deny button">Cancel</div>
                    <button class="ui negative right labeled icon button">Delete<i class="trash icon"></i></button>
                </form>
            </div>
        </div>
    @endforeach

    <script>
        @foreach($provision_requests as $provision_request)
            $('#provision-request-delete-modal-{{ $provision_request->id }}').modal('attach events', '#provision-request-delete-button-{{ $provision_request->id }}', 'show');
        @endforeach
    </script>
@endsection
