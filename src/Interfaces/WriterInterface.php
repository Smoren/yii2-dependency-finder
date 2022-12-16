<?php

namespace Smoren\Yii2\DependencyFinder\Interfaces;

use Smoren\Yii2\DependencyFinder\Collections\ProjectDependencyCollection;

interface WriterInterface
{
    /**
     * @param ProjectDependencyCollection $dependencyCollection
     * @return void
     */
    public function write(ProjectDependencyCollection $dependencyCollection): void;
}