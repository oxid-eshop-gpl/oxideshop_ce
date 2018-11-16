<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FormatTimeLogic;
use Twig\Extension\AbstractExtension;

/**
 * Class FormatTimeExtension
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Filters
 * @author  Jędrzej Skoczek
 */
class FormatTimeExtension extends AbstractExtension
{

    /**
     * @var FormatTimeLogic
     */
    private $formatTimeLogic;

    public function __construct(FormatTimeLogic $formatTimeLogic)
    {
        $this->formatTimeLogic = $formatTimeLogic;
    }

    /**
     * @return array|\Twig_Filter[]
     */
    public function getFilters()
    {
        return [new \Twig_Filter('formatTime', [$this, 'formatTime'])];
    }

    /**
     * @param int $seconds
     *
     * @return string
     */
    public function formatTime($seconds)
    {
        if (!is_int($seconds)) {
            throw new \Twig_Error('Given argument is not an integer');
        }
        $formattedTime = $this->formatTimeLogic->getFormattedTime($seconds);

        return $formattedTime;
    }

}
