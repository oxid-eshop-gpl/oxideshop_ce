<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Adapter\TemplateLogic;

use OxidEsales\Eshop\Core\Field;
use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FormDateLogic;
use PHPUnit\Framework\TestCase;

/**
 * Class FormDateLogicTest
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class FormDateLogicTest extends TestCase
{

    /** @var FormDateLogic */
    private $formDateLogic;

    protected function setUp()
    {
        parent::setUp();
        $this->formDateLogic = new FormDateLogic();
    }

    /**
     * @covers FormDateLogic::formdate
     */
    public function testFormdateWithDatetime()
    {
        $input = '01.08.2007 11.56.25';
        $expected = "2007-08-01 11:56:25";

        $this->assertEquals($expected, $this->formDateLogic->formdate($input, 'datetime', true));
    }

    /**
     * @covers FormDateLogic::formdate
     */
    public function testFormdateWithTimestamp()
    {
        $input = '20070801115625';
        $expected = "2007-08-01 11:56:25";

        $this->assertEquals($expected, $this->formDateLogic->formdate($input, 'timestamp', true));
    }

    /**
     * @covers FormDateLogic::formdate
     */
    public function testFormdateWithDate()
    {
        $input = '2007-08-01 11:56:25';
        $expected = "2007-08-01";

        $this->assertEquals($expected, $this->formDateLogic->formdate($input, 'date', true));
    }

    /**
     * @covers FormDateLogic::formdate
     */
    public function testFormdateUsingObject()
    {
        $expected = "2007-08-01 11:56:25";

        $field = new Field();
        $field->fldmax_length = "0";
        $field->fldtype = 'datetime';
        $field->setValue('01.08.2007 11.56.25');

        $this->assertEquals($expected, $this->formDateLogic->formdate($field, 'datetime'));
    }
}
