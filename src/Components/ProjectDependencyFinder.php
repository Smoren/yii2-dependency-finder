<?php

namespace Smoren\Yii2\DependencyFinder\Components;

use Smoren\Yii2\DependencyFinder\Collections\ProjectDependencyCollection;
use Smoren\Yii2\DependencyFinder\Structs\Path;

class ProjectDependencyFinder
{
    protected Path $projectPath;

    public function __construct(Path $projectPath)
    {
        $this->projectPath = $projectPath;
    }

    public function find(): ProjectDependencyCollection
    {
        $result = [];

        $moduleWalker = new ProjectModuleWalker($this->projectPath);
        foreach($moduleWalker->iterate() as $module) {
            $dependencyFinder = new ModuleDependencyFinder($module);
            $dependencyCollection = $dependencyFinder->find();

            if(!$dependencyCollection->isEmpty()) {
                $result[$module->getName()] = $dependencyCollection;
            }
        }

        return new ProjectDependencyCollection($result);
    }
}
