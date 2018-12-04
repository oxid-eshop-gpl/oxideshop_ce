<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\DateFormatHelper;
use Twig\Extension\AbstractExtension;

/**
 * Class DateFormatExtension
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters
 * @author  Jędrzej Skoczek
 */
class DateFormatExtension extends AbstractExtension
{

    /**
     * @var DateFormatHelper
     */
    private $dateFormatHelper;

    /**
     * DateFormatExtension constructor.
     *
     * @param DateFormatHelper $dateFormatHelper
     */
    public function __construct(DateFormatHelper $dateFormatHelper)
    {
        $this->dateFormatHelper = $dateFormatHelper;
    }

    /**
     * @return array|\Twig_Filter[]
     */
    public function getFilters()
    {
        return [new \Twig_Filter('date_format', [$this, 'dateFormat'])];
    }

    /**
     * Smarty date_format modifier plugin
     *
     * @param string $string
     * @param string $format
     * @param string $defaultDate
     *
     * @return string|null
     */
    public function dateFormat($string, $format = '%b %e, %Y', $defaultDate = '')
    {
        if ($string != '') {
            $timestamp = $this->getTimestamp($string);
        } elseif ($defaultDate != '') {
            $timestamp = $this->getTimestamp($defaultDate);
        } else {
            return null;
        }

        if (DIRECTORY_SEPARATOR == '\\') {
            $format = $this->dateFormatHelper->fixWindowsTimeFormat($format, $timestamp);
        }

        return strftime($format, $timestamp);
    }

    /**
     * smarty_make_timestamp
     *
     * @param string $string
     *
     * @return false|int
     */
    private function getTimestamp($string)
    {

        if (empty($string)) {
            // use "now":
            $time = time();
        } elseif (preg_match('/^\d{14}$/', $string)) {
            // it is mysql timestamp format of YYYYMMDDHHMMSS?
            $time = mktime(
                substr($string, 8, 2),
                substr($string, 10, 2),
                substr($string, 12, 2),
                substr($string, 4, 2),
                substr($string, 6, 2),
                substr($string, 0, 4)
            );
        } elseif (is_numeric($string)) {
            // it is a numeric string, we handle it as timestamp
            $time = (int) $string;
        } else {
            // strtotime should handle it
            $time = strtotime($string);
            if ($time == -1 || $time === false) {
                // strtotime() was not able to parse $string, use "now":
                $time = time();
            }
        }

        return $time;
    }
}
