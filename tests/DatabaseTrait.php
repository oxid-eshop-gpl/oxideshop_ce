<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests;

use OxidEsales\Eshop\Core\DatabaseProvider;

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
}
