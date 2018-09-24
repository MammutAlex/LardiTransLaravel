<?php

namespace MammutAlex\LardiTransLaravel;

use MammutAlex\LardiTrans\Exception\ApiErrorException;
use \MammutAlex\LardiTrans\LardiTrans as BaseLardi;
use Illuminate\Support\Facades\Cache;

class LardiTrans
{
    private $config;
    private $lardi;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->lardi = new BaseLardi();
        $this->setAuth();
    }

    private function setAuth()
    {
        $auth = Cache::rememberForever('larditrans.auth', function () {
            return $this->getAuth();
        });
        $this->addAuth($auth);
        if (!$this->testAuth()) {
            Cache::forever('larditrans.auth', $this->getAuth());
        }
    }

    private function getAuth()
    {
        $data = [
          'login'=>$this->config['login'],
          'password'=>$this->config['password'],
        ];
        if(!$this->config['is_password_hash']){
            $data['password'] = md5($data['password']);
        }
        return $this->lardi->callMethod('auth', $data);
    }

    private function addAuth($auth)
    {
        $this->lardi->setUid($auth['uid'])->setSig($auth['sig']);
    }

    private function testAuth()
    {
        try {
            $this->lardi->callMethod('testSig');
        } catch (ApiErrorException $exception) {
            return false;
        }
        return true;
    }

}