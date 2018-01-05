<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\InMemory;

use MsgPhp\Domain\DomainIdInterface;
use MsgPhp\Domain\Exception\DuplicateEntityException;
use MsgPhp\Domain\Exception\EntityNotFoundException;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait DomainEntityRepositoryTrait
{
    private $memory;
    private $class;

    public function __construct(array $memory, string $class)
    {
        $this->memory = $memory;
        $this->class = $class;
    }

    private function doFind($id, ...$idN)
    {
        return $this->doFindByFields(array_combine($this->idFields, func_get_args()));
    }

    private function doFindByFields(array $fields)
    {
        foreach ($this->memory as $entity) {
            foreach ($fields as $field => $value) {
                $knownValue = $this->getEntityField($entity, $field);
                if ($knownValue instanceof DomainIdInterface && $value instanceof DomainIdInterface && $knownValue->equals($value)) {
                    continue;
                } elseif ($knownValue instanceof DomainIdInterface) {
                    //$knownValue = $knownValue->toString();
                } elseif ($value instanceof DomainIdInterface) {
                    //$value = $value->toString();
                }

                if ($value !== $knownValue) {
                    continue 2;
                }
            }

            return $entity;
        }

        throw EntityNotFoundException::createForFields($this->class, $fields);
    }

    private function doExists($id, ...$idN): bool
    {
        return $this->doExistsByFields(array_combine($this->idFields, func_get_args()));
    }

    private function doExistsByFields(array $fields): bool
    {
        try {
            $this->doFindByFields($fields);

            return true;
        } catch (EntityNotFoundException $e) {
            return false;
        }
    }

    private function doSave($entity): void
    {
        if (!in_array($entity, $this->memory, true)) {
            if ($this->doExists(...$id = $this->getEntityId($entity))) {
                throw DuplicateEntityException::createForId(get_class($entity), $id);
            }

            $this->memory[] = $entity;
        }
    }

    private function doDelete($entity): void
    {
        foreach ($this->memory as $i => $knownEntity) {
            if ($knownEntity === $entity) {
                unset($this->memory[$i]);

                return;
            }
        }
    }

    private function getEntityId($entity): array
    {
        $id = [];

        foreach ($this->idFields as $field) {
            $id[] = $this->getEntityField($entity, $field);
        }

        return $id;
    }

    private function getEntityField($entity, $field)
    {
        if (method_exists($entity, $method = 'get'.ucfirst($field))) {
            return $entity->$method();
        }

        if (method_exists($entity, $field)) {
            return $entity->$field();
        }

        if (property_exists($entity, $field)) {
            return $entity->$field;
        }

        throw new \UnexpectedValueException(sprintf('Unknown field name "%s" for entity "%s"', $field, get_class($entity)));
    }

    private function createResultSet(int $offset = null, int $limit = null, callable $filter = null): DomainCollection
    {
        $memory = null == $filter ? $this->memory : array_values(array_filter($this->memory, $filter));

        if (null !== $offset || null !== $limit) {
            $memory = array_slice($memory, $offset ?? 0, $limit);
        }

        return new DomainCollection($memory);
    }
}
