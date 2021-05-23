<?php
use think\facade\Route;

Route::get("/", "indexController/index")->middleware(app\admin\middleware\Auth::class);

Route::get("/index", "indexController/home");

// 商品管理
Route::get("/goods", "GoodsController/goods");