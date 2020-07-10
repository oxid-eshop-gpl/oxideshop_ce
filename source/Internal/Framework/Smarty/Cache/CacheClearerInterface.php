<?php


namespace OxidEsales\EshopCommunity\Internal\Framework\Smarty\Cache;

/**
 * CacheClearerInterface.
 */
interface CacheClearerInterface
{
    /**
     * @param array $cache
     *
     * @return mixed
     */
    public function clear(array $cache);
}
