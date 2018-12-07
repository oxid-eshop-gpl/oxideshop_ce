<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic;

/**
 * Class IncludeWidgetLogic
 *
 * @package OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic
 * @author  Jędrzej Skoczek
 */
class IncludeWidgetLogic
{

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function renderWidget($params)
    {
        $class = '';
        if (isset($params['cl'])) {
            $class = strtolower($params['cl']);
            unset($params['cl']);
        }

        $parentViews = null;
        if (!empty($params["_parent"])) {
            $parentViews = explode("|", $params["_parent"]);
            unset($params["_parent"]);
        }

        $widgetControl = \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\WidgetControl::class);

        return $widgetControl->start($class, null, $params, $parentViews);
    }
}
