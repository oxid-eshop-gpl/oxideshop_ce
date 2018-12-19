<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic;

/**
 * Class WordWrapLogic
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class WordWrapLogic
{

    /**
     * @param string  $string
     * @param integer $length
     * @param string  $wrapper
     * @param bool    $cut
     *
     * @return string
     */
    public function wordWrap(string $string, int $length = 80, string $wrapper = "\n", bool $cut = false): string
    {
        return getStr()->wordwrap($string, $length, $wrapper, $cut);
    }
}
