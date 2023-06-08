<?php

use Illuminate\Support\Facades\Route;
use App\Http\Modules\Public\Controllers\TopicsController;

$modules = ["account" => "Account"];

/**
 * Topics
 **/
Route::prefix('topics')->controller(TopicsController::class)->group(function() {
    Route::get('{id}', 'get');
    Route::post('search', 'search');
    Route::post('search-one', 'searchOne');
    Route::post('', 'create');
    Route::patch('{id}', 'update');
    Route::delete('{id}', 'delete');
});

foreach ($modules as $prefix => $module) {
    Route::prefix($prefix)->group(__DIR__ . "/Modules/{$module}/routes.php");
}
