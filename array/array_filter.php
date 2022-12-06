<?php

// array_filter 用于过滤数组，回调函数返回true的元素及其键会保留，其他的会被过滤掉

// ARRAY_FILTER_USE_BOTH 模式下，回调参数可以有一个或者两个参数
// 第一个参数固定为 要过滤数组的值，第二个参数固定为相应的键

$arr = [
    'name'=>'john',
    'age'=>100,
    'from'=>'chin',
];

echo "array_filter with ARRAY_FILTER_USE_BOTH \n";
$fiRes = array_filter(
    $arr,
    function ($v,$k){
        echo "v=$v,k=$k\n";

        return is_string($v);
    },
    ARRAY_FILTER_USE_BOTH

);

var_dump($fiRes);


echo "array_filter with default mode \n";


$fiRes = array_filter(
    $arr,
    function ($v){
        echo "v=$v\n";

        return is_string($v);
    },
    ARRAY_FILTER_USE_BOTH

);

var_dump($fiRes);

// 普通模式下 回调函数只能接受 1个参数，>= 2个参数会报错
// Fatal error: Uncaught ArgumentCountError: Too few arguments to function {closure}(), 1 passed and exactly 2 expected
// 如果 array_filter
echo "array_filter with default \n";
$fiRes = array_filter(
    $arr,
    function ($v,$k){
        echo "v=$v,k=$k\n";

        return is_string($v);
    }
);

var_dump($fiRes);
