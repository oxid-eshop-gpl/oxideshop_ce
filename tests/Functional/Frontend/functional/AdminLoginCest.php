<?php
/**
 * This file is part of OXID eShop Community Edition.
 *
 * OXID eShop Community Edition is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eShop Community Edition is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eShop Community Edition.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2016
 * @version   OXID eShop CE
 */

use OxidEsales\TestingLibrary\FunctionalTestCase;

class AdminLoginCest
{
    const ADMIN_USERNAME = 'admin@myoxideshop.com';
    const ADMIN_PASSWORD = 'admin0303';
    const ADMIN_LANGUAGE = 'English';

    /**
     * SetUp
     *
     * @param MyFunctionalTester $I
     */
    public function _before(\MyFunctionalTester $I)
    {
        $path = __DIR__ . '/../../';

        $case = new FunctionalTestCase;
        $case->setUp($path);
    }

    /**
     * TearDown
     *
     * @param MyFunctionalTester $I
     */
    public function _after(\MyFunctionalTester $I)
    {
        $case = new FunctionalTestCase;
        $case->tearDown();
    }


    /**
     * Successfully log in an admin user
     */
    public function AdminLoginSuccess(\MyFunctionalTester $I)
    {
        $I->wantTo('login to shop admin');
        $I->amOnPage('/admin');
        $I->seeInSource('Start OXID eShop Admin');

        $I->submitForm('#login', ['user' => self::ADMIN_USERNAME, 'pwd' => self::ADMIN_PASSWORD, 'lng' => self::ADMIN_LANGUAGE]);
        $I->seeInSource('OXID eShop Administrationsbereich');
    }

    /**
     * Wrong credentials admin user
     */
    public function AdminLoginError(\MyFunctionalTester $I)
    {
        $I->wantTo('see error for login to shop admin');
        $I->amOnPage('/admin');
        $I->seeInSource('Start OXID eShop Admin');

        $I->submitForm('#login', ['user' => 'bla', 'pwd' => 'foo', 'lng' => self::ADMIN_LANGUAGE]);
        $I->see('Error! Incorrect username and/or password!');
    }
}
