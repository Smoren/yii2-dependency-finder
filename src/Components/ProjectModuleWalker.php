<?php

namespace Smoren\Yii2\DependencyFinder\Components;

use Smoren\Yii2\DependencyFinder\Structs\Module;
use Smoren\Yii2\DependencyFinder\Structs\Path;
use Generator;

class ProjectModuleWalker
{
    protected Path $projectDir;

    public function __construct(Path $projectDir)
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
