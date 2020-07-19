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

//Route::middleware('auth:api')->get('/user', function (Request $request) {return $request->user();});

// Route Back-End
Route::group(['prefix' => 'v1', 'namespace' => 'Api' ], function($route) {

    // Route Is Public , User Can Accsess Those Without any Restriction
    Route::group(['prefix' => 'user'], function() {

        // Login User
        Route::post('/login', 'Auth\UserApiController@login');

        // Register User
        Route::post('/register', 'Auth\UserApiController@register');

        // Forget Pasword
        Route::post('/forgot-password', 'Auth\ForgotPasswordController@sendResetLinkEmail');

        // Rest Password
        Route::post('/reset-password', 'Auth\ResetPasswordController@reset');

        // Email Verification
        Route::get('/email-verification', 'Auth\VerifyEmailController@verify')->name('verification.verify');

        // Resend Email Verification
        Route::post('/resend-email-verify', 'Auth\VerifyEmailController@resendVerifyEmail');

        // Social Login Redirect Provider
        Route::get('/authorize/{provider}/redirect', 'Auth\SocialiteLoginController@redirectToProvider')->name('social.redirect');

        // Social Login Provider Callback
        Route::get('/authorize/{provider}/callback', 'Auth\SocialiteLoginController@handleProviderCallback');


    }); // End Route User Group

    //================== User Comments & Countact us Page  ==================//

    Route::post('/comment', 'CommentController@store')->name('comment.add');
    Route::post('/reply', 'CommentController@replyStore')->name('reply.add');
    Route::get('/post/comment/{commentable_id}', 'CommentController@show')->name('comment.post');
    Route::get('/post/reply/{commentable_id}', 'CommentController@showReply')->name('comment.reply');

    Route::post('/contact-us/sendmsg', 'ContactUSController@sendMessage')->name('contact.send');

    /***
        ### Admin Routes To Access Dashboard
        ### This Route Is Available For Only User Authentication
        ### Uset JWT Authentication For Save Connections Between Users & Databases
    ***/

    Route::group(['middleware' => 'jwt.auth','prefix' => 'admin'], function() {

        // Dashboar Info
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

        // Logout User From Application
        Route::post('/logout', 'Auth\UserApiController@logout');

        // Refresh JWT Token
        Route::post('/refresh', 'Auth\UserApiController@refresh');

        // Setting
        Route::apiResource('/setting', 'SettingController');

        //User Info
        Route::apiResource('/user', 'UserController');

        // Get Role
        Route::get('/roles', 'RoleController@index');

        // Admin Profile
        Route::apiResource('/profile', 'ProfileController');

        // Tags
        Route::apiResource('/tag', 'TagController');

        // Categories
        Route::apiResource('/category', 'CategoryController');

        // Actors
        Route::apiResource('/actor', 'ActorController');

        // Post
        // Route::apiResource('/post', 'PostController');
        Route::get('/posts', 'PostController@index')->name('post.index');
        Route::post('/post', 'PostController@store')->name('post.store');
        Route::get('/post/trash', 'PostController@postTrash')->name('post.trash');
        Route::get('/post/{post}', 'PostController@show')->name('post.show');
        Route::patch('/post/{post}', 'PostController@update')->name('post.update');
        Route::delete('/post/{post}', 'PostController@destroy')->name('post.destroy');
        Route::get('/post/restore/{post}', 'PostController@restore')->name('post.restore');
        Route::delete('/post/delete/{post}', 'PostController@harddelete')->name('post.delete');

        Route::get('/contact-us', 'ContactUSController@index')->name('contact.page');
        Route::get('/contact-us/{contact}', 'ContactUSController@show')->name('contact.show');
        Route::delete('/contact-us/delete/{contact}', 'ContactUSController@destroy')->name('contact.delete');

    }); // End Route Admin Group

});// End Route Back-End Group V1

//======== This Route Is Public , User Can Accsess Those Without any thing ========//

// Route Front-End
Route::group(['prefix' => 'v1', 'namespace' => 'FrontEnd' ], function($route) {

     // Get Papular & Last Post
    Route::get('/home', 'FrontEndController@index')->name('home.index');

    // Get Popular Post
    Route::get('/popularpost', 'FrontEndController@popularPost')->name('post.popular');

    // Get New Post Add
    Route::get('/lastpost', 'FrontEndController@lastPost')->name('post.last');

    // Get All Actors
    Route::get('/actors', 'FrontEndController@actors')->name('actors');

    // Get Actor Info Page & Show All Post Partake This Actor
    Route::get('/actor/{id}', 'FrontEndController@actorPage')->name('actor.info');

    // Get All Category
    Route::get('/categories', 'FrontEndController@categories')->name('categories');

    // Get Category Info Page With All Post Use This Category
    Route::get('/category/{id}', 'FrontEndController@categoryPage')->name('category.page');

    // Get Tag With All Post Use This Tag
    Route::get('/tag/{id}', 'FrontEndController@tagPage')->name('tag.page');

    // Get Search Post Results
    Route::get('/search', 'FrontEndController@search')->name('search');

    // Get Post Content In Single Page
    Route::get('/post/{id}', 'FrontEndController@singlePage')->name('single.page');

    // Get Post Like Count
    Route::post('/like/{id}', 'FrontEndController@postlike')->name('post.like');


});// End Route Front-End Group V1
