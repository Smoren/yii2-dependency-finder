<?php

namespace Smoren\Yii2\DependencyFinder\Interfaces;

use Generator;

interface ModuleInterface
{
    public function iterateFiles(): Generator;
    public function getName(): string;
    public function getPath(): PathInterface;
}
