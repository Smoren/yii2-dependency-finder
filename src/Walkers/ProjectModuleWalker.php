<?php

namespace Smoren\Yii2\DependencyFinder\Walkers;

use Smoren\Yii2\DependencyFinder\Interfaces\PathInterface;
use Smoren\Yii2\DependencyFinder\Interfaces\WalkerInterface;
use Smoren\Yii2\DependencyFinder\Structs\Module;
use Smoren\Yii2\DependencyFinder\Structs\Path;
use Generator;

class ProjectModuleWalker implements WalkerInterface
{
    protected PathInterface $projectDir;

    public function __construct(PathInterface $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    /**
     * @return Generator<Module>
     */
    public function iterate(): Generator
    {
        $modulesDir = $this->projectDir->goDown('modules');
        if($dh = opendir($modulesDir->getAbsolute())) {
            while(($fileName = readdir($dh)) !== false) {
                if(in_array($fileName, ['.', '..'])) {
                    continue;
                }

                $filePath = new Path($this->projectDir->getRootDir(), "modules/{$fileName}");

                if($filePath->isDirectory()) {
                    yield new Module($filePath);
                }
            }
            closedir($dh);
        }
    }
}
