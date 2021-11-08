<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Core\Exception;

/**
 * exception class for clients without cookies support
 */
class CookieException extends \OxidEsales\Eshop\Core\Exception\StandardException
{
    /**
     * Exception type, currently old class name is used.
     *
     * @var string
     */
    protected $type = 'oxCookieException';

    public function __construct(
        $sMessage = "LOGIN_NO_COOKIE_SUPPORT",
        $iCode = 0,
        \Exception $previous = null
    ) {
        parent::__construct($sMessage, $iCode, $previous);
    }

    /**
     * Get string dump
     * Overrides oxException::getString()
     *
     * @return string
     */
    public function getString()
    {
        return __CLASS__ . '-' . parent::getString();
    }
}
