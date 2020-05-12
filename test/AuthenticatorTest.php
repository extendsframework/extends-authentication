<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication;

use ExtendsFramework\Authentication\Header\HeaderInterface;
use ExtendsFramework\Authentication\Realm\RealmInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AuthenticatorTest extends TestCase
{
    /**
     * Authenticate.
     *
     * Test that header can be authenticated with realm and authentication info will be returned.
     *
     * @covers \ExtendsFramework\Authentication\Authenticator::addRealm()
     * @covers \ExtendsFramework\Authentication\Authenticator::authenticate()
     */
    public function testAuthenticate(): void
    {
        $header = $this->createMock(HeaderInterface::class);

        $info = $this->createMock(AuthenticationInfoInterface::class);

        $realm = $this->createMock(RealmInterface::class);
        $realm
            ->expects($this->once())
            ->method('canAuthenticate')
            ->with($header)
            ->willReturn(true);

        $realm
            ->expects($this->once())
            ->method('getAuthenticationInfo')
            ->with($header)
            ->willReturn($info);

        /**
         * @var RealmInterface $realm
         * @var HeaderInterface $header
         */
        $authenticator = new Authenticator();
        $authenticated = $authenticator
            ->addRealm($realm)
            ->authenticate($header);

        $this->assertSame($info, $authenticated);
    }

    /**
     * Fallback realm.
     *
     * Test that both realms can authenticate header, but only the second has any authentication information.
     *
     * @covers \ExtendsFramework\Authentication\Authenticator::addRealm()
     * @covers \ExtendsFramework\Authentication\Authenticator::authenticate()
     */
    public function testFallbackRealm(): void
    {
        $header = $this->createMock(HeaderInterface::class);

        $info = $this->createMock(AuthenticationInfoInterface::class);

        $realm = $this->createMock(RealmInterface::class);
        $realm
            ->expects($this->exactly(2))
            ->method('canAuthenticate')
            ->with($header)
            ->willReturn(true);

        $realm
            ->expects($this->exactly(2))
            ->method('getAuthenticationInfo')
            ->with($header)
            ->willReturnOnConsecutiveCalls(
                null,
                $info
            );

        /**
         * @var RealmInterface $realm
         * @var HeaderInterface $header
         */
        $authenticator = new Authenticator();
        $authenticated = $authenticator
            ->addRealm($realm)
            ->addRealm($realm)
            ->authenticate($header);

        $this->assertSame($info, $authenticated);
    }

    /**
     * Authentication failure.
     *
     * Test that when a realm throws an exception the next realm will not be called. For example when credentials are
     * invalid.
     *
     * @covers \ExtendsFramework\Authentication\Authenticator::addRealm()
     * @covers \ExtendsFramework\Authentication\Authenticator::authenticate()
     */
    public function testAuthenticationFailure(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $header = $this->createMock(HeaderInterface::class);

        $realm = $this->createMock(RealmInterface::class);
        $realm
            ->expects($this->once())
            ->method('canAuthenticate')
            ->with($header)
            ->willReturn(true);

        $realm
            ->expects($this->once())
            ->method('getAuthenticationInfo')
            ->with($header)
            ->willThrowException(new InvalidArgumentException());

        /**
         * @var RealmInterface $realm
         * @var HeaderInterface $header
         */
        $authenticator = new Authenticator();
        $authenticator
            ->addRealm($realm)
            ->addRealm($realm)
            ->authenticate($header);
    }

    /**
     * Authentication not supported.
     *
     * Test that no realm can authenticate header and null will be returned.
     *
     * @covers \ExtendsFramework\Authentication\Authenticator::addRealm()
     * @covers \ExtendsFramework\Authentication\Authenticator::authenticate()
     */
    public function testAuthenticationNotSupported(): void
    {
        $header = $this->createMock(HeaderInterface::class);

        /**
         * @var HeaderInterface $header
         */
        $authenticator = new Authenticator();
        $this->assertNull($authenticator->authenticate($header));
    }
}
