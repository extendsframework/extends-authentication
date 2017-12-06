<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication\Framework\ServiceLocator\Factory;

use ExtendsFramework\Authentication\AuthenticationInfoInterface;
use ExtendsFramework\Authentication\AuthenticatorInterface;
use ExtendsFramework\Authentication\Realm\RealmInterface;
use ExtendsFramework\Authentication\Token\TokenInterface;
use ExtendsFramework\ServiceLocator\Resolver\StaticFactory\StaticFactoryInterface;
use ExtendsFramework\ServiceLocator\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;

class AuthenticatorFactoryTest extends TestCase
{
    /**
     * Create service.
     *
     * Test that instance of AuthorizerInterface will be created.
     *
     * @covers \ExtendsFramework\Authentication\Framework\ServiceLocator\Factory\AuthenticatorFactory::createService()
     * @covers \ExtendsFramework\Authentication\Framework\ServiceLocator\Factory\AuthenticatorFactory::createRealm()
     */
    public function testCreateService(): void
    {
        $serviceLocator = $this->createMock(ServiceLocatorInterface::class);
        $serviceLocator
            ->expects($this->once())
            ->method('getConfig')
            ->willReturn([
                AuthenticatorInterface::class => [
                    'realms' => [
                        [
                            'name' => AuthenticatorRealmStub::class,
                            'options' => [
                                'foo' => 'bar'
                            ],
                        ]
                    ],
                ],
            ]);

        $serviceLocator
            ->expects($this->once())
            ->method('getService')
            ->with(AuthenticatorRealmStub::class, ['foo' => 'bar'])
            ->willReturn(new AuthenticatorRealmStub());

        /**
         * @var ServiceLocatorInterface $serviceLocator
         */
        $factory = new AuthenticatorFactory();
        $authenticator = $factory->createService(AuthenticatorInterface::class, $serviceLocator);

        $this->assertInstanceOf(AuthenticatorInterface::class, $authenticator);
    }
}

class AuthenticatorRealmStub implements RealmInterface, StaticFactoryInterface
{
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

    /**
     * @inheritDoc
     */
    public static function factory(string $key, ServiceLocatorInterface $serviceLocator, array $extra = null)
    {
        return new static();
    }
}
