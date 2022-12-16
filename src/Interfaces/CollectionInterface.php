<?php

namespace Smoren\Yii2\DependencyFinder\Interfaces;

use Generator;

interface CollectionInterface
{
    public function getSummary(): array;
    public function iterate(int $keyOffset = 0): Generator;
    public function isEmpty(): bool;
    public function getMap(): array;
}