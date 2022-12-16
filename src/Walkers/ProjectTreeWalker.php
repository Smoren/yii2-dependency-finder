<?php

namespace Smoren\Yii2\DependencyFinder\Walkers;

use Smoren\Yii2\DependencyFinder\Interfaces\PathInterface;
use Smoren\Yii2\DependencyFinder\Interfaces\WalkerInterface;
use Smoren\Yii2\DependencyFinder\Structs\Path;
use Generator;

class ProjectTreeWalker implements WalkerInterface
{
    /**
     * @var PathInterface|Path
     */
    protected PathInterface $rootDirPath;
    /**
     * @var array|null
     */
    protected ?array $extensions;
    /**
     * @var bool|mixed
     */
    protected bool $onlyReadable;

    /**
     * @param string $rootDir
     * @param array|null $extensions
     * @param $onlyReadable
     */
    public function __construct(string $rootDir, ?array $extensions = [], $onlyReadable = false)
    {
        $this->rootDirPath = new Path($rootDir, '');
        $this->extensions = $extensions;
        $this->onlyReadable = $onlyReadable;
    }

    /**
     * [@inheritDoc]
     * @return Generator<string, string>
     */
    public function iterate(): Generator
    {
        yield from $this->_iterate($this->rootDirPath);
    }

    /**
     * @param PathInterface $dirPath
     * @return Generator<PathInterface>
     */
    protected function _iterate(PathInterface $dirPath): Generator
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