<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication\Framework\ServiceLocator\Loader;

use ExtendsFramework\Authentication\AuthenticatorInterface;
use ExtendsFramework\Authentication\Framework\ServiceLocator\Factory\AuthenticatorFactory;
use ExtendsFramework\ServiceLocator\Resolver\Factory\FactoryResolver;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;

class AuthenticationConfigLoaderTest extends TestCase
{
    /**
     * Load.
     *
     * Test that loader returns correct array.
     *
     * @covers \ExtendsFramework\Authentication\Framework\ServiceLocator\Loader\AuthenticationConfigLoader::load()
     */
    public function testLoad(): void
    {
        $loader = new AuthenticationConfigLoader();

        $this->assertSame([
            ServiceLocatorInterface::class => [
                FactoryResolver::class => [
                    AuthenticatorInterface::class => AuthenticatorFactory::class,
                ],
            ],
            AuthenticatorInterface::class => [
                'realms' => [],
            ],
        ], $loader->load());
    }
}
