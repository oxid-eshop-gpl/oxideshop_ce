<?php

namespace OxidEsales\EshopCommunity\Tests;

use OxidEsales\EshopCommunity\Tests\DatabaseTrait;

class TestListener extends \PHPUnit\Framework\BaseTestListener
{
    use DatabaseTrait;
    public function startTestSuite(\PHPUnit\Framework\TestSuite $suite)
    {
        if (strpos($suite->getName(),"Integration") !== false ) {
            $this->setupShopDatabase();
        }
    }
}