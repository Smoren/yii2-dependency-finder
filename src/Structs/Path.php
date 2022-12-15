<?php

namespace Smoren\Yii2\DependencyFinder\Structs;

class Path
{
    protected string $rootDirPath;
    protected string $relativePath;

    public function __construct(string $rootDirPath, string $relativePath = '')
    {
        $this->rootDirPath = $rootDirPath;
        $this->relativePath = $relativePath;
    }

    /**
     * @return string
     */
    public function getRootDir(): string
    {
        return $this->rootDirPath;
    }

    /**
     * @return string
     */
    public function getRelative(): string
    {
        return $this->relativePath;
    }

    /**
     * @return string
     */
    public function getAbsolute(): string
    {
        return $this->appendToPathString($this->rootDirPath, $this->relativePath);
    }

    /**
     * @return bool
     */
    public function isReadable(): bool
    {
        return is_readable($this->getAbsolute());
    }

    /**
     * @return bool
     */
    public function isDirectory(): bool
    {
        return is_dir($this->getAbsolute());
    }

    /**
     * @return bool
     */
    public function isFile(): bool
    {
        return is_file($this->getAbsolute());
    }

    /**
     * @return array<string, string>
     */
    public function getInfo(): array
    {
        return pathinfo($this->getAbsolute());
    }

    /**
     * @param string $subPath
     * @return Path
     */
    public function goDown(string $subPath): Path
    {
        return new self($this->rootDirPath, $this->appendToPathString($this->getRelative(), $subPath));
    }

    /**
     * @return string
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
