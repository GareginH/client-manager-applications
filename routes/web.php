<?php

use App\Mail\CreatedAppMail;
use App\Mail\UpdatedAppMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
Auth::routes();
Route::group(
    [
        'middleware' => ['auth'],
    ],
    function () {
        Route::post('/applications/{application}', 'MessageController@store')->name('message.store');
    });
Route::group(
    [
        'middleware' => ['auth', 'isClient'],
    ],
    function () {
        Route::get('/', 'ApplicationController@index');
        Route::get('/applications', 'ApplicationController@index');
        Route::get('/applications/create', 'ApplicationController@create')->name('application.create');
        Route::post('/applications', 'ApplicationController@store')->name('application.store');
        Route::get('/applications/{application}', 'ApplicationController@show')->name('application.show');
        Route::patch('/applications/{application}', 'ApplicationController@update')->name('application.close');

    });
Route::group(
    [
        'prefix' => 'manager',
        'namespace' => 'Manager',
        'middleware' => ['auth', 'isManager'],
    ],
    function () {
        Route::get('applications', 'ManagerApplicationController@index');
        Route::get('applications/{application}', 'ManagerApplicationController@show')->name('application.manager.show');
        Route::patch('applications/{application}', 'ManagerApplicationController@update')->name('application.manager.accept');

    });
Route::get('/home', 'ApplicationController@index')->name('home');
Route::get('/mail', function (){
    //$app = \App\Application::find(1);
    //Mail::to('manager@manager.com')->send(new CreatedAppMail($app));
    //return new UpdatedAppMail($app);
    $user = auth()->user();
    dd($user);
    $application = \App\Application::find(1);
    $messages = $application->messages()->get();
    return view('applications.manager.show', compact('application', 'messages'));
});