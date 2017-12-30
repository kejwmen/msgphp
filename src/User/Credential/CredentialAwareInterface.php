<?php

declare(strict_types=1);

namespace MsgPhp\User\Credential;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @todo favor User::getCredential() by default instead?
 */
interface CredentialAwareInterface
{
    public function getCredential(): CredentialInterface;
}
