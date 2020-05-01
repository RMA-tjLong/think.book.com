<?php

namespace app\common;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use think\Env;

class JWTToken
{
    private static $_instance;
    private $_token;
    private $_iss;
    private $_aud;
    private $_uid;
    private $_decode_token;
    private $_secret;
    private $_expired;

    private function __construct()
    {
        $this->_iss     = Env::get('app.en_name');
        $this->_aud     = Env::get('app.en_name');
        $this->_secret  = Env::get('app.salt');
        $this->_expired = 60 * 60 * 8;
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __clone()
    {
    }

    public function encode()
    {
        $time = time();
        $this->_token = (new builder())->setHeader('alg', 'HS256')
            ->setIssuer($this->_iss)
            ->setAudience($this->_aud)
            ->setIssuedAt($time)
            ->setExpiration($time + $this->_expired)
            ->set('uid', $this->_uid)
            ->sign(new Sha256(), $this->_secret)
            ->getToken();

        return $this;
    }

    public function getToken()
    {
        return (string) $this->_token;
    }

    public function setToken($token)
    {
        $this->_token = $token;
        return $this;
    }

    public function setUid($uid)
    {
        $this->_uid = $uid;
        return $this;
    }

    public function jsonDecode()
    {
        $token = $this->_token;
        $this->_decode_token = (new Parser())->parse((string) $token);
        return $this->_decode_token;
    }

    public function validate()
    {
        $data = new ValidationData();
        $data->setIssuer($this->_iss);
        $data->setAudience($this->_aud);
        return $this->jsonDecode()->validate($data);
    }

    public function verify()
    {
        $result = $this->jsonDecode()->verify(new Sha256(), $this->_secret);
        return $result;
    }
}
