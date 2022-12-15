<?php

namespace Smoren\Yii2\DependencyFinder\Components;

use Smoren\Yii2\DependencyFinder\Collections\ProjectDependencyCollection;
use Smoren\Yii2\DependencyFinder\Structs\Path;
use Exception;

class CsvWriter
{
    public function write(Path $filePath, ProjectDependencyCollection $dependencyCollection): void
    {
        $fh = fopen($filePath, 'w');
        $separator = ';';

        if(!$fh) {
            throw new Exception("cannot open file '{$filePath->getAbsolute()}' for writing");
        }

        foreach($dependencyCollection->getMap() as $moduleName => $moduleDependencyCollection) {
            fputcsv($fh, $this->makeArrayWithOffset(0, $moduleName), $separator);
            foreach($moduleDependencyCollection->getMap() as $fileName => $moduleUsagesMap) {
                fputcsv($fh, $this->makeArrayWithOffset(1, $fileName), $separator);
                foreach($moduleUsagesMap as $depModuleName => $usages) {
                    fputcsv($fh, $this->makeArrayWithOffset(2, $depModuleName), $separator);
                    foreach($usages as $usage) {
                        fputcsv($fh, $this->makeArrayWithOffset(3, $usage), $separator);
                    }
                }
            }
        }
    }

    protected function makeArrayWithOffset(int $offset, string ...$values): array
    {
        $result = array_fill(0, $offset, '');
        return [...$result, ...$values];
    }
}