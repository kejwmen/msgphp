<?php

declare(strict_types=1);

namespace MsgPhp\User\Credential;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @todo move to root
 */
interface CredentialInterface
{
    public function getUsername(): string;
}
