<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 *
 * @author Jędrzej Skoczek & Tomasz Kowalewski
 */

namespace OxidEsales\EshopCommunity\Internal\Twig;

use OxidEsales\EshopCommunity\Internal\Templating\EngineInterface;
use OxidEsales\EshopCommunity\Internal\Twig\Escaper\EscaperInterface;
use Twig\Environment;
use Twig\Extension\CoreExtension;

/**
 * Class TwigEngine
 */
class TwigEngine implements EngineInterface
{

    /**
     * @var \Twig_Environment
     */
    private $engine;

    /**
     * TwigEngine constructor.
     *
     * @param Environment $engine
     */
    public function __construct(Environment $engine)
    {
        $this->engine = $engine;

        if ($this->engine->isDebug()) {
            $this->engine->addExtension(new \Twig_Extension_Debug());
        }
    }

    /**
     * Returns the template file extension.
     *
     * @return string
     */
    public function getDefaultFileExtension(): string
    {
        return 'html.twig';
    }

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
    public function render($name, array $parameters = array()): string
    {
        return $this->engine->render($name, $parameters);
    }

    /**
     * Returns true if the template exists.
     *
     * @param string $name A template name
     *
     * @return bool true if the template exists, false otherwise
     *
     * @throws \RuntimeException if the engine cannot handle the template name
     */
    public function exists($name): bool
    {
        return $this->engine->getLoader()->exists($name);
    }

    /**
     * @param string $cacheId
     */
    public function setCacheId($cacheId): void
    {
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function addGlobal($name, $value): void
    {
        $this->engine->addGlobal($name, $value);
    }

    /**
     * Returns assigned globals.
     *
     * @return array
     */
    public function getGlobals(): array
    {
        return $this->engine->getGlobals();
    }

    /**
     * @param EscaperInterface $escaper
     */
    public function addEscaper(EscaperInterface $escaper)
    {
        /** @var CoreExtension $coreExtension */
        $coreExtension = $this->engine->getExtension(CoreExtension::class);
        $coreExtension->setEscaper($escaper->getStrategy(), [$escaper, 'escape']);
    }
}
