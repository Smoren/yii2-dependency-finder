<?php

namespace Smoren\Yii2\DependencyFinder\Interfaces;

interface PathInterface
{
    /**
     * @return string
     */
    public function getRootDir(): string;

    /**
     * @return string
     */
    public function getRelative(): string;

    /**
     * @return string
     */
    public function getAbsolute(): string;

    /**
     * @return bool
     */
    public function isReadable(): bool;

    /**
     * @return bool
     */
    public function isDirectory(): bool;

    /**
     * @return bool
     */
    public function isFile(): bool;

    /**
     * @return array<string, string>
     */
    public function getInfo(): array;

    /**
     * @param string $subPath
     * @return PathInterface
     */
    public function goDown(string $subPath): PathInterface;

    /**
     * @return string
     */
    public function __toString(): string;
}