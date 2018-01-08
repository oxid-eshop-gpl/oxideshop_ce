<?php
namespace Step\Acceptance;

use Page\CurrencyMenu;

class Currency
{
    protected $user;

    public function __construct(\AcceptanceTester $I)
    {
        $this->user = $I;
    }

    public function switchCurrency($currency)
    {
        $this->user->click(CurrencyMenu::$currencyMenuButton);
        $this->user->waitForElement(CurrencyMenu::$openedCurrencyMenuButton);
        $this->user->click($currency);
        $this->user->waitForElement(CurrencyMenu::$currencyMenuButton);
        $this->user->see($currency, CurrencyMenu::$currencyMenuTitle);
    }

    public function viewCurrencyList()
    {
        $this->user->click(CurrencyMenu::$currencyMenuButton);
        $this->user->waitForElement(CurrencyMenu::$openedCurrencyMenuButton);
        $this->user->see('EUR', CurrencyMenu::getItem(1));
        $this->user->see('GBP', CurrencyMenu::getItem(2));
        $this->user->see('CHF', CurrencyMenu::getItem(3));
        $this->user->see('USD', CurrencyMenu::getItem(4));
        $this->user->click(CurrencyMenu::$openedCurrencyMenuButton);
    }

    public function viewActiveCurrency($currency)
    {
        $this->user->click(CurrencyMenu::$currencyMenuButton);
        $this->user->waitForElement(CurrencyMenu::$openedCurrencyMenuButton);
        $this->user->see($currency, CurrencyMenu::getActiveItem());
        $this->user->click($currency);
    }

}