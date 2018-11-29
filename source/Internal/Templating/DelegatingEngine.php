<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Templating;

use Symfony\Component\Templating\DelegatingEngine as BaseDelegatingEngine;

/**
 * Class DelegatingEngine
 */
class DelegatingEngine extends BaseDelegatingEngine implements EngineInterface
{
    /**
     * @var BaseEngineInterface
     */
    private $fallBackEngine;

    /**
     * @param string $templateName The template name
     * @param array  $viewData     An array of parameters to pass to the template
     * @param string $cacheId      The id for template caching
     *
     * @return string
     */
    public function renderTemplate($templateName, $viewData, $cacheId = null) : string
    {
        /** @var BaseEngineInterface $templating */
        $templating = $this->getEngine($templateName);
        $templating->setCacheId($cacheId);

        return $templating->render($templateName, $viewData);
    }

    /**
     * Set fallback engine, if not a template, but string will be given.
     *
     * @param BaseEngineInterface $engine
     */
    public function addFallBackEngine(BaseEngineInterface $engine)
    {
        $this->fallBackEngine = $engine;
    }

    /**
     * {@inheritdoc}
     */
    public function getEngine($name = '')
    {
        if (empty($name)) {
            return $this->getFallBackEngine();
        }

        return parent::getEngine($name);
    }

    /**
     * Return fallback engine.
     *
     * @throws \RuntimeException if no engine was defined.
     *
     * @return BaseEngineInterface
     */
    private function getFallBackEngine() : BaseEngineInterface
    {
        if (isset($this->fallBackEngine)) {
            return $this->fallBackEngine;
        }

        throw new \RuntimeException('No engine was defined.');
    }
}
