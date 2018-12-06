<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Extensions\HasRightsExtension;

/**
 * Class HasRightsNode
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Extensions\HasRightsExtension
 */
class HasRightsNode extends \Twig_Node
{

    /**
     * HasRightsNode constructor.
     *
     * @param \Twig_Node $params
     * @param int        $lineno
     * @param string     $tag
     */
    public function __construct(\Twig_Node $params, int $lineno = 0, string $tag = null)
    {
        parent::__construct(['HasRightsParams' => $params], [], $lineno, $tag);
    }

    /**
     * @param \Twig_Compiler $compiler
     */
    public function compile(\Twig_Compiler $compiler): void
    {
        $count = count($this->getNode('HasRightsParams'));

        $compiler->addDebugInfo($this);

        for ($i = 0; ($i < $count); $i++) {
            if (!($this->getNode('HasRightsParams')->getNode($i) instanceof \Twig_Node_Expression)) {
                $compiler->subcompile($this->getNode('HasRightsParams')->getNode($i));
            }
        }
    }
}
