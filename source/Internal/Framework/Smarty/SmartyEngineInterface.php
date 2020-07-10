<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Smarty;

interface SmartyEngineInterface
{
    /**
     * Pass parameters to the Smarty instance.
     *
     * @param string $name  The name of the parameter.
     * @param mixed  $value The value of the parameter.
     */
    public function __set($name, $value);

    /**
     * Pass parameters to the Smarty instance.
     *
     * @param string $name The name of the parameter.
     *
     * @return mixed
     */
    public function __get($name);

    /**
     * @return \Smarty
     */
    public function getSmarty(): \Smarty;
    /**
     * @param \Smarty $smarty
     */
    public function setSmarty(\Smarty $smarty);
}
