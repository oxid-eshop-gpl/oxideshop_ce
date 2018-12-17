<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Node;

use Twig_Node as Node;
use Twig_Compiler as Compiler;

/**
 * Class HasRightsNode
 *
 * @package OxidEsales\EshopCommunity\Internal\Twig\Node
 */
class HasRightsNode extends Node
{

    /**
     * HasRightsNode constructor.
     *
     * @param Node   $body
     * @param Node   $parameters
     * @param int    $lineno
     * @param string $tag
     */
    public function __construct(Node $body, Node $parameters, int $lineno, $tag = 'hasrights')
    {
        parent::__construct(['body' => $body, 'parameters' => $parameters], [], $lineno, $tag);
    }

    /**
     * @param Compiler $compiler
     */
    public function compile(Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        $compiler->subcompile($this->getNode('body'));
    }
}
