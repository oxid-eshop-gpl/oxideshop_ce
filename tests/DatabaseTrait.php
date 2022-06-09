<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests;

use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Facts\Facts;

trait DatabaseTrait
{
    public function beginTransaction(): void
    {
        DatabaseProvider::getDb()->startTransaction();
    }

    public function rollBackTransaction(): void
    {
        if (DatabaseProvider::getDb()->isTransactionActive()) {
            DatabaseProvider::getDb()->rollbackTransaction();
        }
    }

    public function setupShopDatabase()
    {
        $facts = new Facts();
        exec(
            $facts->getCommunityEditionRootPath() .
            '/vendor/bin/reset-shop-database'
        );
    }
}
