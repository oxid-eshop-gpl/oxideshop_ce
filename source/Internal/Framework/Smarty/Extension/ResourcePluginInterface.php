<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Internal\Framework\Smarty\Extension;

/**
 * Smarty resource interface
 */
interface ResourcePluginInterface
{
    /**
     * @see http://www.smarty.net/docsv2/en/template.resources.tpl
     *
     * @param string $templateName   The name of template
     * @param string $templateSource The template source
     * @param object $smarty         The smarty object
     *
     * @return bool
     */
    public static function getTemplate($templateName, &$templateSource, $smarty): bool;

    /**
     * @see http://www.smarty.net/docsv2/en/template.resources.tpl
     *
     * @param string $templateName      The name of template
     * @param string $templateTimestamp The template timestamp reference
     * @param object $smarty            The smarty object
     *
     * @return bool
     */
    public static function getTimestamp($templateName, &$templateTimestamp, $smarty): bool;

    /**
     * @see http://www.smarty.net/docsv2/en/template.resources.tpl
     *
     * @param string $templateName The name of template
     * @param object $smarty       The smarty object
     *
     * @return bool
     */
    public static function getSecure($templateName, $smarty): bool;

    /**
     * @see http://www.smarty.net/docsv2/en/template.resources.tpl
     *
     * @param string $templateName The name of template
     * @param object $smarty       The smarty object
     */
    public static function getTrusted($templateName, $smarty): void;
}
