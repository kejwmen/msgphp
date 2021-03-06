<?php

declare(strict_types=1);

namespace MsgPhp\Eav\Infra\Doctrine\Type;

use MsgPhp\Domain\Infra\Doctrine\DomainUuidType;
use MsgPhp\Domain\Infra\Uuid\DomainId;
use MsgPhp\Eav\Infra\Uuid\AttributeValueId;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class AttributeValueIdType extends DomainUuidType
{
    public const NAME = 'msgphp_attribute_value_id';

    public function getName(): string
    {
        return self::NAME;
    }

    protected function convertToDomainId(string $value): DomainId
    {
        return new AttributeValueId($value);
    }
}
