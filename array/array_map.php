<?php

$a1 = [2, 4, 10];
$a2 = [3, 5, 6];
// 每次回调时，取每个数组相同位置的元素作为参数
$res = array_map(function ($v, $w) {
    return $v * $w;
}, $a1, $a2);
var_dump($res);

$a1 = [2, 4, 10];
$a2 = [3, 5, 6];
// 如果 回调函数只需要一个参数，那么只会从第二个数组中去，剩余数组不会取
$res = array_map(function ($v) {
    return $v * $v;
}, $a1, $a2);
var_dump($res);


$a1 = ['f' => 2, 'g' => 4, 100 => 10];
// array_map 返回的结果数组下标全部为数字，从0开始
// 也就是原来的键丢失了
$res = array_map(function ($v, $w) {
    return $v * $w;
}, $a1, $a2);
var_dump($res);

$a1 = [2, 4, 10];
$a2 = [3, 5];
// 如果闭包参数大于1，
// 但是作为参数的那些数组长度不同，
// 返回结果为参数中长度最大的数组，
// 长度不足的数组，传给回调的元素值为 null
$res = array_map(function ($v, $w) {
    var_dump($v,$w);
    return $v * $w;
}, $a1, $a2);
var_dump($res);
