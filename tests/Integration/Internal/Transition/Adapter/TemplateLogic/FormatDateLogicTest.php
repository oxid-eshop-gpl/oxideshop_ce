<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Transition\Adapter\TemplateLogic;

use OxidEsales\Eshop\Core\Field;
use OxidEsales\EshopCommunity\Internal\Transition\Adapter\TemplateLogic\FormatDateLogic;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use PHPUnit\Framework\TestCase;

/**
 * Class FormatDateLogicTest
 *
 * @covers \OxidEsales\EshopCommunity\Internal\Transition\Adapter\TemplateLogic\FormatDateLogic
 */
class FormatDateLogicTest extends IntegrationTestCase
{

    /** @var FormatDateLogic */
    private $formDateLogic;

    public function setUp(): void
    {
        parent::setUp();
        $this->formDateLogic = new FormatDateLogic();
    }

    public function testFormdateWithDatetime(): void
    {
        $input = '01.08.2007 11.56.25';
        $expected = "2007-08-01 11:56:25";

        $this->assertEquals($expected, $this->formDateLogic->formdate($input, 'datetime', true));
    }

    public function testFormdateWithTimestamp(): void
    {
        $input = '20070801115625';
        $expected = "2007-08-01 11:56:25";

        $this->assertEquals($expected, $this->formDateLogic->formdate($input, 'timestamp', true));
    }

    public function testFormdateWithDate(): void
    {
        $input = '2007-08-01 11:56:25';
        $expected = "2007-08-01";

        $this->assertEquals($expected, $this->formDateLogic->formdate($input, 'date', true));
    }

    public function testFormdateUsingObject(): void
    {
        $expected = "2007-08-01 11:56:25";

        $field = new Field();
        $field->fldmax_length = "0";
        $field->fldtype = 'datetime';
        $field->setValue('01.08.2007 11.56.25');

        $this->assertEquals($expected, $this->formDateLogic->formdate($field, 'datetime'));
    }
}
