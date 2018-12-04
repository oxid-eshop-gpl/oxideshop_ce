<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class PhpFunctionsExtension
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters
 * @author  Jędrzej Skoczek
 * @deprecated
 */
class PhpFunctionsExtension extends AbstractExtension
{

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('parse_url', 'parse_url'),
            new TwigFilter('oxNew', 'oxNew'),
            new TwigFilter('strtotime', 'strtotime'),
            new TwigFilter('is_array', 'is_array')
        ];
    }
}
