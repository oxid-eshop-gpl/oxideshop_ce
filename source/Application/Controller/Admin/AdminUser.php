<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Application\Controller\Admin;

/**
 * Admin user manager.
 * Returns template, that arranges two other templates ("user_list"
 * and "user_main") to frame.
 * Admin Menu: User Administration -> Users.
 */
class AdminUser extends \OxidEsales\Eshop\Application\Controller\Admin\AdminController
{
    /**
     * Current class template name.
     *
     * @var string
     */
    protected $_sThisTemplate = 'user';
}
