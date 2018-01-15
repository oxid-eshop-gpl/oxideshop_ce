<?php

namespace OxidEsales\EshopCommunity\Tests\Acceptance\Codeception\Frontend\WebDriver;

use OxidEsales\TestingLibrary\CodeceptionTestCase;
use WebDriverAcceptanceTester as AcceptanceTester;

/**
 * Class UserCheckoutNoTestingLibraryCest: written for selenium/firefox.
 * Does not use testing_library features. Database setup is handled by codeception framework.
 */
class UserCheckoutNoTestingLibraryCest
{
    protected $startTime = null;
    protected $currentTest = null;

    /**
     * Set to false if you want to directly compare with related PhpBrowser test.
     * AGB checkbox requires javascript which is not supported by PhpBrowser.
     *
     * @var bool
     */
    protected $testWithAGBCheckbox = false;

    /**
     * Maximum waiting time for elements.
     *
     * @var int
     */
    protected $maxWaitForSeconds = 3;

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
        //Disable the confirm agb checkbox if test is configured to do so.
        if (!$this->testWithAGBCheckbox) {
            $configKey = \OxidEsales\Eshop\Core\Config::DEFAULT_CONFIG_KEY;
            $I->updateInDatabase('oxconfig', ['oxvarvalue' => "ENCODE(true, '{$configKey}')"], ['oxvarname'  => 'blConfirmAGB']);
        }

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
    }

    /**
     * The test.
     *
     * @param AcceptanceTester $I
     */
    public function UserCheckoutTest1(AcceptanceTester $I)
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
        $I->maximizeWindow();
        $I->see('OXID Online Shop');

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

        $loginText = $this->getEnglishTranslation('LOGIN');
        $I->click("//button[contains(text(),'{$loginText}')]");
        $I->waitForElementVisible("//div[@id='loginBox']", $this->maxWaitForSeconds);

        //Short way to submit a form
        $I->submitForm("//div[@id='loginBox']", ['lgn_usr' => $userName, 'lgn_pwd' => $userPass]);

        if ($waitForLogin) {
            $accountText = $this->getEnglishTranslation('MY_ACCOUNT');
            $logoutText = $this->getEnglishTranslation('LOGOUT');
            $I->waitForElementVisible("//button[contains(text(),'{$accountText}')]", $this->maxWaitForSeconds);
            $I->click("//button[contains(text(),'{$accountText}')]");
            $I->see($logoutText);
            $I->click("//button[contains(text(),'{$accountText}')]");
            $I->dontSee($logoutText);
        }
    }

    /**
     * Log user out
     */
    protected function logoutFrontend()
    {
        $I = $this->acceptanceTester;

        $accountText = $this->getEnglishTranslation('MY_ACCOUNT');
        $logoutText = $this->getEnglishTranslation('LOGOUT');
        $I->seeElement("//button[contains(text(),'{$accountText}')]");
        $I->click("//button[contains(text(),'{$accountText}')]");

        $I->waitForElementVisible("//a[@title='{$logoutText}']", $this->maxWaitForSeconds);
        $I->click("//a[@title='{$logoutText}']");
        $I->waitForElementNotVisible("//button[contains(text(),'{$accountText}')]", $this->maxWaitForSeconds);
    }

    /**
     * Add first item to cart you can get.
     * Then close minibasket popup by clicking 'continue shopping';
     */
    protected function addToCart()
    {
        $I = $this->acceptanceTester;

        $toCartText = $this->getEnglishTranslation('TO_CART');
        $I->seeElement("//button[@data-original-title='{$toCartText}']");
        $I->click("//button[@data-original-title='{$toCartText}']");

        //BasketPopup disabled for EE
        $facts = new \OxidEsales\Facts\Facts;
        if (!$facts->isEnterprise()) {
            $continueShoppingText = $this->getEnglishTranslation('DD_MINIBASKET_CONTINUE_SHOPPING');
            $I->waitForElementVisible("//button[contains(text(),'{$continueShoppingText}')]", $this->maxWaitForSeconds);
            $I->click("//button[contains(text(),'{$continueShoppingText}')]");
            $I->waitForElementNotVisible("//button[contains(text(),'{$continueShoppingText}')]", $this->maxWaitForSeconds);
        }
    }

    /**
     * Open basket. User has to be logged in.
     */
    protected function openBasketForLoggedInUser()
    {
        $I = $this->acceptanceTester;
        $I->click("//div[@class='btn-group minibasket-menu']//button[@class='btn dropdown-toggle']");

        $checkoutText = $this->getEnglishTranslation('CHECKOUT');
        $I->waitForElementVisible("//a[contains(text(),'{$checkoutText}')]", $this->maxWaitForSeconds);
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

        $orderNowText = $this->getEnglishTranslation('SUBMIT_ORDER');
        $I->waitForElement("//button[contains(.,'{$orderNowText}')]", $this->maxWaitForSeconds);

        if ($this->testWithAGBCheckbox) {
            $I->checkOption("//input[@id='checkAgbTop']");
            $I->seeCheckboxIsChecked("//input[@id='checkAgbTop']");
        }

        $I->submitForm("//form[@id='orderConfirmAgbTop']", []);

        $thankYouText = $this->getEnglishTranslation('THANK_YOU');;
        $I->see($thankYouText);
    }

    /**
     * Get english translation for language constant.
     *
     * @param string $languageConstant
     *
     * @return string
     */
    protected function getEnglishTranslation($languageConstant)
    {
        return \OxidEsales\Eshop\Core\Registry::getLang()->translateString($languageConstant, 1);
    }
}
