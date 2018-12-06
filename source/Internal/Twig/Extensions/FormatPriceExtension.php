<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FormatPriceLogic;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class FormatPriceExtension
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Extensions
 */
class FormatPriceExtension extends AbstractExtension
{

    /**
     * @var FormatPriceLogic
     */
    private $formatPriceLogic;

    /**
     * FormatPriceExtension constructor.
     *
     * @param FormatPriceLogic $formatPriceLogic
     */
    public function __construct(FormatPriceLogic $formatPriceLogic)
    {
        $this->formatPriceLogic = $formatPriceLogic;
    }

    /**
     * @return array|\Twig_Function[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('formatPrice', [$this, 'formatPrice']) //todo fix names also coverter fml.
        ];
    }

    /**
     * @param array $params
     *
     * @return string
     */
    public function formatPrice(array $params): string
    {
        return $this->formatPriceLogic->formatPrice($params);
    }
}
