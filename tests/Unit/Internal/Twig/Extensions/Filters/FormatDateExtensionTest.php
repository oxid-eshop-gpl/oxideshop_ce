<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extensions;

use OxidEsales\Eshop\Core\Field;
use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FormatDateLogic;
use OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters\FormatDateExtension;

/**
 * Class FormatDateExtensionTest
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class FormatDateExtensionTest extends AbstractExtensionTest
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->extension = new FormatDateExtension(new FormatDateLogic());
    }

    /**
     * @covers FormatDateExtension::form_date
     */
    public function testFormDateWithDatetime(): void
    {
        $template = "{{ '01.08.2007 11.56.25'|date_format('datetime', true) }}";
        $expected = "2007-08-01 11:56:25";

        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }

    /**
     * @covers FormatDateExtension::form_date
     */
    public function testFormDateWithTimestamp(): void
    {
        $template = "{{ '20070801115625'|date_format('timestamp', true) }}";
        $expected = "2007-08-01 11:56:25";

        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }

    /**
     * @covers FormatDateExtension::form_date
     */
    public function testFormDateWithDate(): void
    {
        $template = "{{ '2007-08-01 11:56:25'|date_format('date', true) }}";
        $expected = "2007-08-01";

        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }

    /**
     * @covers FormatDateExtension::form_date
     */
    public function testFormDateUsingObject(): void
    {
        $template = "{{ field|date_format('datetime') }}";
        $expected = "2007-08-01 11:56:25";

        $field = new Field();
        $field->fldmax_length = "0";
        $field->fldtype = 'datetime';
        $field->setValue('01.08.2007 11.56.25');

        $this->assertEquals($expected, $this->getTemplate($template)->render(['field' => $field]));
    }
}
