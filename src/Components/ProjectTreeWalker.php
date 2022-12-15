<?php

namespace Smoren\Yii2\DependencyFinder\Components;

use Smoren\Yii2\DependencyFinder\Structs\Path;
use Generator;

class ProjectTreeWalker
{
    protected Path $rootDirPath;
    protected ?array $extensions;
    protected bool $onlyReadable;

    public function __construct(string $rootDir, ?array $extensions = [], $onlyReadable = false)
    {
        $this->rootDirPath = new Path($rootDir, '');
        $this->extensions = $extensions;
        $this->onlyReadable = $onlyReadable;
    }

    /**
     * @return Generator<string, string>
     */
    public function iterate(): Generator
    {
        yield from $this->_iterate($this->rootDirPath);
    }

    /**
     * @param Path $dirPath
     * @return Generator<Path>
     */
    protected function _iterate(Path $dirPath): Generator
    {
        if($dh = opendir($dirPath->getAbsolute())) {
            while(($fileName = readdir($dh)) !== false) {
                if(in_array($fileName, ['.', '..'])) {
                    continue;
                }

                $filePath = $dirPath->goDown($fileName);

                if($filePath->isDirectory()) {
                    if($filePath->isReadable()) {
                        yield from $this->_iterate($filePath);
                    }
                } else {
                    ['extension' => $extension] = $filePath->getInfo();

                    if($this->extensions === null || in_array($extension, $this->extensions)) {
                        yield $filePath;
                    }
                }
            }
            closedir($dh);
        }
    }
}