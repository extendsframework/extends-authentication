<?php
declare(strict_types=1);

namespace ExtendsFramework\Authentication\Framework\Http\Middleware;

use ExtendsFramework\Authentication\AuthenticationException;
use LogicException;

class AuthenticationExceptionStub extends LogicException implements AuthenticationException
{
}
