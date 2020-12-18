<?php declare(strict_types=1);
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests;

use OxidEsales\Eshop\Core\DatabaseProvider;

trait DatabaseTrait
{
    public function beginTransaction()
    {
        DatabaseProvider::getDb()->startTransaction();
    }

    public function rollBackTransaction()
    {
        if (DatabaseProvider::getDb()->isTransactionActive()) {
            DatabaseProvider::getDb()->rollbackTransaction();
        }
    }
}