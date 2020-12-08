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

// Auth Controller
Route::group([], function() {
	Route::get('login', 'AuthController@login')->name('login');
	Route::post('login', 'AuthController@loginProcess')->name('loginProcess');

	Route::get('register', 'AuthController@register')->name('register');
	Route::post('register', 'AuthController@registerProcess')->name('register');

	Route::get('reset-password', 'AuthController@lupaPassword')->name('reset.password');
	Route::post('reset-password', 'AuthController@lupaPasswordProcess')->name('reset.password');
	Route::get('reset-password/{token}', 'AuthController@lupaPasswordToken')->name('reset.password.token');
	Route::put('reset-password/{token}', 'AuthController@lupaPasswordTokenVerifyProcess')->name('reset.password.token');

	Route::get('logout', 'AuthController@Logout')->name('logout');
});

// Users Controller
Route::group(['middleware' => ['auth:user', 'session.auth'], 'prefix' => 'users', 'namespace' => 'Users'], function () {
	Route::get('/', 'UsersController@index');

	// Profile Controller
	Route::get('/profile', 'UsersController@profileView')->name('profile');
	Route::put('/profile', 'UsersController@updateProfile')->name('profile.update');
	Route::put('/profile/password', 'UsersController@updateProfilePassword')->name('profile.password');

	Route::resources([
		'voting' => 'VotingController',
		'voting-multi' => 'VotingMultiController'
	]);

	// Vote 
	Route::get('/vote/{id_voting}', 'VotingController@votingGetSearch');
	Route::post('/vote/process/{id_voting}', 'VotingController@votingProcess')->name('process.vote');
	Route::post('/vote/search', 'VotingController@searchIDVote')->name('vote.search');
	// Multi Vote
	Route::get('/vote/multi/{id_multi}', 'VotingController@MultiVote')->name('vote.multi');
	Route::post('/vote/multi', 'VotingController@MultiVoteProcess')->name('vote.multi.process');
	Route::delete('/vote/multi/delete/{id_multi}', 'VotingController@MultiVoteDelete')->name('vote.multi.delete');

	// Image Voting
	Route::get('/storange/image/{file}', 'VotingController@fileMateri');

	// Static Data Personal Vote
	Route::get('/static/{id_voting}', 'VotingController@StaticVoting');
});

// Route::get('/file/multi/{file}', 'Users/VotingMultiController@fileMulti');

// Admin Controller
Route::group(['middleware' => ['auth:user', 'session.auth'], 'prefix' => 'admin', 'namespace' => 'Admin'], function() {

	Route::get('/', 'AdminController@home')->name('admin');
	
	// Resources Management Jawaban Vote Dan Management Users
	Route::resources([
		'management-jawaban' => 'ManagementJawabanController',
		'management-users' => 'ManagementUsersController'
	]);

	// Category Master Data
	Route::get('/master-category', 'AdminController@Category')->name('master-category');
	Route::post('/master-category/', 'AdminController@CategoryProcess')->name('master-category');
	Route::put('/master-category/edit/{id_category}', 'AdminController@CategoryEdit')->name('category.edit');
	Route::delete('/master-category/delete/{id_category}', 'AdminController@CategoryDelete')->name('category.delete');

	// Management Created Vote
	Route::get('/crated-vote', 'AdminController@CraetedVote')->name('created-vote');
	Route::post('/crated-vote', 'AdminController@CraetedVoteProcess')->name('created-vote');
	Route::get('/crated-vote/edit/{id_voting}', 'AdminController@CraetedVoteEdit');
	Route::put('/crated-vote/edit/{id_voting}', 'AdminController@CraetedVoteEditProcess')->name('created.vote.edit');

	// Static Data Monitoring Keselurahan
	Route::get('/monitoring', 'AdminController@monitoringKeseluruhan')->name('monitoring.data');
	Route::get('/static/users/{tanggal}', 'MonitoringData@staticUsers');
});