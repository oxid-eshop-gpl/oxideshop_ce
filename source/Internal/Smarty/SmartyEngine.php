<?php declare(strict_types=1);
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Smarty;

use OxidEsales\EshopCommunity\Internal\Templating\EngineInterface;
use Symfony\Component\Templating\TemplateNameParserInterface;

/**
 * Class SmartyEngine
 *
 * @package OxidEsales\EshopCommunity\Internal\Smarty
 */
class SmartyEngine implements EngineInterface
{
    /**
     * @var string
     */
    private $cacheId;

    /**
     * The template engine.
     *
     * @var \Smarty
     */
    private $engine;

    /**
     * Array of global parameters
     *
     * @var array
     */
    private $globals = [];

    /**
     * Constructor.
     *
     * @param \Smarty $engine
     */
    public function __construct(\Smarty $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Returns the template file extension.
     *
     * @return string
     */
    public function getDefaultFileExtension(): string
    {
        return 'tpl';
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
    public function render(string $name, array $parameters = array()): string
    {
        // attach the global variables
       // $parameters = array_replace($this->getGlobals(), $parameters);
        foreach ($parameters as $key => $value) {
            $this->engine->assign($key, $value);
        }
        if (isset($this->cacheId)) {
            return $this->engine->fetch($name, $this->cacheId);
        }
        return $this->engine->fetch($name);
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function addGlobal($name, $value)
    {
        $this->globals[$name] = $value;
        $this->engine->assign($name, $value);
    }

    /**
     * Returns assigned globals.
     *
     * @return array
     */
    public function getGlobals(): array
    {
        return $this->globals;
    }

    /**
     * Renders a fragment of the template.
     *
     * @param string $fragment   The template fragment to render
     * @param array  $parameters An array of parameters to pass to the template
     *
     * @return string The evaluated template as a string
     */
    public function renderFragment(string $fragment, array $parameters = []): string
    {
        // save old tpl data
        $tplVars = $this->engine->_tpl_vars;
        $forceRecompile = $this->engine->force_compile;
        $this->engine->force_compile = true;
        foreach ($parameters as $key => $value) {
            $this->engine->assign($key, $value);
        }
        $this->engine->oxidcache = new \OxidEsales\Eshop\Core\Field($fragment, \OxidEsales\Eshop\Core\Field::T_RAW);
        $result =  $this->engine->fetch($this->cacheId);
        $this->engine->_tpl_vars = $tplVars;
        $this->engine->force_compile = $forceRecompile;
        return $result;
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
        return $this->engine->template_exists($name);
    }

    /**
     * @param string $cacheId
     */
    public function setCacheId($cacheId)
    {
        $this->cacheId = $cacheId;
    }

    /**
     * Pass parameters to the Smarty instance.
     *
     * @param string $name  The name of the parameter.
     * @param mixed  $value The value of the parameter.
     */
    public function __set($name, $value)
    {
        $this->engine->$name = $value;
    }

    /**
     * Pass parameters to the Smarty instance.
     *
     * @param string $name The name of the parameter.
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->engine->$name;
    }
}
