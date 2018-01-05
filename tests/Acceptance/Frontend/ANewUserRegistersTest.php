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

namespace OxidEsales\EshopCommunity\Tests\Acceptance\Frontend;

use OxidEsales\EshopCommunity\Tests\Acceptance\FrontendTestCase;

/** Frontend: user registration */
class ANewUserRegistersTest extends FrontendTestCase
{
    const ADMIN_USERNAME = 'admin@myoxideshop.com';
    const ADMIN_PASSWORD = 'admin0303';
    const ADMIN_LANGUAGE = 'English';

    /**
     * Log in admin user, success case.
     */
    public function testAdminLogsInSuccess()
    {
        $this->openNewWindow(shopURL . 'admin');

        $this->type('usr', self::ADMIN_USERNAME);
        $this->type('pwd', self::ADMIN_PASSWORD);
        $this->select('lng', self::ADMIN_LANGUAGE);
        $this->select('prf', 'Standard');
        $this->clickAndWait('//input[@type="submit"]');

        $this->frame("navigation");
        $this->assertTextPresent('MASTER SETTINGS');
    }

    /**
     * Log in admin user, wrong credentials error case.
     */
    public function testAdminLogsInError()
    {
        $this->openNewWindow(shopURL . 'admin');

        $this->type('usr', 'noadminuser');
        $this->type('pwd', 'invalid');
        $this->select('lng', self::ADMIN_LANGUAGE);
        $this->select('prf', 'Standard');
        $this->clickAndWait('//input[@type="submit"]');

        $this->assertTextPresent('Error! Incorrect username and/or password!');
    }

    /**
     * simple user account opening
     *
     * @group main
     */
    public function testStandardUserRegistration()
    {
        //creating user
        $this->clearCache();
        $this->openShop();
        $this->clickAndWait("//ul[@id='topMenu']//a[text()='%PAGE_TITLE_REGISTER%']");
        $this->assertEquals("%YOU_ARE_HERE%: / %PAGE_TITLE_REGISTER%", $this->getText("breadCrumb"));

        $this->assertEquals("off", $this->getValue("//input[@name='blnewssubscribed' and @value='1']"));
        $this->assertFalse($this->isVisible("oxStateSelect_invadr[oxuser__oxstateid]"));

        $aUserData = $this->getUserData( 1, 'user1user1' );
        $this->fillUserInfo( $aUserData );

        $this->clickAndWait("accUserSaveTop", 90);
        $this->assertTextPresent("%PAGE_TITLE_REGISTER%");

        $sUser = $aUserData['oxfname'].' '.$aUserData['oxlname'];
        $this->assertEquals( $sUser, $this->getText("//ul[@id='topMenu']/li/a"));
        $this->assertEquals("%YOU_ARE_HERE%: / %PAGE_TITLE_REGISTER%", $this->getText("breadCrumb"));

        $this->assertUserExists( $aUserData );
    }

    /**
     * @param string $sId
     * @param string $sPassword
     * @param string $sCountry
     * @return array
     */
    public function getUserData( $sId, $sPassword = '', $sCountry = "Germany" )
    {
        $aData = array(
            "oxusername" => "example01@oxid-esales.dev",
            "oxustid" => "",
            "oxmobfon" => "111-111111-$sId",
            "oxprivfon" => "11111111$sId",
            "oxbirthdate" => rand(1960, 2000).'-'.rand(10, 12).'-'.rand(10, 28),
        );

        if ( $sPassword ) {
            $aData['oxpassword'] = $sPassword;
        }

        $aAddressData = $this->getAddressData($sId, $sCountry);

        return array_merge($aData, $aAddressData);
    }

    /**
     * @param string $sId
     * @param string $sCountry
     * @return array
     */
    public function getAddressData( $sId, $sCountry = "Germany" )
    {
        $aData = array(
            "oxfname" => "user$sId name_šÄßüл",
            "oxlname" => "user$sId last name_šÄßüл",
            "oxcompany" => "user$sId company_šÄßüл",
            "oxstreet" => "user$sId street_šÄßüл",
            "oxstreetnr" => "$sId-$sId",
            "oxzip" => "1234$sId",
            "oxcity" => "user$sId city_šÄßüл",
            "oxaddinfo" => "user$sId additional info_šÄßüл",
            "oxfon" => "111-111-$sId",
            "oxfax" => "111-111-111-$sId",
            "oxcountryid" => $sCountry,
        );
        if ( $sCountry == 'Germany' ) {
            $aData["oxstateid"] = "BE";
        }

        return $aData;
    }

