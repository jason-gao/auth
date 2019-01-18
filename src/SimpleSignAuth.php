<?php

namespace Auth;

class SimpleSignAuth
{
    private $signKey;
    private $expired      = 60;
    private $expiredCheck = true;
    private $error;


    public function __construct($params)
    {
        if (isset($params['signKey']) && $params['signKey']) {
            $this->signKey = $params['signKey'];
        }
        if (isset($params['expired']) && $params['expired']) {
            $this->expired = $params['expired'];
        }
        if (isset($params['expiredCheck'])) {
            $this->expiredCheck = $params['expiredCheck'];
        }
    }


    public function makeSign($time, $params = [])
    {
        $params = json_encode($params, 1);
        $sign   = md5(md5($time . $params . $this->signKey));

        return $sign;
    }

    public function verifySign($time, $sign, $params = [])
    {
        $sign2 = $this->makeSign($time, $params);
        $now   = time();
        $diff  = $now - $time;
        if ($this->expiredCheck && ($diff >= $this->expired)) {
            $this->error = 'sign expired';
            return false;
        }
        if ($sign2 == $sign) {
            return true;
        }

        $this->error = 'sign invalid';
        return false;
    }

    public function getError()
    {
        return $this->error;
    }

}