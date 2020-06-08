<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Domain\Authentication\Service;

use OxidEsales\EshopCommunity\Internal\Domain\Authentication\DataObject\PasswordHash;
use OxidEsales\EshopCommunity\Internal\Domain\Authentication\DataObject\PasswordHashInterface;
use OxidEsales\EshopCommunity\Internal\Domain\Authentication\Service\PasswordHashServiceInterface;

final class PasswordHashService implements PasswordHashServiceInterface
{
    private $algo;
    private $options;

    public function __construct(
        $algo,
        $options
    ) {
        $this->algo = $algo;
        $this->options = $options;
    }

    public function fromHash(string $passwordHash): PasswordHashInterface
    {
        return PasswordHash::fromHash($passwordHash);
    }

    public function fromPassword(string $password): PasswordHashInterface
    {
        return PasswordHash::fromPassword($password, $this->algo, $this->options);
    }

    public function hash($password): string
    {
        return (string) $this->fromPassword($password);
    }

    public function passwordNeedsRehash($passwordHash): bool
    {
        return $this->fromHash($passwordHash)->needsRehash($this->algo, $this->options);
    }
}
