<?php

namespace Smoren\Yii2\DependencyFinder\Interfaces;

use Smoren\Yii2\DependencyFinder\Collections\ProjectDependencyCollection;

interface WriterInterface
{
    public function write(ProjectDependencyCollection $dependencyCollection): void;
}