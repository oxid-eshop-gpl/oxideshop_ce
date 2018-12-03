<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Escaper;

use Twig\Environment;

/**
 * Class HtmlAllEscaper
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class HtmlAllEscaper implements EscaperInterface
{

    /**
     * @return string
     */
    public function getStrategy(): string
    {
        return 'htmlall';
    }

    /**
     * @param Environment $environment
     * @param string      $string
     * @param string      $charset
     *
     * @return string
     */
    public function escape(Environment $environment, $string, $charset): string
    {
        return htmlentities($string, ENT_QUOTES, $charset);
    }
}
