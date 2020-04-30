<?php
// +----------------------------------------------------------------------
// | 后台管理模块路由
// +----------------------------------------------------------------------
use think\facade\Route;

// 游客-不需要身份验证
Route::group('admin', function(){
    // 登录 
    Route::post('login', 'admin.Manager/login');
})->allowCrossDomain();

// 管理员-需要身份验证的
Route::group('admin', function(){

    // 删除管理员 
    Route::post('manager/:id/delete', 'admin.Manager/delete');
    
    // 更新管理员
    Route::post('manager/:id', 'admin.Manager/update');
    
    // 创建管理员 该路由规则要写在POST最下方
    Route::post('manager', 'admin.Manager/save');
    
    
    // 管理员列表
    Route::get('manager/:page', 'admin.Manager/index');

});