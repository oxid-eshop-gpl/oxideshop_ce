<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Application\Controller\Admin;

/**
 * Admin attributes manager.
 * Collects attributes base information (Description), there is ability to filter
 * them by Description or delete them.
 * Admin Menu: Manage Products -> Attributes.
 */
class AttributeList extends \OxidEsales\Eshop\Application\Controller\Admin\AdminListController
{
    /**
     * Current class template name.
     *
     * @var string
     */
    protected $_sThisTemplate = 'attribute_list';

    /**
     * Name of chosen object class (default null).
     *
     * @var string
     */
    protected $_sListClass = 'oxattribute';

    /**
     * Default SQL sorting parameter (default null).
     *
     * @var string
     */
    protected $_sDefSortField = 'oxtitle';
}
