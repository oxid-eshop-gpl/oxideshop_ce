<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class PhpFunctionsExtension
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Extensions
 * @author  Jędrzej Skoczek
 * @deprecated
 */
class PhpFunctionsExtension extends AbstractExtension
{

    /**
     * @return array|\Twig_Function[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('count', 'count'),
            new TwigFunction('empty', 'empty'),
            new TwigFunction('isset', [$this, 'twigIsset'])
        ];
    }

    /**
     * @param null $value
     *
     * @return bool
     */
    public function twigIsset($value = null): bool
    {
        return isset($value);
    }
}
