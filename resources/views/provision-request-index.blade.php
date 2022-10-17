@php
    use App\Models\ProvisionRequest;
    /** @var \Upmind\ProvisionBase\Registry\Data\ProviderRegister $provider */

    $wide = true;
@endphp

@extends('layouts.main')

@section('title', 'Provision Requests')

@section('title-message', sprintf('%s results', $provision_requests->total()))

@section('icon')
    <i class="zoom-in icon"></i>
@endsection

@section('content')
    <div class="ui basic buttons">
        <a class="ui icon button" href="{{ route('provision-request-new', ['category_code' => Request::get('category_code'), 'provider_code' => Request::get('provider_code'), 'function_name' => Request::get('function_name'), 'configuration_id' => Request::get('configuration_id')]) }}">Run Function <i class="blue play circle icon"></i></a>
    </div>
    <table class="ui striped selectable table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Provider</th>
                <th>Configuration</th>
                <th>Function</th>
                <th>Status</th>
                <th>Execution Time</th>
                <th>Updated</th>
                <th></th>
            <tr>
            {{-- @if($filters)
                <tr>
                    <th colspan="7">@json($filters)</th>
                </tr>
            @endif --}}
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
                            <a href="{{ route('category-show', ['category_code' => $provision_request->category_code]) }}">
                                @if ($provision_request->getCategoryIcon()) <i class="{{ $provision_request->getCategoryIcon() }} icon"></i> @endif
                                {{ $provision_request->getCategoryName() }}
                            </a>
                        @endcomponent
                    </td>
                    <td class="collapsing">
                        @component('components.filter', ['filter_param' => 'provider_code', 'filter_value' => $provision_request->provider_code])
                            <a href="{{ route('provider-show', ['category_code' => $provision_request->category_code, 'provider_code' => $provision_request->provider_code]) }}">
                                @if ($provision_request->getProviderIcon()) <i class="{{ $provision_request->getProviderIcon() }} icon"></i> @endif
                                {{ $provision_request->getProviderName() }}
                            </a>
                        @endcomponent
                    </td>
                    <td>
                        @component('components.filter', ['filter_param' => 'configuration_id', 'filter_value' => $provision_request->configuration_id])
                            <a href="{{ route('provider-configuration-show', ['configuration' => $provision_request->configuration_id]) }}">
                                {{ $provision_request->getConfigurationName() }}
                            </a>
                        @endcomponent
                    </td>
                    <td class="collapsing">
                        @component('components.filter', ['filter_param' => 'function_name', 'filter_value' => $provision_request->function_name])
                            {{ $provision_request->getFunctionName() }}()
                        @endcomponent
                    </td>
                    <td class="collapsing center aligned">
                        @component('components.filter', ['filter_param' => 'result_status', 'filter_value' => $provision_request->result_status])
                            <span @if($provision_request->result_message) data-tooltip="{{ $provision_request->result_message }}" @endif class="ui small @if($provision_request->isSuccess()) green @elseif($provision_request->isError()) red @endif label" style="min-width:4rem;">
                                {{ ucfirst($provision_request->result_status ?? 'Pending') }}
                            </span>
                        @endcomponent
                    </td>
                    <td class="collapsing">
                        {{ round($provision_request->execution_time, 2) }} secs
                    </td>
                    <td class="collapsing">
                        <span data-tooltip="{{ $provision_request->updated_at }}">{{ $provision_request->updated_at->diffForHumans() }}</span>
                    </td>
                    <td class="collapsing">
                        <div class="ui tiny basic buttons">
                            <a class="ui icon button" href="{{ route('provision-request-show', ['provision_request' => $provision_request]) }}" data-tooltip="View request"><i class="eye icon"></i></a>
                            <a class="ui icon button" href="{{ route('provision-request-new', ['provision_request_id' => $provision_request->id]) }}" data-tooltip="Duplicate request"><i class="copy icon"></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th class="center aligned" colspan="8">
                    @if($provision_requests->hasMorePages() || $provision_requests->currentPage() > 1)
                        <div class="ui pagination menu">
                            @foreach(range(1, $provision_requests->lastPage()) as $i)
                                <a @if($i == $provision_requests->currentPage()) class="item active" @else class="item" href="{{ Request::fullUrlWithQuery(['page' => $i]) }}" @endif>
                                    {{ $i }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </th>
            </tr>
        </tfoot>
    </table>
@endsection
