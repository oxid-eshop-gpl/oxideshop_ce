<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions;

use OxidEsales\EshopCommunity\Internal\Twig\TokenParser\CaptureTokenParser;
use Twig\Extension\AbstractExtension;
use Twig\TokenParser\TokenParserInterface;

/**
 * Class CaptureExtension
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Extensions
 * @author  Jędrzej Skoczek
 */
class CaptureExtension extends AbstractExtension
{

    /**
     * @return TokenParserInterface[]
     */
    public function getTokenParsers(): array
    {
        return [new CaptureTokenParser()];
    }
}
