<?php

namespace MammutAlex\LardiTransLaravel;

use MammutAlex\LardiTrans\Exception\ApiAuthException;
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

    public function __call(string $name, array $arguments): array
    {
        try {
            return $this->lardi->$name(...$arguments);
        } catch (ApiAuthException $authException) {
            $this->freshAuth();
            return $this->lardi->$name(...$arguments);
        }
    }

    private function setAuth()
    {
        $auth = Cache::rememberForever('larditrans.auth', function () {
            return $this->getAuth();
        });
        $this->addAuth($auth);
    }

    private function freshAuth()
    {
        $auth = $this->getAuth();
        Cache::forever('larditrans.auth', $auth);
        $this->addAuth($auth);
    }

    private function getAuth()
    {
        return $this->lardi->sendAuth($this->config['login'], $this->config['password'], $this->config['is_password_hash']);
    }

    private function addAuth($auth)
    {
        $this->lardi->setUid($auth['uid'])->setSig($auth['sig']);
    }

}