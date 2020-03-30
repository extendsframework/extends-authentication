<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication\Framework\ServiceLocator\Loader;

use ExtendsFramework\Authentication\AuthenticatorInterface;
use ExtendsFramework\Authentication\Framework\Http\Middleware\UnauthorizedMiddleware;
use ExtendsFramework\Authentication\Framework\ServiceLocator\Factory\AuthenticatorFactory;
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
                    UnauthorizedMiddleware::class => UnauthorizedMiddleware::class,
                ],
            ],
            AuthenticatorInterface::class => [
                'realms' => [],
            ],
        ];
    }
}
