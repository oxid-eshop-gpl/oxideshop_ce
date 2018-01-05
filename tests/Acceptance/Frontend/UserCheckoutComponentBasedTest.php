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
 * Example for oxCompentn based test, use with oxcomponent_based_seleniums-OXDEV-690 branch of testing_library.
 *
 *
 * @package OxidEsales\EshopCommunity\Tests\Acceptance\Frontend
 */
class UserCheckoutComponentBasedTest extends FrontendTestCase
{
    protected $retryTimes = 0;

    protected $startTime = null;
    protected $currentTest = null;

    /**
     * Name of driver to use
     *
     * @var string
     */
    protected $_blDefaultMinkDriver = 'selenium';
    #protected $_blDefaultMinkDriver = 'selenium2';

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
        $this->startTime = microtime(true);
    }

    /**
     * Tear down fixture.
     */
    protected function tearDown()
    {
        $duration = microtime(true) - $this->startTime;
        writeToLog(__CLASS__ . ' ' . $this->currentTest . ' duration: ' . $duration);

        parent::tearDown();
    }

    public function testUserCheckout()
    {
        $this->doUserCheckout();
    }

    /**
     * Test user checkout.
     *
     * @group flow
     */
    public function doUserCheckout()
    {
        $this->currentTest = __FUNCTION__;

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
        //Ensure that the element needed for login box is really present
        $loginText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('LOGIN');
        $this->click("//button[contains(text(),'{$loginText}')]");

        $page = $this->getPage();
        $loginBox = new \OxidEsales\TestingLibrary\oxComponents\Domain\LoginBox($page);
        $loginBox->logIn($userName, $userPass);
    }

    /**
     * Log user out
     */
    public function logoutFrontend()
    {
        $accountText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('MY_ACCOUNT');
        $logoutText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('LOGOUT');
        $this->waitForSomething('find', ['xpath', "//button[contains(text(),'{$accountText}')]"]);
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

        $toCartText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('TO_CART');
        $this->waitForSomething('find', ['xpath', "//button[@data-original-title='{$toCartText}']"]);
        $this->click("//button[@data-original-title='{$toCartText}']");

        $continueShoppingText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('DD_MINIBASKET_CONTINUE_SHOPPING');
        $this->waitForSomething('find', ['xpath', "//button[contains(text(),'{$continueShoppingText}')]"]);
        $this->click("//button[contains(text(),'{$continueShoppingText}')]");
    }

    /**
     * Open basket. User has to be logged in.
     */
    public function openBasketForLoggedInUser()
    {
        $this->click("//div[@class='btn-group minibasket-menu']//button[@class='btn dropdown-toggle']");

        //$page = $this->getPage();
        //$miniBasket = new \OxidEsales\TestingLibrary\oxComponents\Domain\MiniBasket\MiniBasket($page);
        //$flyOutBox = $miniBasket->getFlyOutBox();
        //$flyOutBox->clickDisplayCartLink();

        $checkoutText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('CHECKOUT');
        $this->waitForSomething('find', ['xpath', "//a[contains(text(),'{$checkoutText}')]"]);
        $this->click("//a[contains(text(),'{$checkoutText}')]");
    }

    /**
     * Click through checkout. Use default settings.
     */
    public function proceedWithCheckout()
    {
        $this->waitForSomething('hasButton', ['userform']);
        $this->click("//button[@name='userform']");

        $orderNowText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('SUBMIT_ORDER');
        $this->click("id=checkAgbTop");
        $this->waitForSomething('find', ['xpath', "//button[contains(.,'{$orderNowText}')]"]);
        $this->click("//button[contains(.,'{$orderNowText}')]");

        $thankYouText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('THANK_YOU');;
        $this->assertTextPresent($thankYouText);
    }

    /**
     * Get page object from mink session.
     *
     * @return \Behat\Mink\Element\DocumentElement
     */
    protected function getPage()
    {
        $minkSession = $this->getMinkSession();
        $page = $minkSession->getPage();
        return $page;
    }

    /**
     * Waits for specified method with given arguments to return true.
     *
     * @param string $method       Method.
     * @param string $arguments    Arguments.
     * @param int    $timeToWait   How much time to wait for element.
     * @param bool   $ignoreResult Whether not to fail if element will not appear in given time.
     */
    protected function waitForSomething($method, $arguments, $timeToWait = 10, $ignoreResult = false)
    {
        $parameters = is_array($arguments) ? $arguments : array($arguments);
        $startTime = microtime(true);
        $timeNow = $startTime;
        $timeToWait = $timeToWait * $this->_iWaitTimeMultiplier;

        while ($timeToWait > ($timeNow - $startTime)) {
            if ($this->callOnPage($method, $parameters)) {
                return;
            }
            usleep(300000);
            $timeNow = microtime(true);
        }

        //we got here only if element was not found.
        if (!$ignoreResult) {
            $this->timeOutWaitingFor($parameters);
        }
    }

    /**
     * Trigger retrying test with waiting timeout
     *
     * @param $data
     */
    protected function timeOutWaitingFor($data)
    {
        $message = "Timeout waiting for '" . implode(' | ', $data) . "'.";
        $this->retryTest($message);
    }

    /**
     * @param string $method    Method to call.
     * @param array  $arguments Arguments.
     * @return bool
     */
    protected function callOnPage($method, $arguments)
    {
        $page = $this->getPage();
        return $page->$method(...$arguments);
    }
}
