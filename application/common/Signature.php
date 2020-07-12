<?php

namespace app\common;

use think\Env;

class Signature
{
    public static function encryptSignature($uid = "", $time = "")
    {
        return md5(md5($uid . Env::get('app.salt')) . $time);
    }

    public static function checkSignature($uid, $signature, $signature_time)
    {
        if (time() - $signature_time > Env::get('weixin.expire_time') * 60 * 60 * 24) {
            return false;
        }

        if ($signature != self::encryptSignature($uid, $signature_time)) {
            return false;
        }

        return true;
    }
}