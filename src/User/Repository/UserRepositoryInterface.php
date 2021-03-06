<?php

declare(strict_types=1);

namespace MsgPhp\User\Repository;

use MsgPhp\Domain\DomainCollectionInterface;
use MsgPhp\User\Entity\User;
use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
interface UserRepositoryInterface
{
    /**
     * @return DomainCollectionInterface|User[]
     */
    public function findAll(int $offset = null, int $limit = null): DomainCollectionInterface;

    public function find(UserIdInterface $id): User;

    public function findByEmail(string $email): User;

    public function exists(UserIdInterface $id): bool;

    public function save(User $user): void;

    public function delete(User $user): void;
}
