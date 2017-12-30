<?php

declare(strict_types=1);

namespace MsgPhp\User\Entity\Credential;

use MsgPhp\User\Credential\CredentialInterface;
use MsgPhp\User\Entity\Credential\Features\NicknameAsUsername;
use MsgPhp\User\Password\{PasswordProtectedInterface, PasswordWithSaltProtectedTrait};

/**
 * Note one should prefer a saltless password implementation by default, i.e. {@see NicknamePassword}. The salted
 * password implementation is usually used in e.g. a legacy system.
 *
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class NicknameSaltedPassword implements CredentialInterface, PasswordProtectedInterface
{
    use NicknameAsUsername;
    use PasswordWithSaltProtectedTrait;

    public function __construct(string $nickname, string $password, string $passwordSalt)
    {
        $this->nickname = $nickname;
        $this->password = $password;
        $this->passwordSalt = $passwordSalt;
    }

    public function withNickname(string $nickname): self
    {
        return new self($nickname, $this->password, $this->passwordSalt);
    }

    public function withPassword(string $password): self
    {
        return new self($this->nickname, $password, $this->passwordSalt);
    }

    public function withPasswordSalt(string $passwordSalt): self
    {
        return new self($this->nickname, $this->password, $passwordSalt);
    }
}
