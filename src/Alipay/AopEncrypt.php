<?php

namespace Mayijuntuan\Alipay;


class AopEncrypt
{

    public static function encrypt($str, $screct_key)
    {
        //AES, 128 模式加密数据 CBC
        $screct_key = base64_decode($screct_key);
        $str = trim($str);
        $str = self::addPKCS7Padding($str);

        //设置全0的IV
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = str_repeat("\0", $iv_size);

        $encrypt_str = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $screct_key, $str, MCRYPT_MODE_CBC, $iv);
        return base64_encode($encrypt_str);
    }

    public static function decrypt($str, $screct_key)
    {
        //AES, 128 模式加密数据 CBC
        $str = base64_decode($str);
        $screct_key = base64_decode($screct_key);

        //设置全0的IV
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = str_repeat("\0", $iv_size);

        $decrypt_str = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $screct_key, $str, MCRYPT_MODE_CBC, $iv);
        $decrypt_str = self::stripPKSC7Padding($decrypt_str);
        return $decrypt_str;
    }

    /**
     * 填充算法
     * @param string $source
     * @return string
     */
    private static function addPKCS7Padding($source)
    {
        $source = trim($source);
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);

        $pad = $block - (strlen($source) % $block);
        if ($pad <= $block) {
            $char = chr($pad);
            $source .= str_repeat($char, $pad);
        }
        return $source;
    }

    /**
     * 移去填充算法
     * @param string $source
     * @return string
     */
    private static function stripPKSC7Padding($source)
    {
        $char = substr($source, -1);
        $num = ord($char);
        if ($num == 62) return $source;
        $source = substr($source, 0, -$num);
        return $source;
    }

}
