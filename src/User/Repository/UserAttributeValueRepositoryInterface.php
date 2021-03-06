<?php

declare(strict_types=1);

namespace MsgPhp\User\Repository;

use MsgPhp\Domain\DomainCollectionInterface;
use MsgPhp\Eav\{AttributeIdInterface, AttributeValueIdInterface};
use MsgPhp\User\Entity\UserAttributeValue;
use MsgPhp\User\UserIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @todo move findAllByAttributeId+findAllByAttributeIdAndValue to Eav\AttributeValueRepositoryInterface
 * @todo extend from Eav\EntityAttributeValueRepositoryInterface?
 */
interface UserAttributeValueRepositoryInterface
{
    /**
     * @return DomainCollectionInterface|UserAttributeValue[]
     */
    public function findAllByAttributeId(AttributeIdInterface $attributeId, int $offset = null, int $limit = null): DomainCollectionInterface;

    /**
     * @return DomainCollectionInterface|UserAttributeValue[]
     */
    public function findAllByAttributeIdAndValue(AttributeIdInterface $attributeId, $value, int $offset = null, int $limit = null): DomainCollectionInterface;

    /**
     * @return DomainCollectionInterface|UserAttributeValue[]
     */
    public function findAllByUserId(UserIdInterface $userId, int $offset = null, int $limit = null): DomainCollectionInterface;

    /**
     * @return DomainCollectionInterface|UserAttributeValue[]
     */
    public function findAllByUserIdAndAttributeId(UserIdInterface $userId, AttributeIdInterface $attributeId, int $offset = null, int $limit = null): DomainCollectionInterface;

    public function find(UserIdInterface $userId, AttributeValueIdInterface $attributeValueId): UserAttributeValue;

    public function exists(UserIdInterface $userId, AttributeValueIdInterface $attributeValueId): bool;

    public function save(UserAttributeValue $userAttributeValue): void;

    public function delete(UserAttributeValue $userAttributeValue): void;
}
