<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication\Header;

class Header implements HeaderInterface
{
    /**
     * Scheme.
     *
     * @var string
     */
    private $scheme;

    /**
     * Credentials.
     *
     * @var string
     */
    private $credentials;

    /**
     * Header constructor.
     *
     * @param string $scheme
     * @param string $credentials
     */
    public function __construct(string $scheme, string $credentials)
    {
        $this->scheme = $scheme;
        $this->credentials = $credentials;
    }

    /**
     * @inheritDoc
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(): string
    {
        return $this->credentials;
    }
}
