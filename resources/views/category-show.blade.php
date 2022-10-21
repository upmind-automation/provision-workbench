@php
    use Upmind\ProvisionBase\Registry\Data\ProviderRegister;
    /** @var \Upmind\ProvisionBase\Registry\Data\CategoryRegister $category */
@endphp

@extends('layouts.main')

@section('title', $category->getAbout()->name)
@section('icon')
    @if($category->getAbout()->icon)<i class="{{ $category->getAbout()->icon }} icon"></i>@endif
@endsection

@section('content')
    <p>{{ $category->getAbout()->description }}</p>

    <div class="ui basic buttons">
        <a class="ui icon button" href="{{ route('provision-request-new', ['category_code' => $category->getIdentifier()]) }}">Run Function <i class="blue play circle icon"></i></a>
        <a class="ui icon button" href="{{ route('provision-request-index', ['category_code' => $category->getIdentifier()]) }}">Related Requests <i class="zoom-in icon"></i></a>
    </div>

    <h2 class="ui header dividing">Providers</h2>
    <div class="ui link cards">
        @foreach($category->getProviders() as $provider)
            <a class="ui fluid card" style="max-width:220px" href="{{ route('provider-show', ['category_code' => $category->getIdentifier(), 'provider_code' => $provider->getIdentifier()]) }}">
                <div class="image" style="height:110px; display:flex; justify-content: center; align-items: center;">
                    <img style="width:auto; height:auto; object-fit:@if($provider->getAbout()->logo_url) contain @else cover @endif; max-height:110px; max-width:100%;" src="{{ $provider->getAbout()->logo_url ?? url('assets/images/placeholder.png') }}" alt="{{ $provider->getIdentifier() }}">
                </div>
                <div class="content">
                    <div class="header">
                        {{ $provider->getAbout()->name }}
                    </div>
                    <div class="meta">
                        <p>
                            {{ $provider->getAbout()->description }}
                        </p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection
