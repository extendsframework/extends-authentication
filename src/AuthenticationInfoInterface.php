<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication;

interface AuthenticationInfoInterface
{
    /**
     * Get identifier.
     *
     * @return string
     */
    public function getIdentifier(): string;
}
