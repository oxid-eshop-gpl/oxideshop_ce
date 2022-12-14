<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Database;

class TransactionService implements TransactionServiceInterface
{
    public function __construct(private ConnectionProviderInterface $connectionProvider)
    {
    }

    public function begin()
    {
        $this->connectionProvider->get()->beginTransaction();
    }

    public function commit()
    {
        $this->connectionProvider->get()->commit();
    }

    public function rollback()
    {
        $this->connectionProvider->get()->rollBack();
    }
}
