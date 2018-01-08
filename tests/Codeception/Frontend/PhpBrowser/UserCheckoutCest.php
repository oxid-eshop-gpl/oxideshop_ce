<?php

namespace OxidEsales\EshopCommunity\Tests\Acceptance\Codeception\Frontend\PhpBrowser;

use OxidEsales\TestingLibrary\CodeceptionTestCase;
use PhpBrowserAcceptanceTester as AcceptanceTester;

/**
 * Class UserCheckoutCest: written for php browser
 */
class UserCheckoutCest
{
    protected $startTime = null;
    protected $currentTest = null;

    /**
     * Name of theme to use.
     *
     * @var string
     */
    protected $themeName = 'flow';

    /**
     * @var AcceptanceTester
     */
    protected $acceptanceTester = null;

    /**
     * Reuses copy pasted OXID standard Acceptance Test setup.
     *
     * @param AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I)
    {
        $path = __DIR__ . '/../';

        $case = new CodeceptionTestCase;
        $case->setUp($path);
        $case->activateTheme($this->themeName);

        //PhpBrowser cannot handle the Agb checkbox as it sits outside a form and requires javascript.
        $case->callShopSC('oxConfig', null, null,
            ['blConfirmAGB' => ['type' => 'bool', 'value' => false]]);

        $this->acceptanceTester = $I;
        $this->startTime = microtime(true);
    }

    /**
     * ATM reuses copy pasted  AcceptanceTest case tear down.
     *
     * @param AcceptanceTester $I
     */
    public function _after(AcceptanceTester $I)
    {
        $duration = microtime(true) - $this->startTime;
        writeToLog(__CLASS__ . ' ' . $this->currentTest . ' duration: ' . $duration);

        $case = new CodeceptionTestCase;
        $case->tearDown();
    }

    public function UserCheckoutTest1(AcceptanceTester $I)
    {
        $this->doUserCheckout($I);
    }

    public function UserCheckoutTest2(AcceptanceTester $I)
    {
        $this->doUserCheckout($I);
    }

    /**
     * Run through checkout.
     *
     * @param AcceptanceTester $I
     */
    protected function doUserCheckout(AcceptanceTester $I)
    {
        $I->amOnPage('/');

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
    protected function loginInFrontend($userName, $userPass, $waitForLogin = true)
    {
        $I = $this->acceptanceTester;

        $loginText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('LOGIN');
        $I->click("//button[contains(text(),'{$loginText}')]");
        $I->seeElement("//div[@id='loginBox']");

        //Short way to submit a form
        $I->submitForm("//div[@id='loginBox']//button[@type='submit']", ['lgn_usr' => $userName, 'lgn_pwd' => $userPass]);

        //Same as $I->submitForm only with more lines of code.
        //$I->fillField("//div[@id='loginBox']//input[@name='lgn_usr']", $userName);
        //$I->fillField("//div[@id='loginBox']//input[@name='lgn_pwd']", $userPass);
        //$I->click("//div[@id='loginBox']//button[@type='submit']");

        if ($waitForLogin) {
            $accountText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('MY_ACCOUNT');
            $logoutText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('LOGOUT');
            $I->seeElement("//button[contains(text(),'{$accountText}')]");
            $I->click("//button[contains(text(),'{$accountText}')]");
            $I->see($logoutText);
        }
    }

    /**
     * Log user out
     */
    protected function logoutFrontend()
    {
        $I = $this->acceptanceTester;

        $accountText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('MY_ACCOUNT');
        $logoutText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('LOGOUT');
        $I->seeElement("//button[contains(text(),'{$accountText}')]");
        $I->click("//button[contains(text(),'{$accountText}')]");

        $I->seeElement("//a[@title='{$logoutText}']");
        $I->click("//a[@title='{$logoutText}']");
        $I->dontSeeElement("//button[contains(text(),'{$accountText}')]");
    }

    /**
     * Add first item to cart you can get.
     * Then close minibasket popup by clicking 'continue shopping';
     */
    protected function addToCart()
    {
        $I = $this->acceptanceTester;

        $toCartText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('TO_CART');
        $I->seeElement("//button[@title='{$toCartText}']");
        $I->click("//button[@title='{$toCartText}']");

        $continueShoppingText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('DD_MINIBASKET_CONTINUE_SHOPPING');
        $I->seeElement("//button[contains(text(),'{$continueShoppingText}')]");
        $I->click("//button[contains(text(),'{$continueShoppingText}')]");
    }

    /**
     * Open basket. User has to be logged in.
     */
    protected function openBasketForLoggedInUser()
    {
        $I = $this->acceptanceTester;
        $I->click("//div[@class='btn-group minibasket-menu']//button[@class='btn dropdown-toggle']");

        $checkoutText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('CHECKOUT');
        $I->seeElement("//a[contains(text(),'{$checkoutText}')]");
        $I->click("//a[contains(text(),'{$checkoutText}')]");
    }

    /**
     * Click through checkout. Use default settings.
     */
    protected function proceedWithCheckout()
    {
        $I = $this->acceptanceTester;

        $I->seeElement("//button[@name='userform']");
        $I->click("//button[@name='userform']");

        $orderNowText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('SUBMIT_ORDER');
        $I->dontSeeElement("//input[@id='checkAgbTop']");

        $I->seeElement("//button[contains(.,'{$orderNowText}')]");
        $I->click("//button[contains(.,'{$orderNowText}')]");

        $thankYouText = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('THANK_YOU');;
        $I->see($thankYouText);
    }
}
