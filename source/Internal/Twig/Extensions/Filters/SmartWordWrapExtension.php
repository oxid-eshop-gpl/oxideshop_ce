<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\SmartWordWrapLogic;
use Twig\Extension\AbstractExtension;

/**
 * Class SmartWordWrapExtension
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters
 * @author  Jędrzej Skoczek
 */
class SmartWordWrapExtension extends AbstractExtension
{

    /**
     * @var SmartWordWrapLogic
     */
    private $smartWordWrapLogic;

    /**
     * SmartWordWrapExtension constructor.
     *
     * @param SmartWordWrapLogic $smartWordWrapLogic
     */
    public function __construct(SmartWordWrapLogic $smartWordWrapLogic)
    {
        $this->smartWordWrapLogic = $smartWordWrapLogic;
    }

    /**
     * @return array|\Twig_Filter[]
     */
    public function getFilters()
    {
        return [new \Twig_Filter('smart_word_wrap', [$this, 'smartWordWrap'], array('is_safe' => array('html')))];
    }

    /**
     * @param string $string
     * @param int    $length
     * @param string $break
     * @param int    $cutRows
     * @param int    $tolerance
     * @param string $etc
     *
     * @return string
     */
    public function smartWordWrap($string, $length = 80, $break = "\n", $cutRows = 0, $tolerance = 0, $etc = '...')
    {
        return $this->smartWordWrapLogic->wrapWords($string, $length, $break, $cutRows, $tolerance, $etc);
    }
}
