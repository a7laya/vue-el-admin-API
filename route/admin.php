<?php
// +----------------------------------------------------------------------
// | 后台管理模块路由
// +----------------------------------------------------------------------
use think\facade\Route;

// 创建管理员
// Route::post('admin/manager', 'admin.Manager/save');
Route::group('admin', function(){

    // 管理员列表
    Route::get('manager/:page', 'admin.Manager/index');
    
    // 更新管理员
    Route::post('manager/:id', 'admin.Manager/update');
    
    // 创建管理员 该路由规则要写在最下方
    Route::post('manager', 'admin.Manager/save');
});