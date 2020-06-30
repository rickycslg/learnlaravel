<?php

use Illuminate\Http\Request;
use App\Http\Controllers\QuniuServiceController;
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

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

Route::get('/', 'HomeController@index')->name('home');


Route::get('article/{id}', 'ArticleController@show');
Route::post('comment', 'CommentController@store');

//上传图片到七牛
Route::post('uploadqiniu',function(Request $request){
    $qiniu = new QuniuServiceController;
    $payload = $request->all();
    $result = $qiniu->upload($payload['file']);
    return $qiniu->getDomain(). '/'. $result['key'];
});


// 后台
Route::group(['middleware' => 'auth', 'namespace' => 'admin', 'prefix' => 'admin'],function (){
    Route::get('/', 'HomeController@index');
//    Route::get('article', 'ArticleController@index');
    Route::resource('articles', 'ArticleController');
    Route::resource('comments', 'CommentController');
});
