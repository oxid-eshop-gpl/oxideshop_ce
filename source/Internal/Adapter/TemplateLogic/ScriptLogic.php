<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic;

/**
 * Class ScriptLogic
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class ScriptLogic
{

    /**
     * @param string $script
     * @param bool   $isDynamic
     */
    public function add($script, $isDynamic = false)
    {
        $register = oxNew(\OxidEsales\Eshop\Core\ViewHelper\JavaScriptRegistrator::class);
        $register->addSnippet($script, $isDynamic);
    }

    /**
     * @param string $file
     * @param int    $priority
     * @param bool   $isDynamic
     */
    public function include($file, $priority = 3, $isDynamic = false)
    {
        $register = oxNew(\OxidEsales\Eshop\Core\ViewHelper\JavaScriptRegistrator::class);
        $register->addFile($file, $priority, $isDynamic);
    }

    /**
     * @param string $widget
     * @param bool   $forceRender
     * @param bool   $isDynamic
     *
     * @return string
     */
    public function render($widget, $forceRender = false, $isDynamic = false)
    {
        $renderer = oxNew(\OxidEsales\Eshop\Core\ViewHelper\JavaScriptRenderer::class);

        return $renderer->render($widget, $forceRender, $isDynamic);
    }
}
