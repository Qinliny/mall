<?php
// 应用公共文件

/**
 * 失败请求返回的信息
 * @param int $code
 * @param string $messages
 */
function failedAjax(int $code, string $messages) {
    header('Content-Type:application/json');
    $return = [
        'code'      =>  $code,
        'messages'  =>  $messages
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
        'code'      =>  0,
        'messages'  =>  $message,
        'data'      =>  $data
    ];
    echo json_encode($return, true);
    die;
}