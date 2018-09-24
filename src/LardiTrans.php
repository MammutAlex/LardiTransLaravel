<?php

namespace App\Providers;

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
        return $this->lardi->callMethod('auth', $this->config);
    }

    private function addAuth($auth)
    {
        $this->lardi->setUid($auth['uid'])->setSig($auth['sig']);
    }

    private function testAuth()
    {
        try {
            $this->lardi->callMethod('testSig', ['sig' => $this->lardi->getSig()]);
        } catch (ApiErrorException $exception) {
            return false;
        }
        return true;
    }

}