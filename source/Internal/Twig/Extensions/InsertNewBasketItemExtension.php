<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\InsertNewBasketItemLogicTwig;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class InsertNewBasketItemExtension
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Extensions
 * @author  Jędrzej Skoczek
 */
class InsertNewBasketItemExtension extends AbstractExtension
{

    /**
     * @var InsertNewBasketItemLogicTwig
     */
    private $newBasketItemLogic;

    /**
     * InputHelpExtension constructor.
     *
     * @param InsertNewBasketItemLogicTwig $newBasketItemLogic
     */
    public function __construct(InsertNewBasketItemLogicTwig $newBasketItemLogic)
    {
        $this->newBasketItemLogic = $newBasketItemLogic;
    }

    /**
     * @return array|\Twig_Function[]
     */
    public function getFunctions(): array
    {
        return [new TwigFunction('insert_new_basket_item', [$this, 'insertNewBasketItem'], ['needs_environment' => true])];
    }

    /**
     * @param Environment $env
     * @param array       $params
     *
     * @return string
     */
    public function insertNewBasketItem(Environment $env, $params): string
    {
        return $this->newBasketItemLogic->getNewBasketItemTemplate($params, $env);
    }
}
