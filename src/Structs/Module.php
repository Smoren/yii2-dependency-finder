<?php

namespace Smoren\Yii2\DependencyFinder\Structs;

use Generator;
use Smoren\Yii2\DependencyFinder\Interfaces\ModuleInterface;
use Smoren\Yii2\DependencyFinder\Interfaces\PathInterface;
use Smoren\Yii2\DependencyFinder\Walkers\ProjectTreeWalker;

class Module implements ModuleInterface
{
    /**
     * @var PathInterface
     */
    protected PathInterface $path;
    /**
     * @var string
     */
    protected string $name;

    /**
     * @param PathInterface $path
     */
    public function __construct(PathInterface $path)
    {
        $this->path = $path;

        preg_match('#[^/]+$#', $this->path->getAbsolute(), $matches);
        $this->name = $matches[0];
    }

    /**
     * {@inheritDoc}
     * @return Generator<PathInterface>
     */
    public function iterateFiles(): Generator
    {
        $walker = new ProjectTreeWalker($this->getPath()->getAbsolute(), ['php'], false);
        yield from $walker->iterate();
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getPath(): PathInterface
    {
        return $this->path;
    }
}