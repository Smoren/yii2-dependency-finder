<?php

namespace Smoren\Yii2\DependencyFinder\Interfaces;

interface PathInterface
{
    public function getRootDir(): string;
    public function getRelative(): string;
    public function getAbsolute(): string;
    public function isReadable(): bool;
    public function isDirectory(): bool;
    public function isFile(): bool;
    public function getInfo(): array;
    public function goDown(string $subPath): PathInterface;
    public function __toString(): string;
}