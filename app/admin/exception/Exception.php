<?php


namespace app\admin\exception;


use think\exception\Handle;
use think\facade\Log;
use think\Response;
use think\exception\ValidateException;
use think\Exception as SystemException;
use Throwable;

class Exception extends Handle
{
    public function render($request, Throwable $e): Response
    {
        // 参数验证错误
        if ($e instanceof ValidateException) {
            failedAjax(__LINE__, $e->getError());
        }

        if ($e instanceof SystemException) {
            Log::channel('error')->error("Messages: ". $e->getMessage() . " Code：" . $e->getCode());
            if ($request->isGet()) {
                abort(500, $e->getMessage());
            }

            if ($request->isAjax() || $request->isPost()) {
                failedAjax($e->getCode(), $e->getMessage());
            }
        }

        // 请求异常
        if ($e instanceof HttpException && $request->isAjax()) {
            return response($e->getMessage(), $e->getStatusCode());
        }

        return parent::render($request, $e);
    }
}