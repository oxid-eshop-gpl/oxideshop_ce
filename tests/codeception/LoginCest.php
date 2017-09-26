<?php

use Step\Acceptance\Currency;
use Step\Acceptance\Article;


class LoginCest 
{    
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }

    public function frontendCurrencies(AcceptanceTester $I)
    {
        $currency = new Currency($I);
        $currency->viewActiveCurrency('EUR');
        $currency->viewCurrencyList();
        $article = new Article($I, \Page\ProductList::getItem('newItems', 1));
        $article->viewPrice('50,00 € *');

        $currency->switchCurrency("GBP");
        $article->viewPrice('42.83 £ *');

        $currency->switchCurrency("CHF");
        $article->viewPrice('71,63 CHF *');

        $currency->switchCurrency("USD");
        $article->viewPrice('64.97 $ *');
        $I->see('64.97 $ *', "//div[@id='newItems']/div/div[1]");

        $currency->switchCurrency("EUR");
        $article->viewPrice('50,00 € *');

        $I->click("Test category 0 [EN] šÄßüл", '#footer');
        $I->waitForElement("//div[@class='btn-group currencies-menu']");
        $article = new Article($I, \Page\ProductList::getItem('productList', 1));
        $article->viewPrice('50,00 € *');

        // #1739 currency switch in vendors
        $I->click("Manufacturer [EN] šÄßüл");
        $I->waitForElement("//div[@class='btn-group currencies-menu']");
        $article = new Article($I, \Page\ProductList::getItem('productList', 1));
        $article->viewPrice('50,00 € *');

        $currency->switchCurrency("GBP");
        $I->see('Test product 0 [EN] šÄßüл', "//a[@id='productList_1']/span");
        $article->viewPrice('42.83 £ *');

        $currency->switchCurrency("EUR");
        $I->see('Test product 0 [EN] šÄßüл', "//a[@id='productList_1']/span");
        $article->viewPrice('50,00 € *');

    }

}