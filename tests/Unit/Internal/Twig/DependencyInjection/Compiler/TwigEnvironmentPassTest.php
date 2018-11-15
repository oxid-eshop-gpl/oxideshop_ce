<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Twig\DependencyInjection\Compiler;

use PHPUnit\Framework\TestCase;
use OxidEsales\EshopCommunity\Internal\Twig\Extensions\MathExtension;
use OxidEsales\EshopCommunity\Internal\Twig\DependencyInjection\Compiler\TwigEnvironmentPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class TwigEnvironmentPassTest
 */
class TwigEnvironmentPassTest extends TestCase
{

    public function testTwigBridgeExtensionsAreRegisteredFirst()
    {
        $container = new ContainerBuilder();
        $twigDefinition = $container->register('twig');
        $container->register('other_extension', 'Foo\Bar')
            ->addTag('twig.extension');
        $container->register('twig_bridge_extension', MathExtension::class)
            ->addTag('twig.extension');

        $twigEnvironmentPass = new TwigEnvironmentPass();
        $twigEnvironmentPass->process($container);

        $methodCalls = $twigDefinition->getMethodCalls();
        $this->assertCount(2, $methodCalls);

        $otherExtensionReference = $methodCalls[0][1][0];
        $this->assertInstanceOf(Reference::class, $otherExtensionReference);
        $this->assertSame('other_extension', (string) $otherExtensionReference);

        $twigBridgeExtensionReference = $methodCalls[1][1][0];
        $this->assertInstanceOf(Reference::class, $twigBridgeExtensionReference);
        $this->assertSame('twig_bridge_extension', (string) $twigBridgeExtensionReference);
    }
}
