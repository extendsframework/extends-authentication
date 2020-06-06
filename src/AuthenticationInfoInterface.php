<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication;

use ExtendsFramework\Identity\IdentityInterface;

interface AuthenticationInfoInterface
{
    /**
     * Get identity.
     *
     * @return IdentityInterface
     */
    public function getIdentity(): IdentityInterface;
}
