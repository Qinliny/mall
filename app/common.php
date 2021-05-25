<?php
/**
 * 失败请求返回的信息
 * @param int $code
 * @param string $messages
 */
function failedAjax(int $code, string $messages) {
    header('Content-Type:application/json');
    $return = [
        'code'    =>  $code,
        'errors'  =>  $messages
    ];
    echo json_encode($return, true);
    die;
}

/**
 * 成功返回的信息
 * @param string $message
 * @param array $data
 */
function successAjax(string $message, $data = []) {
    header('Content-Type:application/json');
    $return = [
        'code'     =>  0,
        'message'  =>  $message,
        'data'     =>  $data
    ];
    echo json_encode($return, true);
    die;
}

/**
 * 前端表格获取数据返回
 * @param int $count
 * @param array $data
 */
function returnTables(int $count, $data = []) {
    header('Content-Type:application/json');
    $return = [
        'code'  =>  0,
        'msg'   =>  "",
        'count' =>  $count > 0 ? $count : 0,
        'data'  =>  $data
    ];
    echo json_encode($return, true);
    die;
}

/**
 * 返回当前时间格式  2021-05-25 01:08:55
 * @return string   当前时间 年月日 时分秒
 */
function thisTime() : string {
    return date('Y-m-d H:i:s', time());
}