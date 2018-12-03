<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Escaper;

use OxidEsales\EshopCommunity\Internal\Twig\Escaper\EscaperInterface;
use OxidEsales\EshopCommunity\Internal\Twig\Escaper\HexEntityEscaper;
use OxidEsales\TestingLibrary\UnitTestCase;
use Twig\Environment;

/**
 * Class HexEntityEscaperTest
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class HexEntityEscaperTest extends UnitTestCase
{

    /** @var EscaperInterface */
    private $escaper;

    /** @var Environment */
    private $environment;

    public function setUp()
    {
        parent::setUp();
        $this->escaper = new HexEntityEscaper();
        $this->environment = $this->createMock(Environment::class);
    }

    /**
     * @return array
     */
    public function escapeProvider(): array
    {
        return [
            [
                "A 'quote' is <b>bold</b>",
                "&#x41;&#x20;&#x27;&#x71;&#x75;&#x6f;&#x74;&#x65;&#x27;&#x20;&#x69;&#x73;&#x20;&#x3c;&#x62;&#x3e;&#x62;&#x6f;&#x6c;&#x64;&#x3c;&#x2f;&#x62;&#x3e;"
            ]
        ];
    }

    /**
     * @param string $string
     * @param string $expected
     *
     * @dataProvider escapeProvider
     */
    public function testEscape($string, $expected)
    {
        $this->assertEquals($expected, $this->escaper->escape($this->environment, $string, 'UTF-8'));
    }

    public function testGetStrategy()
    {
        $this->assertEquals('hexentity', $this->escaper->getStrategy());
    }
}
