<?php


namespace OxidEsales\EshopCommunity\Internal\Framework\Smarty\Cache;

use OxidEsales\EshopCommunity\Internal\Framework\Smarty\SmartyEngineInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\Cache\CacheClearerInterface;

/**
 * TemplateCacheClearer.
 */
class TemplateCacheClearer implements CacheClearerInterface
{
    /**
     * @var SmartyEngineInterface
     */
    private $engine;

    public function __construct(SmartyEngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * @param array $cache
     */
    public function clear(array $cache): void
    {
        $engine = $this->engine->getSmarty();
        foreach ($cache as $template) {
            $engine->clear_compiled_tpl($template);
        }
    }
}
