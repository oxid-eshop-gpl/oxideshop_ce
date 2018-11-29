<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Twig\Escaper;

use Twig\Environment;

/**
 * Class MailEscaper
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class MailEscaper implements EscaperInterface
{

    /**
     * @return string
     */
    public function getStrategy(): string
    {
        return 'mail';
    }

    /**
     * @param Environment $environment
     * @param string      $string
     *
     * @return string
     */
    public function escape(Environment $environment, $string): string
    {
        return str_replace(['@', '.'], [' [AT] ', ' [DOT] '], $string);
    }
}
