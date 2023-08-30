<?php

class AESCrypt
{
    // 加解密函数示例
    // 更复杂的算法'AES-256-CBC';
    const CIPHER_ALGO = 'AES-128-CBC';

    public static function encrypt($data, $key)
    {
        $iv_length = openssl_cipher_iv_length(self::CIPHER_ALGO);
        $iv = openssl_random_pseudo_bytes($iv_length);
        $encrypted_data = openssl_encrypt($data, self::CIPHER_ALGO, $key, OPENSSL_RAW_DATA, $iv);

        return $encrypted_data . $iv;
    }

    public static function decrypt($encData, $key)
    {
        $iv_length = openssl_cipher_iv_length(self::CIPHER_ALGO);
        $dateLen = strlen($encData) - $iv_length;

        $data = substr($encData, 0, $dateLen);
        $iv = substr($encData, $dateLen);
        return openssl_decrypt($data, self::CIPHER_ALGO, $key, OPENSSL_RAW_DATA, $iv);
    }
}

function test($data, $key, $jsonDecode = false)
{
    echo "origin_data:#{$data}#\n";
    $ret = AESCrypt::encrypt($data, $key);
    $raw = AESCrypt::decrypt($ret, $key);
    if ($jsonDecode) {
        print_r(json_decode($raw, true));
    }
}

// 测试
$data = 'hello world';
$key = 'my_secret_key';
test($data, $key);

// 包含特殊字符
$data = json_encode(["name" => '张三', "age" => 1888, 'salary' => 17777.12]);
$key = md5('my_pass_wd$@!@$%^&');
test($data, $key, true);
