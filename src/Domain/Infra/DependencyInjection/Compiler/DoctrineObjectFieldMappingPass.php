<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\DependencyInjection\Compiler;

use MsgPhp\Domain\Infra\DependencyInjection\Bundle\ContainerHelper;
use MsgPhp\Domain\Infra\Doctrine\Mapping\{ObjectFieldMappingListener, ObjectFieldMappingProviderInterface};
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @internal
 */
final class DoctrineObjectFieldMappingPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    private $tagName;

    public function __construct(string $tagName = 'msgphp.doctrine.object_field_mapping')
    {
        $this->tagName = $tagName;
    }

    public function process(ContainerBuilder $container): void
    {
        $mapping = [];
        foreach ($this->findAndSortTaggedServices($this->tagName, $container) as $provider) {
            $definition = $container->findDefinition((string) $provider);
            $reflection = ContainerHelper::getClassReflection($container, $class = $definition->getClass());

            if (!$reflection->implementsInterface(ObjectFieldMappingProviderInterface::class)) {
                throw new InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $provider, ObjectFieldMappingProviderInterface::class));
            }

            $mapping = array_replace_recursive($mapping, $class::getObjectFieldMapping());
        }

        if ($mapping) {
            $container->findDefinition(ObjectFieldMappingListener::class)
                ->setArgument('$mapping', $mapping);
        } else {
            $container->removeDefinition(ObjectFieldMappingListener::class);
        }
    }
}
