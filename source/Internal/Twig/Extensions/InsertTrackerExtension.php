<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class InsertTrackerExtension
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Extensions
 * @author  Jędrzej Skoczek
 */
class InsertTrackerExtension extends AbstractExtension
{

    /**
     * @return array|\Twig_Function[]
     */
    public function getFunctions(): array
    {
        return [new TwigFunction('insert_tracker', [$this, 'insertTracker'], ['needs_environment' => true])];
    }

    /**
     * @param  \Twig_Environment $env
     * @param  array             $params
     *
     * @return string
     */
    public function insertTracker(\Twig_Environment $env = null, $params = []): string
    {
        return '';
    }
}
