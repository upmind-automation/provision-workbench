@php
    use Upmind\ProvisionBase\Registry\Data\CategoryRegister;
    /** @var \Upmind\ProvisionBase\Registry\Registry $registry */

    $wide = true;
    $center = true;
    $hide_breadcrumbs = true;
@endphp

@extends('layouts.main')

@section('title', config('app.name', 'Provision Workbench'))

@section('title-image')
    <img src="{{ url('assets/images/upmind-logo.svg') }}">
@endsection

@section('content')
    <div class="ui basic text segment">
        <p>Browse and experiment with Upmind provision providers</p>
    </div>

    <br>

    <div class="ui clearing divider"></div>

    <div class="ui labeled icon massive menu inline">
        <a class="item width-20" href="{{ route('provision-request-new') }}">
            <i class="blue play circle icon"></i>
            Run Function
        </a>
        <a class="item width-20" href="{{ route('provision-request-index') }}">
            <i class="zoom-in icon"></i>
            View Requests
        </a>
        <a class="item width-20" href="{{ route('category-index') }}">
            <i class="cogs icon"></i>
            Categories
        </a>
        <a class="item width-20" href="{{ route('package-index') }}">
            <i class="box icon"></i>
            Packages
        </a>
        <a class="item width-20" href="https://github.com/upmind-automation/provision-workbench" target="_blank">
            <i class="github icon"></i>
            GitHub
        </a>
    </div>

    <div class="ui divider"></div>
@endsection
