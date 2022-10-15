<?php

use App\Models\ProviderConfiguration;
use App\Models\ProvisionRequest;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Upmind\ProvisionBase\Registry\Registry;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail): void {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('package-index', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push('Packages', route('package-index'));
});

Breadcrumbs::for('category-index', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push('Provision Categories', route('category-index'));
});

Breadcrumbs::for('category-show', function (BreadcrumbTrail $trail, $category_code): void {
    $category = Registry::getInstance()->getCategory($category_code);

    $trail->parent('category-index');
    $trail->push($category->getAbout()->name, route('category-show', ['category_code' => $category_code]));
});

Breadcrumbs::for('provider-show', function (BreadcrumbTrail $trail, $category_code, $provider_code): void {
    $provider = Registry::getInstance()->getCategory($category_code)->getProvider($provider_code);

    $trail->parent('category-show', $category_code);
    $trail->push($provider->getAbout()->name, route('provider-show', [
        'category_code' => $category_code,
        'provider_code' => $provider_code
    ]));
});

Breadcrumbs::for('provider-configuration-show', function (BreadcrumbTrail $trail, ProviderConfiguration $configuration): void {
    $trail->parent('provider-show', $configuration->category_code, $configuration->provider_code);
    $trail->push($configuration->name, route('provider-configuration-show', [
        'configuration' => $configuration
    ]));
});

Breadcrumbs::for('provider-configuration-new', function (BreadcrumbTrail $trail, $category_code, $provider_code): void {
    // $provider = Registry::getInstance()->getCategory($category_code)->getProvider($provider_code);

    $trail->parent('provider-show', $category_code, $provider_code);
    $trail->push('New Configuration', route('provider-configuration-new', [
        'category_code' => $category_code,
        'provider_code' => $provider_code
    ]));
});

Breadcrumbs::for('provision-request-index', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');
    $trail->push('Provision Requests', route('provision-request-index'));
});

Breadcrumbs::for('provision-request-show', function (BreadcrumbTrail $trail, ProvisionRequest $provision_request): void {
    $trail->parent('provision-request-index');
    $trail->push(sprintf('View %s() Result', $provision_request->function_name), route('provision-request-show', $provision_request));
});

Breadcrumbs::for('provision-request-new', function (BreadcrumbTrail $trail): void {
    $trail->parent('provision-request-index');
    $trail->push('New Request', route('provision-request-new'));
});
