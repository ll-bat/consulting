<?php

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

Route::get('/', 'HomeController@show');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/blog','BlogController@index')->name('blog');

Route::get('/blog/{blog}','BlogController@show')->name('show');
Route::get('/bestcomment/{comment}', 'BestCommentController@edit')->middleware('auth');
Route::post('/comment/{blog}', 'CommentController@store')->middleware('auth');
Route::delete('/comment/{comment}/delete', 'CommentController@delete')->middleware('auth');

Route::get('/docs', 'UserDocsController@index')->name('docs');
Route::post('/docs/submit', 'UserDocsController@submit')->middleware('auth');


Route::get('/about', function(){return view('about');})->name('about');
Route::get('/services', function(){ return view('services');})->name('services');
Route::get('/contact', function(){return view('contact');})->name('contact');

Route::get('/check', function(){
    if (!Auth::user())
        return view('check');

    return redirect()->to('home');
})->name('check');



Route::group(['prefix' => 'user', 'middleware' => 'auth'], function(){
    Route::get('/home', function (){return view('user.home');})->name('user.home');

    Route::get('/profile','ProfileController@show' )->name('user.profile');
    Route::get('/mydocs', 'MyDocsController@index')->name('user.mydocs');

    Route::get('docs/all-data', 'DocController@getAll');
    Route::get('docs/other-data', 'DocController@otherData');

    Route::get('/questions', 'UserDocsController@show')->name('user.questions');
    Route::post('docs/submit', 'DocController@submit');
    Route::post('docs/save-docs', 'DocController@saveData');
    Route::get('docs/show-data', 'DocController@showData');

    Route::patch('/account','UserController@update');
    Route::patch('/profile','ProfileController@update');
    Route::patch('/profileImage', 'ProfileController@store');

    Route::group(['prefix' => 'doc'], function(){
         Route::get('{export}', 'MyDocsController@show')->name('user.export');
         Route::get('{export}/export', 'MyDocsController@export');
        //  Route::get('{export}/download', 'MyDocsController@download');

    });

    Route::group(["middleware" => 'App\Http\Middleware\AdminMiddleware'], function()
    {
        Route::group(['prefix' => 'blogs'], function(){
             Route::get('', 'BlogController@all')->name('admin.blog');
             Route::get('/create', function (){return view('admin.blog.create'); })->name('blog.create');
             Route::get('/categories', function (){return view('admin.blog.categories'); })->name('blog.categories');
             Route::post('/category/{category}/edit', 'CategoryController@update');
             Route::delete('/category/{category}/delete', 'CategoryController@delete');
             Route::post('/category/create', 'CategoryController@create');
             Route::post('/create', 'BlogController@store');
        });

        Route::group(['prefix' => 'blog'] , function(){
            Route::get('/{blog:id}/edit', 'BlogController@edit')->name('blog.edit');
            Route::get('/{blog:id}/toggle', 'BlogController@toggle');
            Route::patch('/{blog:id}/edit', 'BlogController@update');
            Route::get('/{blog}/delete', 'BlogController@delete');
        });

        Route::group(['prefix' => 'docs'], function(){
            Route::get('', 'DocController@index')->name('admin.docs');
            Route::get('new-danger', 'DangerController@show');
            Route::post('new-danger', 'DangerController@create');
            Route::get('new-control', 'ControlController@newControl');
            Route::post('new-control', 'ControlController@createControl');
            Route::get('all-ploss', 'PlossController@index');
            Route::post('new-ploss', 'PlossController@create');
            Route::post('save-ploss', 'PlossController@save');
            Route::delete('ploss/{ploss}/delete', 'PlossController@delete');
            Route::get('all-udanger', 'UdangerController@index');
            Route::post('new-udanger', 'UdangerController@create');
            Route::post('save-udanger', 'UdangerController@save');
            Route::delete('udanger/{udanger}/delete', 'UdangerController@delete');

            Route::get('danger/{danger}/edit', 'DangerController@edit');
            Route::post('danger/{danger}/update', 'DangerController@update');
            Route::delete('danger/{danger}/delete', 'DangerController@delete');
            Route::get('danger/{danger}/copy', 'DangerController@copy');
            Route::get('danger/{danger}/edit/{control}/detach', 'DangerController@detach');
            Route::get('danger/{danger}/edit/{control}/attach', 'DangerController@attach');

            Route::get('control/{control}/edit', 'ControlController@edit');
            Route::post('control/{control}/update', 'ControlController@update');
            Route::delete('control/{control}/delete', 'ControlController@delete');

            Route::post('add-process', 'ProcessController@addProcess');
            Route::get('process/{process}/edit', 'ProcessController@edit');
            Route::post('process/{process}/update', 'ProcessController@update');
            Route::delete('process/{process}/delete', 'ProcessController@delete');
            Route::get('process/{process}/copy', 'ProcessController@copy');
            Route::get('process/{process}/edit/{danger}/detach', 'ProcessController@detach');
            Route::get('process/{process}/edit/{danger}/attach', 'ProcessController@attach');

            Route::get('check', 'DocController@show')->name('admin.check');



        });

        Route::delete('/doc/{export}/delete', 'MyDocsController@delete');
    });
});

Route::get('test', 'TestsController@index');

// Route::get('test-form', function(){
//     return view('user.docs.form');
// });

// Route::get('test-excel', 'ExportsController@excel');

