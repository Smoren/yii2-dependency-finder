<?php

namespace Smoren\Yii2\DependencyFinder\Finders;

use Smoren\Yii2\DependencyFinder\Collections\ProjectDependencyCollection;
use Smoren\Yii2\DependencyFinder\Interfaces\FinderInterface;
use Smoren\Yii2\DependencyFinder\Interfaces\PathInterface;
use Smoren\Yii2\DependencyFinder\Walkers\ProjectModuleWalker;

class ProjectDependencyFinder implements FinderInterface
{
    protected PathInterface $projectPath;

    public function __construct(PathInterface $projectPath)
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
