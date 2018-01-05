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

#$I->click('Sign Up');
#$I->seeEmailSent('miles@davis.com', 'Thank you for registration');
#$I->seeInDatabase('users', ['email' => 'miles@davis.com']);

use OxidEsales\TestingLibrary\FunctionalTestCase;


/** Frontend: user registration */
class ANewUserRegistersCest
{
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
     * simple user account opening
     *
     * @group main
     */
    public function testStandardUserRegistration(\MyFunctionalTester $I)
    {
        $I->wantTo('register a new user');
        $I->amOnPage('/en/open-account/');
        $I->seeInSource('Register');

        $userData = [
            'lgn_usr'  => 'newtestuser@oxideshop.dev',
            'lgn_pwd'  => 'asdfasdf',
            'lgn_pwd2' => 'asdfasdf',
            'invadr'   => ['oxuser__oxfname' => 'Doerte',
                           'oxuser__oxlname' => 'Glupsch',
                           'oxuser__oxstreet' => 'Bertoldstrasse',
                           'oxuser__oxstreetnr' => '48',
                           'oxuser__oxzip' => '78098',
                           'oxuser__oxcity' => 'Freiburg',
                           'oxuser__oxcountryid' => 'a7c40f631fc920687.20179984'
            ]
        ];

        $I->submitForm('#accUserSaveTop', $userData);

        $I->seeInSource('You should have received an e-mail confirming your registration.');
        $I->haveInDatabase('oxuser', ['oxusername' => $userData['lgn_usr']]);
    }

}

