<?php

/**
 * array_walk 对数组的每个值(也可带上键，甚至其他额外参数）调用闭包函数
 * 和 array_map 主要是
 * 1）返回值不一样
 * 2）array_walk 可以接受额外的参数
 */

function func_one($value)
{
    echo __FUNCTION__ . " $value \n";
}

function func_two($value, $key)
{
    echo __FUNCTION__ . " $key $value \n";
}

function func_more($value, $key, $p)
{
    echo __FUNCTION__ . " $key $p $value \n";
}

$a = array("a" => "red", "b" => "green", "c" => "blue");

array_walk($a, "func_one");
echo "\n";

array_walk($a, "func_two");
echo "\n";

array_walk($a, "func_more", "has the value");
echo "\n";
