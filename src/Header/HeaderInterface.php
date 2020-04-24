<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication\Header;

interface HeaderInterface
{
    /**
     * Get scheme.
     *
     * @return string
     */
    public function getScheme(): string;

    /**
     * Get credentials.
     *
     * @return string
     */
    public function getCredentials(): string;
}
