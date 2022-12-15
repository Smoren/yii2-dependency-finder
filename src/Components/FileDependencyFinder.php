<?php

namespace Smoren\Yii2\DependencyFinder\Components;

use Smoren\Yii2\DependencyFinder\Structs\Module;
use Smoren\Yii2\DependencyFinder\Structs\Path;
use Smoren\NestedAccessor\Factories\SilentNestedAccessorFactory;

class FileDependencyFinder
{
    protected Path $path;
    protected Module $module;

    public function __construct(Path $path, Module $module)
    {
        $this->path = $path;
        $this->module = $module;
    }

    public function find(): array
    {
        $fileBody = file_get_contents($this->path->getAbsolute());
        preg_match_all('/app\\\modules\\\([^\\\;\n]+)[\\\A-Za-z0-9]*/', $fileBody, $matches);

        $result = [];
        $resultAccessor = SilentNestedAccessorFactory::fromArray($result);

        foreach($matches[1] as $index => $moduleName) {
            if($moduleName !== $this->module->getName()) {
                $resultAccessor->append($moduleName, $matches[0][$index]);
            }
        }
        foreach($result as $moduleName => $usages) {
            $result[$moduleName] = array_unique($usages);
        }

        return $result;
    }
}
