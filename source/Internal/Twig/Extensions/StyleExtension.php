<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\StyleLogic;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class AssignAdvancedExtension
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Extensions
 */
class StyleExtension extends AbstractExtension
{

    /**
     * @var StyleLogic
     */
    private $styleLogic;

    /**
     * StyleExtension constructor.
     *
     * @param StyleLogic $styleLogic
     */
    public function __construct(StyleLogic $styleLogic)
    {
        $this->styleLogic = $styleLogic;
    }

    /**
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [new TwigFunction('style', [$this, 'style'], ['needs_environment' => true])];
    }

    /**
     * @param \Twig_Environment $env
     * @param array             $params
     *
     * @return string
     */
    public function style(\Twig_Environment $env, $params)
    {
        $globals = $env->getGlobals();
        $isDynamic = false;
        if (isset($globals['__oxid_include_dynamic'])) {
            $isDynamic = $globals['__oxid_include_dynamic'];
        }

        $output = $this->styleLogic->collectStyleSheets($params, $isDynamic);

        return $output;
    }
}
