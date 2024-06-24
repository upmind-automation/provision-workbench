<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class)->name('home');
Route::get('/packages', PackageIndexController::class)->name('package-index');
Route::get('/categories', CategoryIndexController::class)->name('category-index');
Route::get('/categories/{category_code}', CategoryShowController::class)->name('category-show');
Route::get('/categories/{category_code}/providers/{provider_code}', ProviderShowController::class)->name('provider-show');
Route::get('/categories/{category_code}/providers/{provider_code}/new-configuration', ProviderConfigurationNewController::class)->name('provider-configuration-new');
Route::post('/categories/{category_code}/providers/{provider_code}/configurations', ProviderConfigurationStoreController::class)->name('provider-configuration-store');
Route::get('/configurations/{configuration}', ProviderConfigurationShowController::class)->name('provider-configuration-show');
Route::put('/configurations/{configuration}', ProviderConfigurationUpdateController::class)->name('provider-configuration-update');
Route::delete('/configurations/{configuration}', ProviderConfigurationDestroyController::class)->name('provider-configuration-destroy');
Route::get('/provision_requests', ProvisionRequestIndexController::class)->name('provision-request-index');
Route::post('/provision_requests/new', ProvisionRequestNewController::class)->name('provision-request-new-post');
Route::get('/provision_requests/new', ProvisionRequestNewController::class)->name('provision-request-new');
Route::post('/provision_requests', ProvisionRequestStoreController::class)->name('provision-request-store');
Route::get('/provision_requests/{provision_request}/retry/{_token}', ProvisionRequestRetryController::class)->name('provision-request-retry');
Route::get('/provision_requests/{provision_request}', ProvisionRequestShowController::class)->name('provision-request-show');
Route::delete('/provision_requests/{provision_request}', ProvisionRequestDestroyController::class)->name('provision-request-destroy');
