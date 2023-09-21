@php
    use Upmind\ProvisionBase\Registry\Data\CategoryRegister;
    /** @var \Upmind\ProvisionBase\Registry\Registry $registry */
    /** @var \Upmind\ProvisionBase\Registry\CategoryRegister[] $categories */
@endphp

@extends('layouts.main')

@section('title', 'Provision Categories')

@section('icon')
    <i class="cogs icon"></i>
@endsection

@section('content')
    <p>This page lists all currently installed provision categories and providers</p>
    {{-- <div class="ui link items">
        @foreach($categories as $category)
            <div class="ui item" href="{{ route('category-show', ['category_code' => $category->getIdentifier()]) }}">
                <div class="center middle aligned image">
                    <a class="image" href="{{ route('category-show', ['category_code' => $category->getIdentifier()]) }}">
                        @if($category->getAbout()->icon)
                            <div><i class="massive black {{ $category->getAbout()->icon }} icon" style="width:100%;"></i></div>
                        @else
                            <img src="{{ $category->getAbout()->logo_url ?? url('assets/images/placeholder.png') }}" alt="{{ $category->getIdentifier() }}">
                        @endif
                    </a>
                </div>
                <div class="content">
                    <a class="header" href="{{ route('category-show', ['category_code' => $category->getIdentifier()]) }}">
                        {{ $category->getAbout()->name }}
                    </a>
                    <span class="description">
                        <p>{{ $category->getAbout()->description }}</p>
                    </span>
                    <span class="extra">
                        @foreach($category->getFunctions() as $function)
                                <span class="ui small compact label">{{ $function->getName() }}()</span>
                        @endforeach
                    </span>
                </div>
            </div>
        @endforeach
    </div> --}}

    <div class="ui link cards">
        @foreach($categories as $category)
            <a class="ui fluid card" style="max-width:320px" href="{{ route('category-show', ['category_code' => $category->getIdentifier()]) }}">
                <div class="image">
                    {{-- <img style="object-fit:cover; max-height:175px" src="{{ $category->getAbout()->logo_url ?? url('assets/images/placeholder.png') }}" alt="{{ $category->getIdentifier() }}"> --}}
                    <div style="padding:1rem;"><i class="massive black {{ $category->getAbout()->icon }} icon" style="width:100%;"></i></div>
                </div>
                <div class="content">
                    <div class="header">
                        {{ $category->getAbout()->name }}
                    </div>
                    <div class="meta">
                        <p>
                            {{ $category->getAbout()->description }}
                        </p>
                    </div>
                    <div class="extra">
                        @foreach($category->getFunctions() as $function)
                                <div class="ui small label">{{ $function->getName() }}()</div>
                        @endforeach
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection
