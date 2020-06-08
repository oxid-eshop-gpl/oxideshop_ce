<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Domain\Authentication\Service;

use OxidEsales\EshopCommunity\Internal\Domain\Authentication\DataObject\PasswordHashInterface;

interface PasswordHashServiceInterface
{
    public function fromHash(string $passwordHash): PasswordHashInterface;

    public function fromPassword(string $password): PasswordHashInterface;

    public function hash(string $password): string;

    public function passwordNeedsRehash(string $passwordHash): bool;
}
