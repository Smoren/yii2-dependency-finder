<?php

namespace Smoren\Yii2\DependencyFinder\Collections;

class ModuleDependencyCollection
{
    /**
     * @var array<string, array<string, array<string>>>
     */
    protected array $map;

    /**
     * @param array<string, array<string, array<string>>> $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    /**
     * @return array<string, array<string, array<string>>>
     */
    public function getMap(): array
    {
        return $this->map;
    }

    public function getSummary(): array
    {
        $modules = $this->getModuleNames();

        return [
            'modules' => $modules,
            'files_count' => count($this->getFileNames()),
            'usages_count' => count($this->getUsages()),
            'map' => $this->map,
        ];
    }

    /**
     * @return string[]
     */
    public function getModuleNames(): array
    {
        $result = [];

        foreach($this->map as $fileDependencies) {
            foreach($fileDependencies as $moduleName => $usages) {
                $result[$moduleName] = $moduleName;
            }
        }

        return array_values($result);
    }

    /**
     * @return string[]
     */
    public function getFileNames(): array
    {
        return array_keys($this->map);
    }

    /**
     * @param string|null $moduleNameOnly
     * @return array
     */
    public function getUsages(?string $moduleNameOnly = null): array
    {
        $result = [];

        foreach($this->map as $fileDependencies) {
            foreach($fileDependencies as $moduleName => $usages) {
                if($moduleNameOnly !== null && $moduleName !== $moduleNameOnly) {
                    continue;
                }
                foreach($usages as $usage) {
                    $result[$usage] = $usage;
                }
            }
        }

        return array_values($result);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return !count($this->map);
    }
}
