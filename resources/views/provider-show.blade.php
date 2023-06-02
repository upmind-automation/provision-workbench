@php
    use App\Models\ProviderConfiguration;
    /** @var \Upmind\ProvisionBase\Registry\Data\ProviderRegister $provider */
@endphp

@extends('layouts.main')

@section('title', $provider->getAbout()->name)
@section('icon')
    @if($provider->getAbout()->icon)<i class="{{ $provider->getAbout()->icon }} icon"></i>@endif
@endsection

@section('content')
    <p>{{ $provider->getAbout()->description }}</p>

    <div class="ui basic buttons">
        <a class="ui icon button" href="{{ route('provision-request-new', ['category_code' => $category->getIdentifier(), 'provider_code' => $provider->getIdentifier()]) }}">Run Function <i class="blue play circle icon"></i></a>
        <a class="ui icon button" href="{{ route('provision-request-index', ['category_code' => $category->getIdentifier(), 'provider_code' => $provider->getIdentifier()]) }}">View Requests <i class="zoom-in icon"></i></a>
        <a class="ui icon button" href="{{ route('provider-configuration-new', ['category_code' => $category->getIdentifier(), 'provider_code' => $provider->getIdentifier()]) }}">New Configuration <i class="green add circle icon"></i></a>
    </div>

    @if($configurations->isNotEmpty())
        <h2 class="ui header dividing">Configurations</h2>
        @component('components.list', [
            'items' => $configurations->map(function (ProviderConfiguration $configuration) {
                return [
                    'url' => route('provider-configuration-show', ['configuration' => $configuration]),
                    'label' => $configuration->name,
                    'description' => 'Updated ' . $configuration->updated_at->diffForHumans(),
                    'icon' => 'cog',
                ];
            })
        ])
        @endcomponent
    @endif
@endsection