    /**
     * @param $aUserData
     * @param bool $blSubscribed
     */
    public function fillUserInfo( $aUserData, $blSubscribed = false )
    {
        list($sYear, $sMonth, $sDay) = explode('-',$aUserData['oxbirthdate']);
        unset( $aUserData['oxbirthdate'] );

        $this->select( "invadr[oxuser__oxbirthdate][month]", "value=".$sMonth );
        $this->type( "invadr[oxuser__oxbirthdate][year]", $sYear );
        $this->type( "invadr[oxuser__oxbirthdate][day]", $sDay );

        $this->type( "userLoginName", $aUserData['oxusername'] );
        unset( $aUserData['oxusername'] );

        if ( $aUserData['oxpassword'] ) {
            $this->type( "userPassword", $aUserData['oxpassword'] );
            $this->type( "userPasswordConfirm", $aUserData['oxpassword'] );
            unset( $aUserData['oxpassword'] );
        }

        $this->fillAddressInfo( $aUserData, true );

        if ( $blSubscribed ) {
            $this->uncheck( "//input[@name='blnewssubscribed' and @value='1']" );
        }
    }

    /**
     * @param $aUserData
     * @param bool $blBilling
     */
    public function fillAddressInfo( $aUserData, $blBilling = false )
    {
        $sPrefix = $blBilling? "invadr[oxuser__" : "deladr[oxaddress__";

        foreach ( $aUserData as $sKey => $sValue ) {
            $sInputLocator = "${sPrefix}${sKey}]";

            if ( $sKey == 'oxcountryid') {
                $this->select( $sInputLocator, "label=".$sValue );
            } else if ($sKey == 'oxstateid') {
                $this->waitForItemAppear($sInputLocator);
                $this->select( $sInputLocator, "value=".$sValue );
            } else {
                $this->type( $sInputLocator, $sValue );
            }
        }
    }

    /**
     * @param $aUserData
     * @return string
     */
    public function formOrderUserData( $aUserData )
    {
        $sUserData = "%EMAIL%: ".$aUserData['oxusername'].' ';
        $sUserData .= $this->formOrderAddressData( $aUserData, true ) . ' ';
        $sUserData .= "%CELLUAR_PHONE%: " . $aUserData['oxmobfon'].' ';
        $sUserData .= "%PERSONAL_PHONE%: " . $aUserData['oxprivfon'];

        return $sUserData;
    }

    /**
     * @param $aData
     * @return string
     */
    public function formOrderAddressData( $aData )
    {
        $sAddress =  $aData["oxcompany"].' '.$aData["oxaddinfo"].' ';
        $sAddress .= $aData["oxsal"]? $aData["oxsal"] : "Mr";
        $sAddress .= " ".$aData["oxfname"].' '.$aData["oxlname"].' ';
        $sAddress .= $aData["oxstreet"].' '.$aData["oxstreetnr"].' ';
        $sAddress .= (isset($aData["oxstateid"]) && $aData["oxstateid"] == 'BE') ? 'Berlin' : $aData["oxstateid"];
        $sAddress .= ' '.$aData["oxzip"].' ';
        $sAddress .= $aData["oxcity"].' '.$aData["oxcountryid"].' ';
        $sAddress .= "%PHONE%: " . $aData["oxfon"].' ';
        $sAddress .= "%FAX%: " . $aData["oxfax"];

        return $sAddress;
    }

    /**
     * @param array      $aUserData
     * @param array|bool $aAddressData
     */
    public  function assertUserExists( $aUserData, $aAddressData = false )
    {
        unset($aUserData['oxpassword']);
        unset($aUserData['oxcountryid']);

        $oValidator = $this->getObjectValidator();
        $this->assertTrue($oValidator->validate('oxuser', $aUserData), $oValidator->getErrorMessage());

        if ( $aAddressData ) {
            unset($aAddressData['oxcountryid']);

            $oValidator = $this->getObjectValidator();
            $this->assertTrue($oValidator->validate('oxaddress', $aAddressData), $oValidator->getErrorMessage());
        }
    }
}

