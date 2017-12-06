<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication\Framework\ServiceLocator\Loader;

use ExtendsFramework\Authentication\AuthenticatorInterface;
use ExtendsFramework\Authentication\Framework\Http\Middleware\NotAuthenticatedMiddleware;
use ExtendsFramework\Authentication\Framework\ServiceLocator\Factory\AuthenticatorFactory;
use ExtendsFramework\Http\Middleware\Chain\MiddlewareChainInterface;
use ExtendsFramework\ServiceLocator\Config\Loader\LoaderInterface;
use ExtendsFramework\ServiceLocator\Resolver\Factory\FactoryResolver;
use ExtendsFramework\ServiceLocator\Resolver\Reflection\ReflectionResolver;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;

class AuthenticationConfigLoader implements LoaderInterface
{
    /**
     * @inheritDoc
     */
    public function load(): array
    {
        return [
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
        ];
    }
}
