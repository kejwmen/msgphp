<?php

declare(strict_types=1);

namespace MsgPhp\User\Entity\Features;

use MsgPhp\User\Entity\Credential\Token;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait AuthenticatesWithToken
{
    use AbstractCredential;

    /** @var Token */
    private $credential;

    final public function getToken(): string
    {
        return $this->credential->getToken();
    }

    final public function changeToken(string $token): void
    {
        $this->credential = $this->credential->withToken($token);

        $this->onUpdate();
    }
}
