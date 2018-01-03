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

/**
 * Class UserCheckoutTest: uses flow theme
 *
 * @package OxidEsales\EshopCommunity\Tests\Acceptance\Frontend
 */
class UserCheckoutTest extends FrontendTestCase
{
    protected $retryTimes = 0;

    /**
     * Name of driver to use
     *
     * @var string
     */
    protected $_blDefaultMinkDriver = 'selenium';
    #protected $_blDefaultMinkDriver = 'selenium2';
    #protected $_blDefaultMinkDriver = 'goutte';

    /**
     * Name of theme to use.
     *
     * @var string
     */
    protected $themeName = 'flow';

    /**
     * Set up test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->activateTheme($this->themeName);
    }
    /**
     * Test user checkout
     *
     * @group flow
     */
    public function testUserCheckout()
    {
        $this->openShop();
        $this->loginInFrontend('example_test@oxid-esales.dev', 'useruser');
        $this->addToCart();
        $this->addToCart();
        $this->openBasketForLoggedInUser();
        $this->proceedWithCheckout();

        $this->logoutFrontend();
    }

    /**
     * Login customer by using login fly out form.
     *
     * @param string  $userName     User name (email).
     * @param string  $userPass     User password.
     * @param boolean $waitForLogin If needed to wait until user get logged in.
     */
    public function loginInFrontend($userName, $userPass, $waitForLogin = true)
    {
        $this->selectWindow(null);
        $loginText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('LOGIN');
        $this->click("//button[contains(text(),'{$loginText}')]");

        try {
            $this->waitForItemAppear("loginBox", 2);
        } catch (\Exception $e) {
            $this->click("//ul[@id='topMenu']/li[1]/a");
            $this->waitForItemAppear("loginBox", 2);
        }
        $this->type("//div[@id='loginBox']//input[@name='lgn_usr']", $userName);
        $this->type("//div[@id='loginBox']//input[@name='lgn_pwd']", $userPass);

        $this->clickAndWait("//div[@id='loginBox']//button[@type='submit']");
        if ($waitForLogin) {
            $accountText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('MY_ACCOUNT');
            $logoutText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('LOGOUT');
            $this->waitForElement("//button[contains(text(),'{$accountText}')]");
            $this->click("//button[contains(text(),'{$accountText}')]");
            $this->waitForElement("//a[@title='{$logoutText}']");
        }
    }

    /**
     * Log user out
     */
    public function logoutFrontend()
    {
        $this->selectWindow(null);

        $accountText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('MY_ACCOUNT');
        $logoutText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('LOGOUT');
        $this->waitForElement("//button[contains(text(),'{$accountText}')]");
        $this->click("//button[contains(text(),'{$accountText}')]");
        $this->click("//a[@title='{$logoutText}']");

        $this->assertElementNotPresent("//button[contains(text(),'{$accountText}')]");
    }

    /**
     * Add first item to cart you can get.
     * Then close minibasket popup by clicking 'continue shopping';
     */
    public function addToCart()
    {
        $this->openShop();
        $this->selectWindow(null);

        $toCartText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('TO_CART');
        $this->assertElementPresent("//button[@data-original-title='{$toCartText}']");
        $this->click("//button[@data-original-title='{$toCartText}']");

        $continueShoppingText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('DD_MINIBASKET_CONTINUE_SHOPPING');
        $this->waitForElement("//button[contains(text(),'{$continueShoppingText}')]");
        $this->click("//button[contains(text(),'{$continueShoppingText}')]");
    }

    /**
     * Open basket. User has to be logged in.
     */
    public function openBasketForLoggedInUser()
    {
        $this->click("//button[@class='btn dropdown-toggle']");

        $checkoutText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('CHECKOUT');
        $this->waitForElement("//a[contains(text(),'{$checkoutText}')]");
        $this->click("//a[contains(text(),'{$checkoutText}')]");
    }

    /**
     * Click through checkout. Use default settings.
     */
    public function proceedWithCheckout()
    {
        $this->waitForElement("//button[@name='userform']");
        $this->click("//button[@name='userform']");

        $orderNowText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('SUBMIT_ORDER');
        $this->click("id=checkAgbTop");
        $this->waitForElement("//button[contains(.,'{$orderNowText}')]");
        $this->click("//button[contains(.,'{$orderNowText}')]");

        $thankYouText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('THANK_YOU');;
        $this->assertTextPresent($thankYouText);
    }
}
