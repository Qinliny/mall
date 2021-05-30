<?php
use think\facade\Route;

Route::get("/", "indexController/index")->middleware(app\admin\middleware\Auth::class);

Route::get("/index", "indexController/home");

// 商品管理
Route::get("/goods", "GoodsController/goods");

// 商品分类
Route::group('/category', function(){
    Route::get("/", "GoodsCategoryController/category");
    Route::get("/create", "GoodsCategoryController/createCategory");
    Route::post("/saveCreateData", "GoodsCategoryController/saveCreateData");
    Route::get('/getList', "GoodsCategoryController/getGoodsCategoryList");
    Route::post('/updateStatus', 'GoodsCategoryController/updateGoodsCategoryStatus');
    Route::post('/delete', 'GoodsCategoryController/deleteGoodsCategory');
})->middleware(app\admin\middleware\Auth::class);

// 管理员列表
Route::group('/admins', function(){
    Route::get('/', 'AdminController/admins');
    Route::get('/create', 'AdminController/createAdmins');
})->middleware(app\admin\middleware\Auth::class);

// 角色管理
Route::group('/role', function(){
    Route::get('/', 'AuthController/role');
    Route::get('/list', 'AuthController/getRoleList');
    Route::post('/create', 'AuthController/createRole');
    Route::post('/update', 'AuthController/updateRole');
    Route::post('/delete', 'AuthController/deleteRole');
    Route::get('/setRule', 'AuthController/setRule');
})->middleware(app\admin\middleware\Auth::class);

// 菜单管理
Route::group('/rule', function(){
    Route::get('/', 'AuthController/rule');
    Route::post('/create', 'AuthController/createRule');
    Route::get('/list', 'AuthController/getRuleList');
    Route::post('/update', 'AuthController/updateRule');
    Route::post('/updateStatus', 'AuthController/updateRuleStatus');
    Route::post('/delete', 'AuthController/deleteRule');
})->middleware(app\admin\middleware\Auth::class);

