<?php declare(strict_types=1);

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Acceptance\Frontend;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Tests\Acceptance\FrontendTestCase;

/**
 * Class StartPageFrontendTest
 *
 * @package OxidEsales\EshopCommunity\Tests\Acceptance\Frontend
 */
class StartPageFrontendTest extends FrontendTestCase
{
    public function testAddToBasket()
    {
        $this->openShop();

        $this->assertBasketIsEmpty();

        $this->addToBasketViaGet();

        $this->assertBasketIsEmpty();
    }

    private function addToBasketViaGet()
    {
        $testConfig = $this->getTestConfig();
        $url = trim($testConfig->getShopUrl(), '/') . '/index.php?';

        $data = [
            'actcontrol' => 'start',
            'lang'       => '1',
            'cl'         => 'start',
            'fnc'        => 'tobasket',
            'aid'        => 'dc5ffdf380e15674b56dd562a7cb6aec',
            'anid'       => 'dc5ffdf380e15674b56dd562a7cb6aec',
            'am'         => 1
        ];
        $query = http_build_query($data);

        $this->open($url . $query);
    }

    private function assertBasketIsEmpty()
    {
        $languageId = 1;
        $testConfig = $this->getTestConfig();

        $basketUrl = trim($testConfig->getShopUrl(), '/') . '/index.php?cl=basket&lang=' . $languageId;
        $this->open($basketUrl);
        $locator = 'css=.status.corners.error';
        $emptyShoppingCartMessage = Registry::getLang()->translateString('BASKET_EMPTY', $languageId, false);

        $this->assertElementText($emptyShoppingCartMessage, $locator);
    }

    /**
     * TODO Investigate why the stoken is not present, when running the tests, but it is present when running the shop normally.
     *
     * @return mixed
     */
    private function getCsrfToken()
    {
        $locator = 'css=form[name="tobasketnewItems_1"] > input[name="stoken"]';
        return $this->getElement($locator)->getValue();
    }
}
