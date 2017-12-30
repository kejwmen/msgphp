<?php

declare(strict_types=1);

namespace MsgPhp\User\Entity\Features;

use MsgPhp\User\Entity\Credential\EmailSaltedPassword;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait EmailSaltedPasswordCredential
{
    use EmailPasswordCredential;

    /** @var EmailSaltedPassword */
    private $credential;

    final public function getPasswordSalt(): string
    {
        return $this->credential->getPasswordSalt();
    }

    final public function changePasswordSalt(string $passwordSalt): void
    {
        $this->credential = $this->credential->withPasswordSalt($passwordSalt);

        $this->onUpdate();
    }
}
