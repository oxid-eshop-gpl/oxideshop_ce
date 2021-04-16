<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Integration;

use OxidEsales\EshopCommunity\Tests\CachingTrait;
use OxidEsales\EshopCommunity\Tests\Integration\Internal\ContainerTrait;
use OxidEsales\EshopCommunity\Tests\DatabaseTrait;
use PHPUnit\Framework\TestCase;

class IntegrationTestCase extends TestCase
{
    use ContainerTrait;
    use CachingTrait;
    use DatabaseTrait;

    public function setUp()
    {
        parent::setUp();
        $this->cleanupCaching();
        $this->beginTransaction();
    }

    public function tearDown()
    {
        $this->rollBackTransaction();
        $this->cleanupCaching();
        parent::tearDown();
    }
}
