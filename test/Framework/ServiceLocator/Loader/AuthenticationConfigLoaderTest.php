<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication\Framework\ServiceLocator\Loader;

use ExtendsFramework\Authentication\AuthenticatorInterface;
use ExtendsFramework\Authentication\Framework\Http\Middleware\NotAuthenticatedMiddleware;
use ExtendsFramework\Authentication\Framework\ServiceLocator\Factory\AuthenticatorFactory;
use ExtendsFramework\Http\Middleware\Chain\MiddlewareChainInterface;
use ExtendsFramework\ServiceLocator\Resolver\Factory\FactoryResolver;
use ExtendsFramework\ServiceLocator\Resolver\Reflection\ReflectionResolver;
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
    public function testLoad()
    {
        $loader = new AuthenticationConfigLoader();

        $this->assertSame([
            ServiceLocatorInterface::class => [
                FactoryResolver::class => [
                    AuthenticatorInterface::class => AuthenticatorFactory::class,
                ],
                ReflectionResolver::class => [
                    NotAuthenticatedMiddleware::class => NotAuthenticatedMiddleware::class,
                ],
            ],
            MiddlewareChainInterface::class => [
                NotAuthenticatedMiddleware::class => 130,
            ],
            AuthenticatorInterface::class => [
                'realms' => [],
            ],
        ], $loader->load());
    }
}