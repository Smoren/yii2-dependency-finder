<?php

namespace Smoren\Yii2\DependencyFinder\Structs;

use Smoren\Yii2\DependencyFinder\Components\ProjectTreeWalker;
use Generator;

class Module
{
    protected Path $path;
    protected string $name;

    public function __construct(Path $path)
    {
        $this->path = $path;

        preg_match('#[^/]+$#', $this->path->getAbsolute(), $matches);
        $this->name = $matches[0];
    }

    /**
     * @return Generator<Path>
     */
    public function iterateFiles(): Generator
    {
        $walker = new ProjectTreeWalker($this->getPath()->getAbsolute(), ['php'], false);
        yield from $walker->iterate();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): Path
    {
        return $this->path;
    }
}