<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication;

use ExtendsFramework\Authentication\Header\HeaderInterface;

interface AuthenticatorInterface
{
    /**
     * Authenticate header.
     *
     * An exception will be thrown when authentication fails.
     *
     * @param HeaderInterface $header
     *
     * @return AuthenticationInfoInterface|null
     */
    public function authenticate(HeaderInterface $header): ?AuthenticationInfoInterface;
}
