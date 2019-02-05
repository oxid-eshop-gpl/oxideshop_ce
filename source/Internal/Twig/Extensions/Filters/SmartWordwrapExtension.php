<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\SmartWordwrapLogic;
use Twig\Extension\AbstractExtension;

/**
 * Class SmartWordwrapExtension
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters
 * @author  Jędrzej Skoczek
 */
class SmartWordwrapExtension extends AbstractExtension
{

    /**
     * @var SmartWordwrapLogic
     */
    private $smartWordWrapLogic;

    /**
     * SmartWordwrapExtension constructor.
     *
     * @param SmartWordwrapLogic $smartWordWrapLogic
     */
    public function __construct(SmartWordwrapLogic $smartWordWrapLogic)
    {
        $this->smartWordWrapLogic = $smartWordWrapLogic;
    }

    /**
     * @return array|\Twig_Filter[]
     */
    public function getFilters()
    {
        return [new \Twig_Filter('smart_wordwrap', [$this, 'smartWordwrap'], array('is_safe' => array('html')))];
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
    public function smartWordwrap($string, $length = 80, $break = "\n", $cutRows = 0, $tolerance = 0, $etc = '...')
    {
        return $this->smartWordWrapLogic->wrapWords($string, $length, $break, $cutRows, $tolerance, $etc);
    }
}
