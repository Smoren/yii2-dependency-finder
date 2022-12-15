<?php

namespace Smoren\Yii2\DependencyFinder\Collections;

class ProjectDependencyCollection
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
     * @return array<string, ModuleDependencyCollection>
     */
    public function getMap(): array
    {
        return $this->map;
    }

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
     * @return string[]
     */
    public function getModuleNames(): array
    {
        return array_keys($this->map);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return !count($this->map);
    }
}
