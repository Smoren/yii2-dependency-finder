<?php

namespace Smoren\Yii2\DependencyFinder\Writers;

use Smoren\Yii2\DependencyFinder\Collections\ProjectDependencyCollection;

class CsvWriter extends BaseFileWriter
{
    public function write(ProjectDependencyCollection $dependencyCollection): void
    {
        foreach($dependencyCollection->iterate() as $depth => $value) {
            fputcsv($this->fh, $this->makeArrayWithOffset($depth, $value), ';');
        }
    }

    protected function makeArrayWithOffset(int $offset, string ...$values): array
    {
        $result = array_fill(0, $offset, '');
        return [...$result, ...$values];
    }
}
