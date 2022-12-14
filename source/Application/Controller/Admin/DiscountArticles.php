<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Application\Controller\Admin;

use OxidEsales\Eshop\Core\Registry;

/**
 * Admin article main discount manager.
 * There is possibility to change discount name, article, user
 * and etc.
 * Admin Menu: Shop settings -> Shipping & Handling -> Main.
 */
class DiscountArticles extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{
    /** @inheritdoc */
    public function render()
    {
        parent::render();

        $soxId = $this->getEditObjectId();
        if (isset($soxId) && $soxId != '-1') {
            // load object
            $oDiscount = oxNew(\OxidEsales\Eshop\Application\Model\Discount::class);
            $oDiscount->load($soxId);
            $this->_aViewData['edit'] = $oDiscount;

            //disabling derived items
            if ($oDiscount->isDerived()) {
                $this->_aViewData['readonly'] = true;
            }

            // generating category tree for artikel choose select list
            $this->createCategoryTree("artcattree");
        }

        $iAoc = Registry::getRequest()->getRequestEscapedParameter("aoc");
        if ($iAoc == 1) {
            $oDiscountArticlesAjax = oxNew(\OxidEsales\Eshop\Application\Controller\Admin\DiscountArticlesAjax::class);
            $this->_aViewData['oxajax'] = $oDiscountArticlesAjax->getColumns();

            return "popups/discount_articles";
        } elseif ($iAoc == 2) {
            $oDiscountCategoriesAjax = oxNew(\OxidEsales\Eshop\Application\Controller\Admin\DiscountCategoriesAjax::class);
            $this->_aViewData['oxajax'] = $oDiscountCategoriesAjax->getColumns();

            return "popups/discount_categories";
        }

        return 'discount_articles';
    }
}
