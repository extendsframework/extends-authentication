<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication\Framework\ServiceLocator\Factory;

use ExtendsFramework\Authentication\AuthenticatorInterface;
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
                                'foo' => 'bar',
                            ],
                        ],
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
