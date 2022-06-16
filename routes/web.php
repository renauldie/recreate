<?php

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/employee/{id}', 'HomeController@show')->name('employee');

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth', 'admin'])
    ->group(function() {
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::resource('/period', 'PeriodController');

        Route::get('/job-type/edit/{id}', 'JobTypeController@edit');

        Route::resource('/job-type', 'JobTypeController');

        Route::resource('/employee', 'EmployeeController');

        Route::resource('/criteria', 'CriteriaController');

        Route::resource('/criteria-comparison', 'ComparisonCriteraController');

        Route::resource('/data-process', 'EmployeeProcessDataController');

        Route::resource('/ranking', 'RankResultController');

        Route::resource('/contract-option', 'ContractOptionController');

        Route::prefix('data-process')->group(function() {
            Route::post('/', 'EmployeeProcessDataController@throwAlternative')->name('throw-alternative');
        });

        Route::prefix('export-excel')->group(function() {
            Route::post('/spk-export', 'ExportController@spk')->name('export-spk-res');
        });

        Route::prefix('import-excel')->group(function() {
            Route::post('/import-emp', 'EmployeeController@import')->name('import-employee');
        });
    });
