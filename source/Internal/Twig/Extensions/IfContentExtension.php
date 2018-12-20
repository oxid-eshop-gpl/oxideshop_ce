<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\IfContentLogic;
use OxidEsales\EshopCommunity\Internal\Twig\TokenParser\IfContentTokenParser;
use Twig\Extension\AbstractExtension;
use Twig\TokenParser\TokenParserInterface;

/**
 * Class IfContentExtension
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class IfContentExtension extends AbstractExtension
{

    /** @var IfContentLogic */
    private $ifContentLogic;

    /**
     * IfContentExtension constructor.
     *
     * @param IfContentLogic $ifContentLogic
     */
    public function __construct(IfContentLogic $ifContentLogic)
    {
        $this->ifContentLogic = $ifContentLogic;
    }

    /**
     * @return TokenParserInterface[]
     */
    public function getTokenParsers(): array
    {
        return [new IfContentTokenParser()];
    }

    /**
     * @param string $sIdent
     * @param string $sOxid
     *
     * @return mixed
     */
    public function getContent(string $sIdent, string $sOxid)
    {
        return $this->ifContentLogic->getContent($sIdent, $sOxid);
    }
}
