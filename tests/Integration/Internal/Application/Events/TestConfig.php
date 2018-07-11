<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 10.07.18
 * Time: 11:58
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Application\Events;


use OxidEsales\Eshop\Core\Config;

class TestConfig
{
    private $originalConfig;

    public function __construct(Config $originalConfig)
    {
        $this->originalConfig = $originalConfig;
    }

    public function getConfigParam($key)
    {
        if ($key == 'sShopDir') {
            return __DIR__;
        }
        else {
            return $this->originalConfig->getConfigParam($key);
        }

    }

}