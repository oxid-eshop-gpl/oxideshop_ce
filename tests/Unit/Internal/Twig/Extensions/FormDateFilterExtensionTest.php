<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extensions;

use OxidEsales\Eshop\Core\Field;
use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FormDateLogic;
use OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters\FormDateFilterExtension;

/**
 * Class FormDateFilterExtensionTest
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class FormDateFilterExtensionTest extends AbstractExtensionTest
{

    protected function setUp()
    {
        parent::setUp();
        $this->extension = new FormDateFilterExtension(new FormDateLogic());
    }

    /**
     * @covers FormDateFilterExtension::formdate
     */
    public function testFormDateWithDatetime()
    {
        $template = "{{ '01.08.2007 11.56.25'|formdate('datetime', true) }}";
        $expected = "2007-08-01 11:56:25";

        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }

    /**
     * @covers FormDateFilterExtension::formdate
     */
    public function testFormDateWithTimestamp()
    {
        $template = "{{ '20070801115625'|formdate('timestamp', true) }}";
        $expected = "2007-08-01 11:56:25";

        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }

    /**
     * @covers FormDateFilterExtension::formdate
     */
    public function testFormDateWithDate()
    {
        $template = "{{ '2007-08-01 11:56:25'|formdate('date', true) }}";
        $expected = "2007-08-01";

        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }

    /**
     * @covers FormDateFilterExtension::formdate
     */
    public function testFormDateUsingObject()
    {
        $template = "{{ field|formdate('datetime') }}";
        $expected = "2007-08-01 11:56:25";

        $field = new Field();
        $field->fldmax_length = "0";
        $field->fldtype = 'datetime';
        $field->setValue('01.08.2007 11.56.25');

        $this->assertEquals($expected, $this->getTemplate($template)->render(['field' => $field]));
    }
}
