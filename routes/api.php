<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
    // test/*
    Route::get('/test', function (Request $request) {
        return $request->access;
    });

    // auth/*
    Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
        Route::post('login', 'LoginController@attempt');
    });

    Route::group(['namespace' => 'User'], function () {
        // users/*
        Route::resource('users', 'UserController');

        // badges/*
        Route::resource('badges', 'BadgeController');

        // organization_contacts/*
        Route::resource('org_contacts', 'OrganizationContactController');

        // blood_blood_contacts/*
        Route::resource('blood_bank_contacts', 'BloodBankContactController');
    });

    Route::group(['namespace' => 'Donation'], function () {
        // donors/*
        Route::resource('donors', 'DonorController');

        // donations/*
        Route::resource('donations', 'DonationController');
    });

    Route::group(['namespace' => 'Blood'], function () {
        // blood_banks/*
        Route::resource('blood_banks', 'BloodBankController');

        // blood_drive/*
        Route::resource('blood_drives', 'BloodDriveController');

        // blood_drive/*
        Route::resource('blood_types', 'BloodTypeController');

        // blood_requests/*
        Route::resource('blood_requests', 'BloodRequestController');
    });

    Route::group(['namespace' => 'Location'], function () {
        // communities/*
        Route::resource('communities', 'CommunityController');
    });

    Route::group(['namespace' => 'Organization'], function () {
        // organizations/*
        Route::resource('organizations', 'OrganizationController');
    });
});
