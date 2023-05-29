<?php

use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

    Route::group(['middleware' => 'auth:api'], function () {
    Route::post('organizations', [OrganizationController::class, 'create']);
    Route::get('organizations', [OrganizationController::class, 'getOrganizations']);
});

Route::post('/organizations', 'OrganizationController@store');
Route::middleware('auth:api')->post('/organisations', 'OrganisationController@create');
