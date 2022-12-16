<?php

namespace Smoren\Yii2\DependencyFinder\Finders;

use Smoren\Yii2\DependencyFinder\Collections\ModuleDependencyCollection;
use Smoren\Yii2\DependencyFinder\Interfaces\FinderInterface;
use Smoren\Yii2\DependencyFinder\Interfaces\ModuleInterface;

class ModuleDependencyFinder implements FinderInterface
{
    protected ModuleInterface $module;

    public function __construct(ModuleInterface $module)
    {
        $this->module = $module;
    }

    public function find(): ModuleDependencyCollection
    {
        $result = [];

        foreach($this->module->iterateFiles() as $filePath) {
            $found = (new FileDependencyFinder($filePath, $this->module))->find();
            if(count($found)) {
                $result[$filePath->getRelative()] = $found;
            }
        }
        ksort($result);

        return new ModuleDependencyCollection($result);
    }
}
