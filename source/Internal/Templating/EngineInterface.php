<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Templating;

/**
 * Interface EngineInterface
 */
interface EngineInterface extends \Symfony\Component\Templating\EngineInterface
{
    /**
     * @param string $templateName The template name
     * @param array  $viewData     An array of parameters to pass to the template
     * @param string $cacheId      The id for template caching
     *
     * @return string
     */
    public function renderTemplate($templateName, $viewData, $cacheId = null);

    /**
     * Set fallback engine, if not a template, but string will be given.
     *
     * @param BaseEngineInterface $engine
     */
    public function addFallBackEngine(BaseEngineInterface $engine);
}
