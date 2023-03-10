<?php

namespace Smoren\Yii2\DependencyFinder\Collections;

use Smoren\Yii2\DependencyFinder\Interfaces\CollectionInterface;
use Generator;

class ModuleDependencyCollection implements CollectionInterface
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
     * {@inheritDoc}
     * @return array<string, array<string, array<string>>>
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
        $modules = $this->getModuleNames();

        return [
            'modules' => $modules,
            'files_count' => count($this->getFileNames()),
            'usages_count' => count($this->getUsages()),
            'map' => $this->getMap(),
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
        foreach($this->getMap() as $fileName => $moduleUsagesMap) {
            yield $keyOffset => $fileName;
            foreach($moduleUsagesMap as $depModuleName => $usages) {
                yield $keyOffset+1 => $depModuleName;
                foreach($usages as $usage) {
                    yield $keyOffset+2 => $usage;
                }
            }
        }
    }

    /**
     * @return string[]
     */
    public function getModuleNames(): array
    {
        $result = [];

        foreach($this->getMap() as $fileDependencies) {
            foreach($fileDependencies as $moduleName => $usages) {
                $result[$moduleName] = $moduleName;
            }
        }

        $result = array_values($result);
        sort($result);
        return $result;
    }

    /**
     * @return string[]
     */
    public function getFileNames(): array
    {
        return array_keys($this->getMap());
    }

    /**
     * @param string|null $moduleNameOnly
     * @return array
     */
    public function getUsages(?string $moduleNameOnly = null): array
    {
        $result = [];

        foreach($this->getMap() as $fileDependencies) {
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
}
