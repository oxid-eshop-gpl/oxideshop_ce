<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use Twig\Error\Error;
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
        $formattedTime = $this->getFormattedTime($seconds);

        return $formattedTime;
    }

    /**
     * @param int $seconds
     *
     * @return string
     */
    private function getFormattedTime($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor($seconds % 3600 / 60);
        $seconds = $seconds % 60;

        return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    }
}
