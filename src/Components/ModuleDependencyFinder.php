<?php

namespace Smoren\Yii2\DependencyFinder\Components;

use Smoren\Yii2\DependencyFinder\Collections\ModuleDependencyCollection;
use Smoren\Yii2\DependencyFinder\Structs\Module;

class ModuleDependencyFinder
{
    protected Module $module;

    public function __construct(Module $module)
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
