@php
    use App\Composer\Data\VersionData;
    /** @var \App\Composer\Data\PackageVersions $packages */
@endphp

@extends('layouts.main')

@section('title', 'Installed Packages')
@section('icon')
    <i class="box icon"></i>
@endsection

@section('content')
    <p>This page lists all currently installed provision packages</p>
    @component('components.list', [
        'items' => collect($packages->packages)->map(function (VersionData $version_data) {
            if (Str::startsWith($version_data->source->url, 'https://github.com')) {
                $icon = 'github';
                $url = $version_data->source->url;
            } elseif (filter_var($version_data->source->url, FILTER_VALIDATE_URL)) {
                $icon = 'world';
                $url = $version_data->source->url;
            } elseif ($version_data->source->type === 'path') {
                $icon = 'folder open';
            }

            return [
                'url' => $url ?? null,
                'label' => $version_data->name,
                'description' => $version_data->version,
                'icon' => $icon ?? 'question circle',
            ];
        }),
    ])
    @endcomponent
@endsection
