<?php

declare(strict_types=1);

namespace MsgPhp\User\Entity\Features;

use MsgPhp\User\Entity\Credential\EmailPassword;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait EmailPasswordCredential
{
    use EmailCredential;

    /** @var EmailPassword */
    private $credential;

    final public function getPassword(): string
    {
        return $this->credential->getPassword();
    }

    final public function changePassword(string $password): void
    {
        $this->credential = $this->credential->withPassword($password);

        $this->onUpdate();
    }
}
