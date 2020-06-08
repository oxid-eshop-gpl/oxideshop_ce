<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Domain\Authentication\DataObject;

interface PasswordHashInterface
{
    public static function fromHash(string $passwordHash): self;

    /**
     * @param int|string $algo
     */
    public static function fromPassword(string $password, $algo, array $options = []): self;

    public function verify(string $password): bool;
    
    /**
     * @param int|string $algo
     */
    public function needsRehash($algo, array $options = []): bool;

    public function __toString();
}
