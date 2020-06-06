<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication;

use ExtendsFramework\Identity\IdentityInterface;

class AuthenticationInfo implements AuthenticationInfoInterface
{
    /**
     * Identity.
     *
     * @var IdentityInterface
     */
    private $identity;

    /**
     * AuthenticationInfo constructor.
     *
     * @param IdentityInterface $identity
     */
    public function __construct(IdentityInterface $identity)
    {
        $this->identity = $identity;
    }

    /**
     * @inheritDoc
     */
    public function getIdentity(): IdentityInterface
    {
        return $this->identity;
    }
}
