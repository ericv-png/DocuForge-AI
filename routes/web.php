<?php

Route::view('/', 'welcome');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', '2fa', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Data Source
    Route::delete('data-sources/destroy', 'DataSourceController@massDestroy')->name('data-sources.massDestroy');
    Route::post('data-sources/media', 'DataSourceController@storeMedia')->name('data-sources.storeMedia');
    Route::post('data-sources/ckmedia', 'DataSourceController@storeCKEditorImages')->name('data-sources.storeCKEditorImages');
    Route::resource('data-sources', 'DataSourceController');

    // Data Category
    Route::delete('data-categories/destroy', 'DataCategoryController@massDestroy')->name('data-categories.massDestroy');
    Route::resource('data-categories', 'DataCategoryController');

    // Extracted Data
    Route::delete('extracted-datas/destroy', 'ExtractedDataController@massDestroy')->name('extracted-datas.massDestroy');
    Route::resource('extracted-datas', 'ExtractedDataController');

    // Query
    Route::delete('queries/destroy', 'QueryController@massDestroy')->name('queries.massDestroy');
    Route::resource('queries', 'QueryController');

    // Query Message
    Route::delete('query-messages/destroy', 'QueryMessageController@massDestroy')->name('query-messages.massDestroy');
    Route::resource('query-messages', 'QueryMessageController');

    // Settings
    Route::delete('settings/destroy', 'SettingsController@massDestroy')->name('settings.massDestroy');
    Route::post('settings/media', 'SettingsController@storeMedia')->name('settings.storeMedia');
    Route::post('settings/ckmedia', 'SettingsController@storeCKEditorImages')->name('settings.storeCKEditorImages');
    Route::resource('settings', 'SettingsController');

    // Report
    Route::delete('reports/destroy', 'ReportController@massDestroy')->name('reports.massDestroy');
    Route::post('reports/media', 'ReportController@storeMedia')->name('reports.storeMedia');
    Route::post('reports/ckmedia', 'ReportController@storeCKEditorImages')->name('reports.storeCKEditorImages');
    Route::resource('reports', 'ReportController');

    // Errors
    Route::delete('errors/destroy', 'ErrorsController@massDestroy')->name('errors.massDestroy');
    Route::resource('errors', 'ErrorsController');

    // Moderation
    Route::delete('moderations/destroy', 'ModerationController@massDestroy')->name('moderations.massDestroy');
    Route::resource('moderations', 'ModerationController');

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
        Route::post('profile/two-factor', 'ChangePasswordController@toggleTwoFactor')->name('password.toggleTwoFactor');
    }
});
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth', '2fa']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Data Source
    Route::delete('data-sources/destroy', 'DataSourceController@massDestroy')->name('data-sources.massDestroy');
    Route::post('data-sources/media', 'DataSourceController@storeMedia')->name('data-sources.storeMedia');
    Route::post('data-sources/ckmedia', 'DataSourceController@storeCKEditorImages')->name('data-sources.storeCKEditorImages');
    Route::resource('data-sources', 'DataSourceController');

    // Data Category
    Route::delete('data-categories/destroy', 'DataCategoryController@massDestroy')->name('data-categories.massDestroy');
    Route::resource('data-categories', 'DataCategoryController');

    // Extracted Data
    Route::delete('extracted-datas/destroy', 'ExtractedDataController@massDestroy')->name('extracted-datas.massDestroy');
    Route::resource('extracted-datas', 'ExtractedDataController');

    // Query
    Route::delete('queries/destroy', 'QueryController@massDestroy')->name('queries.massDestroy');
    Route::resource('queries', 'QueryController');

    // Query Message
    Route::delete('query-messages/destroy', 'QueryMessageController@massDestroy')->name('query-messages.massDestroy');
    Route::resource('query-messages', 'QueryMessageController');

    // Settings
    Route::delete('settings/destroy', 'SettingsController@massDestroy')->name('settings.massDestroy');
    Route::post('settings/media', 'SettingsController@storeMedia')->name('settings.storeMedia');
    Route::post('settings/ckmedia', 'SettingsController@storeCKEditorImages')->name('settings.storeCKEditorImages');
    Route::resource('settings', 'SettingsController');

    // Report
    Route::delete('reports/destroy', 'ReportController@massDestroy')->name('reports.massDestroy');
    Route::post('reports/media', 'ReportController@storeMedia')->name('reports.storeMedia');
    Route::post('reports/ckmedia', 'ReportController@storeCKEditorImages')->name('reports.storeCKEditorImages');
    Route::resource('reports', 'ReportController');

    // Errors
    Route::delete('errors/destroy', 'ErrorsController@massDestroy')->name('errors.massDestroy');
    Route::resource('errors', 'ErrorsController');

    // Moderation
    Route::delete('moderations/destroy', 'ModerationController@massDestroy')->name('moderations.massDestroy');
    Route::resource('moderations', 'ModerationController');

    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
    Route::post('profile/toggle-two-factor', 'ProfileController@toggleTwoFactor')->name('profile.toggle-two-factor');
});
Route::group(['namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Two Factor Authentication
    if (file_exists(app_path('Http/Controllers/Auth/TwoFactorController.php'))) {
        Route::get('two-factor', 'TwoFactorController@show')->name('twoFactor.show');
        Route::post('two-factor', 'TwoFactorController@check')->name('twoFactor.check');
        Route::get('two-factor/resend', 'TwoFactorController@resend')->name('twoFactor.resend');
    }
});
