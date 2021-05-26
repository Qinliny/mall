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
    Route::get('/create', 'AuthController/createRole');
})->middleware(app\admin\middleware\Auth::class);