<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Users
    Route::apiResource('users', 'UsersApiController');

    // Data Source
    Route::post('data-sources/media', 'DataSourceApiController@storeMedia')->name('data-sources.storeMedia');
    Route::apiResource('data-sources', 'DataSourceApiController');

    // Data Category
    Route::apiResource('data-categories', 'DataCategoryApiController');

    // Extracted Data
    Route::apiResource('extracted-datas', 'ExtractedDataApiController');

    // Query
    Route::apiResource('queries', 'QueryApiController');

    // Query Message
    Route::apiResource('query-messages', 'QueryMessageApiController');

    // Report
    Route::post('reports/media', 'ReportApiController@storeMedia')->name('reports.storeMedia');
    Route::apiResource('reports', 'ReportApiController');

    // Moderation
    Route::apiResource('moderations', 'ModerationApiController');
});
