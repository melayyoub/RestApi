<?php

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



Route::group(['middleware' => ['web']], function(){
	Route::get('/', function () {
	    return view('welcome');
	});
		

});
Route::group(['middleware' => ['auth']], function(){
	// admins
		Route::resource('/admin/menu', 'MenusCont');
		Route::resource('/admin', 'AdminsCont');
		Route::resource('/admin-shell', 'ShellCont');
		Route::resource('/admin/private/settings', 'SettingsCont');
		Route::resource('/admin/sites', 'SitesCont');
		Route::post('/admin-save/settings', ['as' => 'admin.settings.save', 'uses' => 'AdminsCont@storeSettings']);
			Route::post('/create-settings', ['as' => 'settings.store', 'uses' => 'AdminsCont@createSettings']);
			// saves admins
			Route::post('/admin-users/save', ['as' => 'admin.users.save', 'uses' => 'AdminsCont@adminUsersStore']);
			Route::post('/admin-posts/save', ['as' => 'admin.posts.save', 'uses' => 'AdminsCont@adminPostsStore']);
			Route::post('/admin-proposts/save', ['as' => 'admin.proposts.save', 'uses' => 'AdminsCont@adminProPostsStore']);
			Route::post('/admin-tags/save', ['as' => 'admin.tags.save', 'uses' => 'AdminsCont@adminPostTagsStore']);
			Route::post('/admin-categories/save', ['as' => 'admin.categories.save', 'uses' => 'AdminsCont@adminPostCategoriesStore']);
			Route::post('/admin-path-update', ['as' => 'admin.updatePath', 'uses' => 'AdminsCont@pathUpdate']);
	// Pages
		// Route::resource('/search', 'SearchCont');
	    Route::resource('/media', 'FilesCont');
		Route::resource('/profile', 'ProfilesCont');
		Route::resource('/post', 'PostsCont');
		Route::get('/posts/{path}', ['as' => 'post.show', 'uses' => 'PostsCont@showTitle']);
		Route::resource('/comment', 'CommentsCont');
		// rest controller
		Route::resource('/admin-rest', 'RestCont');
		Route::post('/admin-rest-delete/{tb}', ['as' => 'rest.insert', 'uses' => 'RestCont@delTable']);
		Route::resource('/users', 'UsersByUserCont');
		Route::post('/admin-rest-insert/insert', ['as' => 'rest.insert', 'uses' => 'RestCont@insert']);
		Route::post('/admin-rest-add-fields/add-fields', ['as' => 'rest.addFields', 'uses' => 'RestCont@addFields']);
		Route::post('/admin-rest-remove-fields/del-row', ['as' => 'rest.delRow', 'uses' => 'RestCont@delRow']);
		Route::post('/admin-rest-users-add', ['as' => 'rest.addUser', 'uses' => 'RestCont@addUser']);
		Route::resource('/dashboard', 'Dashboard');
		Route::get('/examples', ['as' => 'admin.examples', 'uses' => 'AdminsCont@examples']);
		// test call 
		Route::get('/api-test', ['as' => 'rest.test', 'uses' => 'RestCont@testCalls']);
});	
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// sitemap links
Route::get('/sitemap', 'SitemapsCont@index');
Route::get('/sitemap/posts', 'SitemapsCont@posts');
Route::get('/sitemap/categories', 'SitemapsCont@categories');
Route::get('/sitemap/podcasts', 'SitemapsCont@podcasts');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
