<?php

declare(strict_types=1);

namespace MsgPhp\User\Entity\Credential\Features;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait EmailAsUsername
{
    /** @var string */
    private $email;

    final public function getEmail(): string
    {
        return $this->email;
    }

    final public function getUsername(): string
    {
        return $this->email;
    }
}
