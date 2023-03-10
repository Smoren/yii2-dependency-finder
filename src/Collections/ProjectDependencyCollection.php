<?php

namespace Smoren\Yii2\DependencyFinder\Collections;

use Smoren\Yii2\DependencyFinder\Interfaces\CollectionInterface;
use Generator;

class ProjectDependencyCollection implements CollectionInterface
{
    /**
     * @var array<string, ModuleDependencyCollection>
     */
    protected array $map;

    /**
     * @param array<string, ModuleDependencyCollection> $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    /**
     * {@inheritDoc}
     * @return array<string, ModuleDependencyCollection>
     */
    public function getMap(): array
    {
        $map = $this->map;
        ksort($map);
        return $map;
    }

    /**
     * {@inheritDoc}
     * @return array<string, mixed>
     */
    public function getSummary(): array
    {
        $summary = [];
        foreach($this->map as $moduleName => $dependencyCollection) {
            $summary[$moduleName] = $dependencyCollection->getSummary();
        }

        return [
            'modules' => $this->getModuleNames(),
            'summary' => $summary,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function isEmpty(): bool
    {
        return !count($this->map);
    }

    /**
     * {@inheritDoc}
     * @return Generator<int, string>
     */
    public function iterate(int $keyOffset = 0): Generator
    {
        foreach($this->getMap() as $moduleName => $moduleDependencyCollection) {
            yield $keyOffset => $moduleName;
            yield from $moduleDependencyCollection->iterate(1);
        }
    }

    /**
     * @return string[]
     */
    public function getModuleNames(): array
    {
        return array_keys($this->map);
    }
}
