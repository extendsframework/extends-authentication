<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication;

use ExtendsFramework\Authentication\Realm\RealmInterface;
use ExtendsFramework\Authentication\Token\TokenInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AuthenticatorTest extends TestCase
{
    /**
     * Authenticate.
     *
     * Test that token can be authenticated with realm and authentication info will be returned.
     *
     * @covers \ExtendsFramework\Authentication\Authenticator::addRealm()
     * @covers \ExtendsFramework\Authentication\Authenticator::authenticate()
     */
    public function testAuthenticate(): void
    {
        $token = $this->createMock(TokenInterface::class);

        $info = $this->createMock(AuthenticationInfoInterface::class);

        $realm = $this->createMock(RealmInterface::class);
        $realm
            ->expects($this->once())
            ->method('canAuthenticate')
            ->with($token)
            ->willReturn(true);

        $realm
            ->expects($this->once())
            ->method('getAuthenticationInfo')
            ->with($token)
            ->willReturn($info);

        /**
         * @var RealmInterface $realm
         * @var TokenInterface $token
         */
        $authenticator = new Authenticator();
        $authenticated = $authenticator
            ->addRealm($realm)
            ->authenticate($token);

        $this->assertSame($info, $authenticated);
    }

    /**
     * Fallback realm.
     *
     * Test that both realms can authenticate token, but only the second has any authentication information.
     *
     * @covers \ExtendsFramework\Authentication\Authenticator::addRealm()
     * @covers \ExtendsFramework\Authentication\Authenticator::authenticate()
     */
    public function testFallbackRealm(): void
    {
        $token = $this->createMock(TokenInterface::class);

        $info = $this->createMock(AuthenticationInfoInterface::class);

        $realm = $this->createMock(RealmInterface::class);
        $realm
            ->expects($this->exactly(2))
            ->method('canAuthenticate')
            ->with($token)
            ->willReturn(true);

        $realm
            ->expects($this->exactly(2))
            ->method('getAuthenticationInfo')
            ->with($token)
            ->willReturnOnConsecutiveCalls(
                null,
                $info
            );

        /**
         * @var RealmInterface $realm
         * @var TokenInterface $token
         */
        $authenticator = new Authenticator();
        $authenticated = $authenticator
            ->addRealm($realm)
            ->addRealm($realm)
            ->authenticate($token);

        $this->assertSame($info, $authenticated);
    }

    /**
     * Authentication failure.
     *
     * Test that when a realm throws an exception the next realm will not be called. For example when credentials are
     * invalid.
     *
     * @covers            \ExtendsFramework\Authentication\Authenticator::addRealm()
     * @covers            \ExtendsFramework\Authentication\Authenticator::authenticate()
     * @expectedException InvalidArgumentException
     */
    public function testAuthenticationFailure(): void
    {
        $token = $this->createMock(TokenInterface::class);

        $realm = $this->createMock(RealmInterface::class);
        $realm
            ->expects($this->once())
            ->method('canAuthenticate')
            ->with($token)
            ->willReturn(true);

        $realm
            ->expects($this->once())
            ->method('getAuthenticationInfo')
            ->with($token)
            ->willThrowException(new InvalidArgumentException());

        /**
         * @var RealmInterface $realm
         * @var TokenInterface $token
         */
        $authenticator = new Authenticator();
        $authenticator
            ->addRealm($realm)
            ->addRealm($realm)
            ->authenticate($token);
    }

    /**
     * Authentication not supported.
     *
     * Test that no realm can authenticate token and an exception will be thrown.
     *
     * @covers                   \ExtendsFramework\Authentication\Authenticator::addRealm()
     * @covers                   \ExtendsFramework\Authentication\Authenticator::authenticate()
     * @covers                   \ExtendsFramework\Authentication\Exception\AuthenticationFailed::__construct()
     * @expectedException        \ExtendsFramework\Authentication\Exception\AuthenticationFailed
     * @expectedExceptionMessage No realm has succesfully authenticated token.
     */
    public function testAuthenticationNotSupported(): void
    {
        $token = $this->createMock(TokenInterface::class);

        /**
         * @var TokenInterface $token
         */
        $authenticator = new Authenticator();
        $authenticator->authenticate($token);
    }
}
