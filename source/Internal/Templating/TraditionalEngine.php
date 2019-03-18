<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Templating;

/**
 * Class DelegatingEngine
 */
class TraditionalEngine implements TraditionalEngineInterface
{
    private $engine;

    private $templateNameResolver;

    /**
     * @param EngineInterface               $engine               An array of EngineInterface instances to add
     * @param TemplateNameResolverInterface $templateNameResolver
     */
    public function __construct($engine, TemplateNameResolverInterface $templateNameResolver)
    {
        $this->engine = $engine;
        $this->templateNameResolver = $templateNameResolver;
    }

    /**
     * @param string $template The template name
     * @param array  $viewData An array of parameters to pass to the template
     * @param string $cacheId  The id for template caching
     *
     * @return string
     */
    public function renderTemplate(string $template, array $viewData = [], $cacheId = null) : string
    {
        $templateName = $this->getTemplateName($template);
        /** @var EngineInterface $templating */
        $templating = $this->getEngine();
        $templating->setCacheId($cacheId);

        return $templating->render($templateName, $viewData);
    }

    /**
     * Return fallback engine.
     *
     * @throws \RuntimeException if no engine was defined.
     *
     * @return EngineInterface
     */
    public function getEngine() : EngineInterface
    {
        if (isset($this->engine)) {
            return $this->engine;
        }

        throw new \RuntimeException('No engine was defined.');
    }

    /**
     * @param string $template
     *
     * @return string
     */
    private function getTemplateName(string $template) : string
    {
        return $this->templateNameResolver->resolve($template, $this->getEngine()->getDefaultFileExtension());
    }

    /**
     * {@inheritdoc}
     */
 /*  public function render($name, array $parameters = array())
    {
        return $this->getEngine()->render($name, $parameters);
    }*/

    /**
     * Returns true if the template exists.
     *
     * @param string $name A template name
     *
     * @return bool true if the template exists, false otherwise
     *
     * @throws \RuntimeException if the engine cannot handle the template name
     */
    public function exists($name) : bool
    {
        $name = $this->getTemplateName($name);
        return $this->getEngine()->exists($name);
    }
}
