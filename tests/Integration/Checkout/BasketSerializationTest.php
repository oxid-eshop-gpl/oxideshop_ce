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
 * @copyright (C) OXID eSales AG 2003-2015
 * @version   OXID eShop CE
 */
namespace OxidEsales\EshopCommunity\Tests\Integration\Checkout;

use OxidEsales\EshopCommunity\Core\ShopIdCalculator;

/**
 * Class BasketSerializationTest
 * @package OxidEsales\EshopCommunity\Tests\Integration\Checkout
 */
class BasketSerializationTest extends \OxidTestCase
{
    /**
     * Make a copy of Stewart+Brown Shirt Kisser Fish parent and variant L violet for testing
     */
    const SOURCE_ARTICLE_ID = '6b6d966c899dd9977e88f842f67eb751';
    const SOURCE_ARTICLE_PARENT_ID = '6b6099c305f591cb39d4314e9a823fc1';

    /**
     * Generated test article, test user and order ids.
     * @var string
     */
    private $testArticleId = null;
    private $testArticleParentId = null;
    private $testOrderId = null;
    private $testUserId = null;

    /**
     * Fixture setUp.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->insertArticle();
        $this->insertUser();
        $_POST = [];
    }

    /*
    * Fixture tearDown.
    */
    protected function tearDown()
    {
        $_POST = [];

        $this->cleanUpTable('oxarticles');
        $this->cleanUpTable('oxorder');
        $this->cleanUpTable('oxorderarticles');
        $this->cleanUpTable('oxuser');
        $this->cleanUpTable('oxuserpayments');
        $this->cleanUpTable('oxuserbaskets');
        $this->cleanUpTable('oxuserbasketitems');
        $this->cleanUpTable('oxobject2delivery');

        parent::tearDown();
    }

    /**
     * Mode is no basket reservation.
     */
    public function testPutArticlesToBasketNoReservation()
    {
        $stock = 60;
        $buyAmount = 20;
        $this->getConfig()->setConfigParam('iNewBasketItemMessage', 1);

        $this->setStock($stock);
        $basket = $this->fillBasket($buyAmount);
        $this->assertNewItemMarker($buyAmount);
        $this->checkContents($basket, $buyAmount);

        $serializedBasketData = $basket->serialize();
        $data = unserialize($serializedBasketData);
        $toBeUnserialized = \OxidEsales\Eshop\Application\Model\Basket::getSerializedObject($data['unc_class'], $data['objectvars']);
        $testBasket = unserialize($toBeUnserialized);
        $this->checkContents($testBasket, $buyAmount);
    }

    /**
     * Make a copy of article and variant for testing.
     */
    private function insertArticle()
    {
        $this->testArticleId = substr_replace(\OxidEsales\Eshop\Core\Registry::getUtilsObject()->generateUId(), '_', 0, 1 );
        $this->testArticleParentId = substr_replace(\OxidEsales\Eshop\Core\Registry::getUtilsObject()->generateUId(), '_', 0, 1);

        //copy from original article parent and variant
        $articleParent = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);
        $articleParent->disableLazyLoading();
        $articleParent->load(self::SOURCE_ARTICLE_PARENT_ID);
        $articleParent->setId($this->testArticleParentId);
        $articleParent->oxarticles__oxartnum = new \OxidEsales\Eshop\Core\Field('666-T', \OxidEsales\Eshop\Core\Field::T_RAW);
        $articleParent->save();

