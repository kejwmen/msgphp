<?php

declare(strict_types=1);

namespace MsgPhp\Eav\Infra\Doctrine\Type;

use MsgPhp\Domain\Infra\Doctrine\DomainUuidType;
use MsgPhp\Domain\Infra\Uuid\DomainId;
use MsgPhp\Eav\Infra\Uuid\AttributeId;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class AttributeIdType extends DomainUuidType
{
    public const NAME = 'msgphp_attribute_id';

    public function getName(): string
    {
        return self::NAME;
    }

    protected function convertToDomainId(string $value): DomainId
    {
        return new AttributeId($value);
    }
}
