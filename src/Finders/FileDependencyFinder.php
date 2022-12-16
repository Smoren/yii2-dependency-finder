<?php

namespace Smoren\Yii2\DependencyFinder\Finders;

use Smoren\NestedAccessor\Factories\SilentNestedAccessorFactory;
use Smoren\Yii2\DependencyFinder\Interfaces\FinderInterface;
use Smoren\Yii2\DependencyFinder\Interfaces\ModuleInterface;
use Smoren\Yii2\DependencyFinder\Interfaces\PathInterface;

class FileDependencyFinder implements FinderInterface
{
    protected PathInterface $path;
    protected ModuleInterface $module;

    public function __construct(PathInterface $path, ModuleInterface $module)
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
            $usages = array_unique($usages);
            sort($usages);
            $result[$moduleName] = $usages;
        }

        ksort($result);
        return $result;
    }
}
