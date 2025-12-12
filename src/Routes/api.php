<?php

use Illuminate\Support\Facades\Route;
use MichaelOrenda\Logging\Http\Controllers\ErrorLogController;
use MichaelOrenda\Logging\Http\Controllers\ActivityLogController;
use MichaelOrenda\Logging\Http\Controllers\SecurityLogController;

Route::prefix('orenda/logs')->group(function () {

    Route::get('activity', [ActivityLogController::class, 'index']);
    Route::get('security', [SecurityLogController::class, 'index']);
    Route::get('error', [ErrorLogController::class, 'index']);


});
