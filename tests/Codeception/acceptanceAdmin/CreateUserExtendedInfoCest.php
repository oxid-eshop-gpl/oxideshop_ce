<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Codeception\CodeceptionAdmin;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Tests\Codeception\AcceptanceAdminTester;
use OxidEsales\Facts\Facts;

/**
 * Class CreateUserExtendedInfoCest
 */
class CreateUserExtendedInfoCest
{
    public function testCreateUserExtendedInfo(AcceptanceAdminTester $I): void
    {
        $this->addNewUserInDatabase($I);

        $adminPanel = $I->loginAdmin();
        $adminUsersPage = $adminPanel->openUsers();

        $adminUsersPage->find("where[oxuser][oxusername]", "example00@oxid-esales.dev");
        $adminUsersPage->openExtendedTab();

        $I->assertEquals(
            "Mr Name1 Surname1 company1 street1 11 BE 30001 City11 additional info1 Belgium 1112223331",
            $I->clearString($I->grabTextFrom("#test_userAddress"))
        );

        $I->dontSeeCheckboxIsChecked("/descendant::input[@name='editnews'][2]");
        $I->dontSeeCheckboxIsChecked("/descendant::input[@name='emailfailed'][2]");
        $I->assertEquals("1000", $I->grabValueFrom('editval[oxuser__oxboni]'));

        $I->fillField('editval[oxuser__oxprivfon]', '555444555');
        $I->fillField('editval[oxuser__oxmobfon]', '666555666');
        $I->checkOption("/descendant::input[@name='editnews'][2]");
        $I->checkOption("/descendant::input[@name='emailfailed'][2]");
        $I->fillField("editval[oxuser__oxboni]", "1500");
        $I->fillField("editval[oxuser__oxurl]", "http://www.url.com");
        $I->click("save");
        $I->selectEditFrame();

        $I->assertEquals("555444555", $I->grabValueFrom("editval[oxuser__oxprivfon]"));
        $I->assertEquals("666555666", $I->grabValueFrom("editval[oxuser__oxmobfon]"));
        $I->seeCheckboxIsChecked("/descendant::input[@name='editnews'][2]");
        $I->seeCheckboxIsChecked("/descendant::input[@name='emailfailed'][2]");
        $I->assertEquals("1500", $I->grabValueFrom("editval[oxuser__oxboni]"));
        $I->assertEquals("http://www.url.com", $I->grabValueFrom("editval[oxuser__oxurl]"));

        $I->uncheckOption("/descendant::input[@name='editnews'][2]");
        $I->uncheckOption("/descendant::input[@name='emailfailed'][2]");
        $I->fillField("editval[oxuser__oxboni]", "1000");
        $I->fillField("editval[oxuser__oxprivfon]", "5554445551");
        $I->fillField("editval[oxuser__oxmobfon]", "6665556661");
        $I->fillField("editval[oxuser__oxurl]", "http://www.url1.com");
        $I->click("save");
        $I->selectEditFrame();

        $I->assertEquals("5554445551", $I->grabValueFrom("editval[oxuser__oxprivfon]"));
        $I->assertEquals("6665556661", $I->grabValueFrom("editval[oxuser__oxmobfon]"));
        $I->dontSeeCheckboxIsChecked("/descendant::input[@name='editnews'][2]");
        $I->dontSeeCheckboxIsChecked("/descendant::input[@name='emailfailed'][2]");
        $I->assertEquals("1000", $I->grabValueFrom("editval[oxuser__oxboni]"));
        $I->assertEquals("http://www.url1.com", $I->grabValueFrom("editval[oxuser__oxurl]"));
    }

    /** @param AcceptanceAdminTester $I */
    private function addNewUserInDatabase(AcceptanceAdminTester $I): void
    {
        $facts = new Facts();

        if ($facts->getEdition() !== 'EE') {
            $I->haveInDatabase(
                'oxuser',
                [
                    'OXID' => 'kdiruuc',
                    'OXACTIVE' => 0,
                    'OXRIGHTS' => 'malladmin',
                    'OXSHOPID' => 1,
                    'OXUSERNAME' => 'example00@oxid-esales.dev',
                    'OXPASSWORD' => '89bb88b81f9b3669fc4c44e082dd9927',
                    'OXPASSSALT' => '3032396331663033316535343361356231363666653666316533376235353830',
                    'OXCUSTNR' => 121,
                    'OXUSTID' => '111222',
                    'OXCOMPANY' => 'company1',
                    'OXFNAME' => 'Name1',
                    'OXLNAME' => 'Surname1',
                    'OXSTREET' => 'street1',
                    'OXSTREETNR' => '11',
                    'OXADDINFO' => 'additional info1',
                    'OXCITY' => 'City11',
                    'OXCOUNTRYID' => 'a7c40f632e04633c9.47194042',
                    'OXSTATEID' => 'BE',
                    'OXZIP' => '30001',
                    'OXFON' => '1112223331',
                    'OXFAX' => '2223334441',
                    'OXSAL' => 'MR',
                    'OXBONI' => 1000,
                    'OXCREATE' => '2010-02-05 10:22:37',
                    'OXREGISTER' => '2010-02-05 10:22:48',
                    'OXPRIVFON' => '',
                    'OXMOBFON' => '',
                    'OXBIRTHDATE' => '1979-01-03',
                    'OXURL' => '',
                    'OXUPDATEKEY' => '',
                    'OXUPDATEEXP' => 0,
                ]
            );
        } else {
            $shopId = Registry::getConfig()->isSubShop() ? 2 : 1;

            $I->haveInDatabase(
                'oxuser',
                [
                    'OXID' => 'ddesdr',
                    'OXACTIVE' => 0,
                    'OXRIGHTS' => 'malladmin',
                    'OXSHOPID' => $shopId,
                    'OXUSERNAME' => 'example00@oxid-esales.dev',
                    'OXPASSWORD' => '1397d0b4392f452a5bd058891c9b255e',
                    'OXPASSSALT' => '6634653730386562303132363065393735333334386530353233323337346435',
                    'OXCUSTNR' => 121,
                    'OXUSTID' => '111222',
                    'OXUSTIDSTATUS' => 0,
                    'OXCOMPANY' => 'company1',
                    'OXFNAME' => 'Name1',
                    'OXLNAME' => 'Surname1',
                    'OXSTREET' => 'street1',
                    'OXSTREETNR' => '11',
                    'OXADDINFO' => 'additional info1',
                    'OXCITY' => 'City11',
                    'OXCOUNTRYID' => 'a7c40f632e04633c9.47194042',
                    'OXSTATEID' => 'BE',
                    'OXZIP' => '30001',
                    'OXFON' => '1112223331',
                    'OXFAX' => '2223334441',
                    'OXSAL' => 'MR',
                    'OXBONI' => 1000,
                    'OXCREATE' => '2010-02-05 09:23:13',
                    'OXREGISTER' => '2010-02-05 09:23:19',
                    'OXPRIVFON' => '',
                    'OXMOBFON' => '',
                    'OXBIRTHDATE' => '1979-01-03',
                    'OXURL' => '',
                    'OXLDAPKEY' => '',
                    'OXWRONGLOGINS' => 0,
                    'OXUPDATEKEY' => '',
                    'OXUPDATEEXP' => 0,
                ]
            );
        }
    }
}
