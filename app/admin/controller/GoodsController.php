<?php
namespace app\admin\controller;

class GoodsController extends BaseController
{
    public function goods() {
        return view('goods/goods');
    }
}