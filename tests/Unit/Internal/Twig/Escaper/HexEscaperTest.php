<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Escaper;

use OxidEsales\EshopCommunity\Internal\Twig\Escaper\EscaperInterface;
use OxidEsales\EshopCommunity\Internal\Twig\Escaper\HexEscaper;
use OxidEsales\TestingLibrary\UnitTestCase;
use Twig\Environment;

/**
 * Class HexEscaperTest
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class HexEscaperTest extends UnitTestCase
{

    /** @var EscaperInterface */
    private $escaper;

    /** @var Environment */
    private $environment;

    public function setUp()
    {
        parent::setUp();
        $this->escaper = new HexEscaper();
        $this->environment = $this->createMock(Environment::class);
    }

    /**
     * @return array
     */
    public function escapeProvider(): array
    {
        return [
            ["A 'quote' is <b>bold</b>", "%41%20%27%71%75%6f%74%65%27%20%69%73%20%3c%62%3e%62%6f%6c%64%3c%2f%62%3e"]
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
        $this->assertEquals('hex', $this->escaper->getStrategy());
    }
}
