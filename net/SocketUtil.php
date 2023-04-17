<?php

/**
 * 检测节点是否可以连通，超时时间3s
 * @param $node ":" 分隔的 host 端口组成的字符串
 * @return bool true 可以连上,false 连不上
 */
function isConnected($node)
{

    list($hostname, $port) = explode(':', $node);
    $timeout = 3;
    /**
     * string $hostname,
     * int $port = -1,
     * int &$error_code = null,
     * string &$error_message = null,
     * float $timeout = null
     */
    $fp = @fsockopen($hostname, $port, $error_code, $error_message, $timeout);
    if (!$fp) {
        // echo "$broker $error_message ($error_code) \n";
        return false;
    } else {
        // 关闭连接
        fclose($fp);
        return true;
    }
}

/**
 * 返回第一个可以连接上的节点
 * @param $brokers  逗号(",")分隔的节点字符串,每个节点格式为 ip:端口,示例
 *
 * @return string 第一个可以连接上的节点,如果没有节点可以连接上，将返回 空字符串''
 *  示例
 *  参数 $nodes = '127.0.0.1:2181'; 返回值 '127.0.0.1:2181'
 *  参数 $nodes = '127.0.0.1:2182,127.0.0.1:2181'; 其中 '127.0.0.1:2182' 服务已经宕机,返回值 '127.0.0.1:2181'
 */
function firstConnected($nodes)
{
    $nodesArr = explode(',', $nodes);
    foreach ($nodesArr as $node) {
        if (isConnected($node)) {
            return $node;
        }
    }

    return '';
}
