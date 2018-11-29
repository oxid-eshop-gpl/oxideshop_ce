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
     * @param string  $sString
     * @param integer $iLength
     * @param string  $sWraper
     * @param bool    $blCut
     *
     * @return string
     */
    public function wordWrap($sString, $iLength = 80, $sWraper = "\n", $blCut = false)
    {
        return getStr()->wordwrap($sString, $iLength, $sWraper, $blCut);
    }
}
