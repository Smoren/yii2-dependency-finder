<?php

namespace Smoren\Yii2\DependencyFinder\Interfaces;

use Generator;

interface WalkerInterface
{
    /**
     * @return Generator
     */
    public function iterate(): Generator;
}