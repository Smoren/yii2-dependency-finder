<?php

namespace Smoren\Yii2\DependencyFinder\Writers;

use Smoren\Yii2\DependencyFinder\Collections\ProjectDependencyCollection;

class ShortTxtWriter extends BaseFileWriter
{
    /**
     * {@inheritDoc}
     */
    public function write(ProjectDependencyCollection $dependencyCollection): void
    {
        foreach($dependencyCollection->getMap() as $moduleName => $moduleDependencyCollection) {
            fputs($this->fh, "{$moduleName}:\n");
            foreach($moduleDependencyCollection->getModuleNames() as $moduleName) {
                fputs($this->fh, "\t{$moduleName}\n");
            }
        }
    }
}