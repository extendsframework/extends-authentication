<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication\Framework\ServiceLocator\Factory;

use ExtendsFramework\Authentication\AuthenticationInfoInterface;
use ExtendsFramework\Authentication\Realm\RealmInterface;
use ExtendsFramework\Authentication\Token\TokenInterface;
use ExtendsFramework\ServiceLocator\Resolver\StaticFactory\StaticFactoryInterface;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;

class AuthenticatorRealmStub implements RealmInterface, StaticFactoryInterface
{
    /**
     * @inheritDoc
     */
    public static function factory(string $key, ServiceLocatorInterface $serviceLocator, array $extra = null): object
    {
        return new static();
    }

    /**
     * @inheritDoc
     */
    public function canAuthenticate(TokenInterface $token): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getAuthenticationInfo(TokenInterface $token): ?AuthenticationInfoInterface
    {
        return null;
    }
}