        $article = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);
        $article->disableLazyLoading();
        $article->load(self::SOURCE_ARTICLE_ID);
        $article->setId($this->testArticleId);
        $article->oxarticles__oxparentid = new \OxidEsales\Eshop\Core\Field($this->testArticleParentId, \OxidEsales\Eshop\Core\Field::T_RAW);
        $article->oxarticles__oxprice = new \OxidEsales\Eshop\Core\Field('10.0', \OxidEsales\Eshop\Core\Field::T_RAW);
        $article->oxarticles__oxartnum = new \OxidEsales\Eshop\Core\Field('666-T-V', \OxidEsales\Eshop\Core\Field::T_RAW);
        $article->oxarticles__oxactive = new \OxidEsales\Eshop\Core\Field('1', \OxidEsales\Eshop\Core\Field::T_RAW);
        $article->save();
    }

    /**
     * Create order object with test oxidid (leading underscore).
     *
     * @return object \OxidEsales\Eshop\Application\Model\Order
     */
    private function createOrder()
    {
        $order = $this->getMock(\OxidEsales\Eshop\Application\Model\Order::class, array('validateDeliveryAddress', '_sendOrderByEmail'));
        // sending order by email is always successful for tests
        $order->expects($this->any())->method('_sendOrderByEmail')->will($this->returnValue(1));
        //mocked to circumvent delivery address change md5 check from requestParameter
        $order->expects($this->any())->method('validateDeliveryAddress')->will($this->returnValue(0));

        $this->testOrderId = substr_replace(\OxidEsales\Eshop\Core\Registry::getUtilsObject()->generateUId(), '_', 0, 1);
        $order->setId($this->testOrderId);

        return $order;
    }

    /**
     * Get current stock of article variant.
     */
    private function getStock()
    {
        $article = oxNew('\OxidEsales\Eshop\Application\Model\Article');
        $article->load($this->testArticleId);
        return $article->oxarticles__oxstock->value;
    }

    /**
     * Set current stock of article variant.
     */
    private function setStock($stock)
    {
        $article = oxNew('\OxidEsales\Eshop\Application\Model\Article');
        $article->load($this->testArticleId);
        $article->oxarticles__oxstock = new \OxidEsales\Eshop\Core\Field($stock, \OxidEsales\Eshop\Core\Field::T_RAW);
        $article->save();

        $this->assertEquals($stock, $this->getStock());
    }

    /**
     * Set current stock of article variant.
     */
    private function setStockFlag($stockFlag)
    {
        $article = oxNew('\OxidEsales\Eshop\Application\Model\Article');
        $article->load($this->testArticleId);
        $article->oxarticles__oxstockflag = new \OxidEsales\Eshop\Core\Field($stockFlag, \OxidEsales\Eshop\Core\Field::T_RAW);
        $article->save();
    }

    /**
     * Check if 'new item marker' has been set in basket.
     *
     * @param integer $buyAmount Expected amount of products put to basket
     */
    private function assertNewItemMarker($buyAmount)
    {
        //newItem is an stdClass
        $newItem = \OxidEsales\Eshop\Core\Registry::getSession()->getVariable('_newitem');
        $this->assertEquals($this->testArticleId, $newItem->sId);
        $this->assertEquals($buyAmount, $newItem->dAmount);
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Basket $basket
     */
    private function checkContents(\OxidEsales\Eshop\Application\Model\Basket $basket, $expectedAmount)
    {
        //only one different article but buyAmount items in basket
        $this->assertEquals(1, $basket->getProductsCount());
        $this->assertEquals($expectedAmount, $basket->getItemsCount());

        $basketArticles = $basket->getBasketArticles();
        $keys = array_keys($basketArticles);
        $this->assertTrue(is_array($basketArticles));
        $this->assertEquals(1, count($basketArticles));
        $this->assertTrue(is_a($basketArticles[$keys[0]], '\OxidEsales\EshopCommunity\Application\Model\Article'));
        $this->assertEquals($this->testArticleId, $basketArticles[$keys[0]]->getId());

        $basketContents = $basket->getContents();
        $keys = array_keys($basketContents);
        $this->assertTrue(is_array($basketContents));
        $this->assertEquals(1, count($basketArticles));
        $this->assertTrue(is_a($basketContents[$keys[0]], '\OxidEsales\EshopCommunity\Application\Model\BasketItem'));

        $basketItem = $basketContents[$keys[0]];
        $this->assertEquals($this->testArticleId, $basketItem->getProductId());
        $this->assertEquals($expectedAmount, $basketItem->getAmount());
    }

    /**
     * insert test user
     */
    private function insertUser()
    {
        $this->testUserId = substr_replace(\OxidEsales\Eshop\Core\Registry::getUtilsObject()->generateUId(), '_', 0, 1);

        $user = oxNew(\OxidEsales\Eshop\Application\Model\User::class);
        $user->setId($this->testUserId);

        $user->oxuser__oxactive = new \OxidEsales\Eshop\Core\Field('1', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxrights = new \OxidEsales\Eshop\Core\Field('user', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxshopid = new \OxidEsales\Eshop\Core\Field(ShopIdCalculator::BASE_SHOP_ID, \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxusername = new \OxidEsales\Eshop\Core\Field('testuser@oxideshop.dev', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxpassword = new \OxidEsales\Eshop\Core\Field('c630e7f6dd47f9ad60ece4492468149bfed3da3429940181464baae99941d0ffa5562' .
            'aaecd01eab71c4d886e5467c5fc4dd24a45819e125501f030f61b624d7d',
            \OxidEsales\Eshop\Core\Field::T_RAW); //password is asdfasdf
        $user->oxuser__oxpasssalt = new \OxidEsales\Eshop\Core\Field('3ddda7c412dbd57325210968cd31ba86', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxcustnr = new \OxidEsales\Eshop\Core\Field('666', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxfname = new \OxidEsales\Eshop\Core\Field('Bla', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxlname = new \OxidEsales\Eshop\Core\Field('Foo', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxstreet = new \OxidEsales\Eshop\Core\Field('blafoostreet', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxstreetnr = new \OxidEsales\Eshop\Core\Field('123', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxcity = new \OxidEsales\Eshop\Core\Field('Hamburg', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxcountryid = new \OxidEsales\Eshop\Core\Field('a7c40f631fc920687.20179984', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxzip = new \OxidEsales\Eshop\Core\Field('22769', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxsal = new \OxidEsales\Eshop\Core\Field('MR', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxactive = new \OxidEsales\Eshop\Core\Field('1', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxboni = new \OxidEsales\Eshop\Core\Field('1000', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxcreate = new \OxidEsales\Eshop\Core\Field('2015-05-20 22:10:51', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxregister = new \OxidEsales\Eshop\Core\Field('2015-05-20 22:10:51', \OxidEsales\Eshop\Core\Field::T_RAW);
        $user->oxuser__oxboni = new \OxidEsales\Eshop\Core\Field('1000', \OxidEsales\Eshop\Core\Field::T_RAW);

        $user->save();

        $newId = substr_replace(\OxidEsales\Eshop\Core\Registry::getUtilsObject()->generateUId(), '_', 0, 1);
        $database = \OxidEsales\Eshop\Core\DatabaseProvider::getDb();
        $query = 'insert into `oxobject2delivery` (oxid, oxdeliveryid, oxobjectid, oxtype) ' .
            " values ('$newId', 'oxidstandard', '" . $this->testUserId . "', 'oxdelsetu')";
        $database->execute($query);
    }

    /**
     * Put given amount of testarticle into the basket.
     *
     * @param integer $buyAmount
     *
     * @return \OxidEsales\Eshop\Application\Model\Order
     */
    private function fillBasket($buyAmount)
    {
        $availableAmount = $this->getStock();
        $basket = \OxidEsales\Eshop\Core\Registry::getSession()->getBasket();
        $this->assertEquals(0, $this->getAmountInBasket());

        $this->setSessionParam('basketReservationToken', null);
        $this->assertNull(\OxidEsales\Eshop\Core\Registry::getSession()->getVariable('_newitem'));

        //try to be as close to usual checkout as possible
        $basketComponent = oxNew(\OxidEsales\Eshop\Application\Component\BasketComponent::class);
        $redirectUrl = $basketComponent->tobasket($this->testArticleId, $buyAmount);
        $this->assertEquals('start?', $redirectUrl);

        $basket = $this->getSession()->getBasket();
        $basket->calculateBasket(true); //calls \OxidEsales\Eshop\Application\Model\Basket::afterUpdate

        return $basket;
    }

    /**
     * Remove all items from basket.
     */
    private function removeFromBasket()
    {
        $basket = \OxidEsales\Eshop\Core\Registry::getSession()->getBasket();
        $countBefore = $this->getAmountInBasket();

        $_POST = [
            'stoken' => \OxidEsales\Eshop\Core\Registry::getSession()->getSessionChallengeToken(),
            'updateBtn' => '',
            'aproducts' => [$basket->getItemKey($this->testArticleId) => [
                'remove' => '1',
                'aid ' => $this->testArticleId,
                'basketitemid' => $basket->getItemKey($this->testArticleId),
                'override' => 1,
                'am' => $countBefore]
            ]
        ];

        //try to be as close to the checkout as possible
        $basketComponent = oxNew(\OxidEsales\Eshop\Application\Component\BasketComponent::class);
        $basketComponent->changeBasket($this->testArticleId);

        $countAfter = $this->getAmountInBasket();
        $this->assertEquals(0, $countAfter);
    }

    /**
     * Add one test article to basket.
     *
     * @param integer $expected Optional expected amount.
     */
    private function addOneItemToBasket($expected = null)
    {
        $countBefore = $this->getAmountInBasket();
        $expected = is_null($expected) ? $countBefore + 1 : $expected;

        $_POST = [
            'stoken' => \OxidEsales\Eshop\Core\Registry::getSession()->getSessionChallengeToken(),
            'actcontrol' => 'start',
            'lang' => 0,
            'pgNr' => 0,
            'cl' => 'start',
            'fnc' => 'tobasket',
            'aid' => $this->testArticleId,
            'anid' => $this->testArticleId,
            'am' => 1
        ];

        //try to be as close to the checkout as possible
        $basketComponent = oxNew(\OxidEsales\Eshop\Application\Component\BasketComponent::class);
        $basketComponent->toBasket($this->testArticleId, 1);

        $this->assertEquals($expected, $this->getAmountInBasket());
    }

    /**
     * NOTE: Do not use Basket::getBasketSummary() as this method adds up on every call.
     *
     * Test helper to get amount of test artile in basket.
     *
     * @return integer
     */
    private function getAmountInBasket()
    {
        $return = 0;
        $basket = \OxidEsales\Eshop\Core\Registry::getSession()->getBasket();
        $basketContents = $basket->getContents();
        $basketItemId = $basket->getItemKey($this->testArticleId);

        if (is_a($basketContents[$basketItemId],\OxidEsales\Eshop\Application\Model\BasketItem::class)) {
            $return = $basketContents[$basketItemId]->getAmount();
        }
        return $return;
    }

}
