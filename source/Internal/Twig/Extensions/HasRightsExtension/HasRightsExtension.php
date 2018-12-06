<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\HasRightsExtension;

use Twig\Extension\AbstractExtension;

/**
 * Class HasRightsExtension
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Extensions\HasRightsExtension
 */
class HasRightsExtension extends AbstractExtension
{

    /**
     * @return array|\Twig_TokenParserInterface[]
     */
    public function getTokenParsers(): array
    {
        return [new HasRightsParser()];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'hasrights';
    }

    /**
     * @return array|\Twig_NodeVisitorInterface[]
     */
    public function getNodeVisitors(): array
    {
        return [new HasRightsVisitor()];
    }
}
