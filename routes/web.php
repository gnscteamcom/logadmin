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


Route::get('/', ['as' => 'guide', 'uses' => 'Controller@guide']);//系统引导页
Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@index']);//登录首页


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', ['as' => 'auth_login', 'uses' => 'Auth\AuthController@login']);
    Route::get('logout', 'Auth\AuthController@logout');
    Route::get('captcha', ['as' => 'captcha', 'uses' => 'Captcha\Gregwar@generate']);// 验证码
	Route::get('user/authority', ['as' => 'user_authority', 'uses' => 'Auth\AuthController@getUserAuthority']);//获取当前登录用户的菜单
});



Route::group(['middleware' => ['auth.custom', 'lang']], function () {
	Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'Controller@dashboard']);// dashboard
});



Route::group(['middleware' => ['auth.custom','permission', 'lang']], function () {
	#系统设置
    Route::group(['prefix' => 'admin'], function () {
        #管理员相关
        Route::get('user/index', ['as' => 'admin_user', 'uses' => 'Admin\UserController@index']);        // 管理员列表
		Route::get('user/create_info', ['as' => 'create_info', 'uses' => 'Admin\UserController@createUserInfo']);// 添加管理员页面
		Route::post('user/create', ['as' => 'create', 'uses' => 'Admin\UserController@createUser']);     // 添加管理员
		Route::get('user/update_info', ['as' => 'update_info', 'uses' => 'Admin\UserController@updateUserInfo']); // 修改管理员页面
		Route::post('user/update', ['as' => 'update', 'uses' => 'Admin\UserController@updateUser']); // 修改管理员页面	
        Route::get('user/info', ['as' => 'admin_info', 'uses' => 'Admin\UserController@UserInfo']);        // 管理员明细     
        Route::delete('user/delete', ['as' => 'admin_delete', 'uses' => 'Admin\UserController@deleteUserData']);  // 删除管理员

		
		#角色相关
        Route::get('role/index', ['as' => 'admin_role', 'uses' => 'Admin\RoleController@index']); // 角色列表
		Route::get('role/create_info', ['as' => 'create_info', 'uses' => 'Admin\RoleController@createRoleInfo']);// 添加角色页面
		Route::post('role/create', ['as' => 'create', 'uses' => 'Admin\RoleController@createRole']);// 添加角色
		Route::delete('role/delete', ['as' => 'delete', 'uses' => 'Admin\RoleController@deleteRoleData']);//删除角色
		
				
        #菜单相关
        Route::get('menu/index', ['as' => 'admin_menu', 'uses' => 'Admin\MenuController@index']);        // 菜单列表
		Route::get('menu/create_info', ['as' => 'create_info', 'uses' => 'Admin\MenuController@createMenuInfo']);// 添加菜单页面
		Route::post('menu/create', ['as' => 'create_info', 'uses' => 'Admin\MenuController@createMenu']);// 添加菜单
		Route::get('menu/create_sub_info', ['as' => 'create_info', 'uses' => 'Admin\MenuController@createSubmenuInfo']);// 添加子菜单页面
		Route::post('menu/create_sub', ['as' => 'create_info', 'uses' => 'Admin\MenuController@createSubmenu']);// 添加子菜单
		Route::get('menu/update_info', ['as' => 'update_info', 'uses' => 'Admin\MenuController@updateMenuInfo']);// 更改菜单页面
		Route::post('menu/update', ['as' => 'update_info', 'uses' => 'Admin\MenuController@updateMenu']);// 更改菜单页面

		
        #权限相关
        Route::get('/role_menu/update_info', ['as' => 'usermenu_list', 'uses' => 'Admin\RoleMenuController@menuTreeList']);  // 角色授权页面
		Route::post('/role_menu/update', ['as' => 'usermenu_list', 'uses' => 'Admin\RoleMenuController@updateRoleMenu']);  // 角色授权页面
    });

	
	
	#日志内容
	Route::group(['prefix' => 'log_detail'], function () {
        Route::get('/list', ['as' => 'operation_list', 'uses' => 'LogDetailReport\OperationController@dataList']);//日志报表
    });	
});