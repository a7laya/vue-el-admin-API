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
    
    // 创建管理员
    Route::post('manager', 'admin.Manager/save');
});