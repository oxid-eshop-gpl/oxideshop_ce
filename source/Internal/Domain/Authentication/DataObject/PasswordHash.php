<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Domain\Authentication\DataObject;

use OxidEsales\EshopCommunity\Internal\Domain\Authentication\Exception\PasswordHashException;

class PasswordHash implements PasswordHashInterface
{
    /**
     * @var string
     */
    private $passwordHash;

    private function __construct(string $passwordHash)
    {
        $hash = password_get_info($passwordHash);
        if ($hash['algo'] == null) {
            throw new PasswordHashException();
        }
        $this->passwordHash = $passwordHash;
    }

    public static function fromHash(string $passwordHash): self
    {
        return new self($passwordHash);
    }

    /**
     * @param int|string $algo
     */
    public static function fromPassword(string $password, $algo, array $options = []): self
    {
        return new self(
            password_hash(
                $password,
                $algo,
                $options
            )
        );
    }

    public function verify(string $password): bool
    {
        return password_verify($password, $this->passwordHash);
    }

    /**
     * @param int|string $algo
     */
    public function needsRehash($algo, array $options = []): bool
    {
        return password_needs_rehash($this->passwordHash, $algo, $options);
    }

    public function __toString()
    {
        return $this->passwordHash;
    }
}
