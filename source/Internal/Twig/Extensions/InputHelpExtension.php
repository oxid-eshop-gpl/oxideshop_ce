<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\InputHelpLogic;
use OxidEsales\EshopCommunity\Internal\Twig\TwigEngine;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class OxidExtension
 */
class InputHelpExtension extends AbstractExtension
{

    /**
     * @var InputHelpLogic
     */
    private $inputHelpLogic;

    /**
     * InputHelpExtension constructor.
     *
     * @param InputHelpLogic $inputHelpLogic
     */
    public function __construct(InputHelpLogic $inputHelpLogic)
    {
        $this->inputHelpLogic = $inputHelpLogic;
    }

    /**
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('getSHelpId', [$this, 'getSHelpId']),
            new TwigFunction('getSHelpText', [$this, 'getSHelpText'])
        ];
    }

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function getSHelpId($params)
    {
        return $this->inputHelpLogic->getIdent($params);
    }

    /**
     * @param string $params
     *
     * @return mixed
     */
    public function getSHelpText($params)
    {
        return $this->inputHelpLogic->getTranslation($params);
    }
}
