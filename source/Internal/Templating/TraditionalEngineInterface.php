<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Templating;

/**
 * Interface TraditionalEngineInterface
 */
interface TraditionalEngineInterface
{
    /**
     * @param string $template The template name
     * @param array  $viewData An array of parameters to pass to the template
     * @param string $cacheId  The id for template caching
     *
     * @return string
     */
    public function renderTemplate(string $template, array $viewData = [], $cacheId = null);

    /**
     * Renders a template.
     *
     * @param string $name       A template name
     * @param array  $parameters An array of parameters to pass to the template
     *
     * @return string The evaluated template as a string
     *
     * @throws \RuntimeException if the template cannot be rendered
     */
   // public function render($name, array $parameters = []);

    /**
     * @return EngineInterface
     */
    public function getEngine();

    /**
     * Returns true if the template exists.
     *
     * @param string $name A template name
     *
     * @return bool true if the template exists, false otherwise
     *
     * @throws \RuntimeException if the engine cannot handle the template name
     */
    public function exists($name);
}
