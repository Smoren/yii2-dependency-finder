<?php

namespace Smoren\Yii2\DependencyFinder\Structs;

use Smoren\Yii2\DependencyFinder\Interfaces\PathInterface;

class Path implements PathInterface
{
    /**
     * @var string
     */
    protected string $rootDirPath;
    /**
     * @var string
     */
    protected string $relativePath;

    /**
     * @param string $rootDirPath
     * @param string $relativePath
     */
    public function __construct(string $rootDirPath, string $relativePath = '')
    {
        $this->rootDirPath = $rootDirPath;
        $this->relativePath = $relativePath;
    }

    /**
     * {@inheritDoc}
     */
    public function getRootDir(): string
    {
        return $this->rootDirPath;
    }

    /**
     * {@inheritDoc}
     */
    public function getRelative(): string
    {
        return $this->relativePath;
    }

    /**
     * {@inheritDoc}
     */
    public function getAbsolute(): string
    {
        return $this->appendToPathString($this->rootDirPath, $this->relativePath);
    }

    /**
     * {@inheritDoc}
     */
    public function isReadable(): bool
    {
        return is_readable($this->getAbsolute());
    }

    /**
     * {@inheritDoc}
     */
    public function isDirectory(): bool
    {
        return is_dir($this->getAbsolute());
    }

    /**
     * {@inheritDoc}
     */
    public function isFile(): bool
    {
        return is_file($this->getAbsolute());
    }

    /**
     * {@inheritDoc}
     */
    public function getInfo(): array
    {
        return pathinfo($this->getAbsolute());
    }

    /**
     * {@inheritDoc}
     */
    public function goDown(string $subPath): PathInterface
    {
        return new self($this->rootDirPath, $this->appendToPathString($this->getRelative(), $subPath));
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return $this->getAbsolute();
    }

    /**
     * @param string $path
     * @param string $subPath
     * @return string
     */
    protected function appendToPathString(string $path, string $subPath): string
    {
        if($path !== '' && $subPath !== '') {
            return "{$path}/{$subPath}";
        }

        if($subPath !== '') {
            return $subPath;
        }

        return $path;
    }
}
