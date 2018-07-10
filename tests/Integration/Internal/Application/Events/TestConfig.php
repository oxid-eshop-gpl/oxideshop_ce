<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 10.07.18
 * Time: 11:58
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Application\Events;


class TestConfig
{
    public function getConfigParam($key)
    {
        if ($key == 'sShopDir') {
            return __DIR__;
        }

        if ($key == 'sCompileDir') {
            return __DIR__;
        }

        throw new \Exception('Unknown key ' . $key);
    }

}