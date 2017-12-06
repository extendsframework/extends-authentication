<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication;

use PHPUnit\Framework\TestCase;

class AuthenticationInfoTest extends TestCase
{
    /**
     * Get identifier.
     *
     * Test that correct identifier will be returned.
     *
     * @covers \ExtendsFramework\Authentication\AuthenticationInfo::__construct()
     * @covers \ExtendsFramework\Authentication\AuthenticationInfo::getIdentifier()
     */
    public function testGetIdentifier(): void
    {
        $info = new AuthenticationInfo('foo-bar-baz');

        $this->assertSame('foo-bar-baz', $info->getIdentifier());
    }
}
