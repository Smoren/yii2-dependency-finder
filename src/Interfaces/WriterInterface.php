<?php

namespace Smoren\Yii2\DependencyFinder\Interfaces;

use Smoren\Yii2\DependencyFinder\Collections\ProjectDependencyCollection;
use Smoren\Yii2\DependencyFinder\Structs\Path;

interface WriterInterface
{
    public function write(ProjectDependencyCollection $dependencyCollection): void;
}