<?php

namespace Smoren\Yii2\DependencyFinder\Interfaces;

use Generator;

interface ModuleInterface
{
    /**
     * @return Generator
     */
    public function iterateFiles(): Generator;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return PathInterface
     */
    public function getPath(): PathInterface;
}
