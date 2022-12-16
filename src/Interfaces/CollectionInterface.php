<?php

namespace Smoren\Yii2\DependencyFinder\Interfaces;

use Generator;

interface CollectionInterface
{
    /**
     * @return array
     */
    public function getSummary(): array;

    /**
     * @param int $keyOffset
     * @return Generator
     */
    public function iterate(int $keyOffset = 0): Generator;

    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @return array<string, array>
     */
    public function getMap(): array;
}