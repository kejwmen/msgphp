<?php

declare(strict_types=1);

namespace MsgPhp\User\Entity\Features;

use MsgPhp\User\Entity\Credential\Email;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait EmailCredential
{
    use AbstractCredential;

    /** @var Email */
    private $credential;

    final public function getEmail()
    {
        return $this->credential->getEmail();
    }

    final public function changeEmail(string $email): void
    {
        $this->credential = $this->credential->withEmail($email);

        $this->onUpdate();
    }
}
