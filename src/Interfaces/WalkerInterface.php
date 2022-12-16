<?php

namespace Smoren\Yii2\DependencyFinder\Interfaces;

use Generator;

interface WalkerInterface
{
    public function iterate(): Generator;
}