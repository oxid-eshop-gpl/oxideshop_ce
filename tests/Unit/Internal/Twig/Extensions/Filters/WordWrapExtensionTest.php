<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\WordWrapLogic;
use OxidEsales\EshopCommunity\Internal\Twig\Extensions\Filters\WordWrapExtension;
use OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\Extensions\AbstractExtensionTest;

/**
 * Class WordWrapExtensionTest
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class WordWrapExtensionTest extends AbstractExtensionTest
{

    /** @var WordWrapExtension */
    protected $extension;

    public function setUp()
    {
        $this->extension = new WordWrapExtension(new WordWrapLogic());
    }

    /**
     * Provides data for testWordWrapWithNonAscii
     *
     * @return array
     */
    public function nonAsciiProvider(): array
    {
        return [
            ['{{ "HÖ HÖ"|word_wrap(2) }}', "HÖ\nHÖ"],
            ['{{ "HÖa HÖa"|word_wrap(2, "\n", true) }}', "HÖ\na\nHÖ\na"],
            ['{{ "HÖaa HÖaa"|word_wrap(3, "\n", true) }}', "HÖa\na\nHÖa\na"],
            ['{{ "HÖa HÖa"|word_wrap(2) }}', "HÖa\nHÖa"]
        ];
    }

    /**
     * @param string $template
     * @param string $expected
     *
     * @dataProvider nonAsciiProvider
     */
    public function testWordWrapWithNonAscii($template, $expected)
    {
        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }

    /**
     * Provides data for testWordWrapAscii
     *
     * @return array
     */
    public function asciiProvider(): array
    {
        return [
            ['{{ "aaa aaa"|word_wrap(2) }}', "aaa\naaa"],
            ['{{ "aaa aaa"|word_wrap(2, "\n", true) }}', "aa\na\naa\na"],
            ['{{ "aaa aaa a"|word_wrap(5) }}', "aaa\naaa a"],
            ['{{ "aaa aaa"|word_wrap(5, "\n", true) }}', "aaa\naaa"],
            ['{{ "   aaa    aaa"|word_wrap(2) }}', "  \naaa\n  \naaa"],
            ['{{ "   aaa    aaa"|word_wrap(2, "\n", true) }}', "  \naa\na \n \naa\na"],
            ['{{ "   aaa    aaa"|word_wrap(5) }}', "  \naaa  \n aaa"],
            ['{{ "   aaa    aaa"|word_wrap(5, "\n", true) }}', "  \naaa  \n aaa"],
            [
                "{{ 'Pellentesque nisl non condimentum cursus.\n  consectetur a diam sit.\n finibus diam eu libero lobortis.\neu   ex   sit'|word_wrap(10, \"\\n\", true) }}",
                "Pellentesq\nue nisl\nnon\ncondimentu\nm cursus.\n \nconsectetu\nr a diam\nsit.\n finibus\ndiam eu\nlibero\nlobortis.\neu   ex  \nsit"
            ]
        ];
    }

    /**
     * @param string $template
     * @param string $expected
     *
     * @dataProvider asciiProvider
     */
    public function testWordWrapAscii($template, $expected)
    {
        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }
}
