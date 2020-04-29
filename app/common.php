<?php
// 应用公共文件
// 抛出异常
function ApiException($msg = '请求错误',$errorCode = 20000,$statusCode = 404)
{
    abort($errorCode, $msg,[
        'statusCode' => $statusCode
    ]);
}

// 成功返回
function showSuccess($data = '',$msg = 'ok',$code = 200){
    return json([ 'msg' => $msg, 'data' => $data ],$code);
}

// 失败返回
function showError($msg = 'error',$code = 400){
    return json([ 'msg' => $msg ],$code);
}

// 获取数组指定key的value
function getValByKey($key, $arr, $default = false){
    return array_key_exists($key, $arr) ? $arr[$key] : $default;
}
