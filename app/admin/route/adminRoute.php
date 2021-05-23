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
})->middleware(app\admin\middleware\Auth::class);
