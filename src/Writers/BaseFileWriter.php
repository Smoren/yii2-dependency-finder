<?php

namespace Smoren\Yii2\DependencyFinder\Writers;

use Smoren\Yii2\DependencyFinder\Interfaces\WriterInterface;
use Smoren\Yii2\DependencyFinder\Structs\Path;
use Exception;

abstract class BaseFileWriter implements WriterInterface
{
    /**
     * @var resource
     */
    protected $fh;

    /**
     * @param Path $filePath
     * @throws Exception
     */
    public function __construct(Path $filePath)
    {
        $this->fh = fopen($filePath->getAbsolute(), 'w');

        if(!$this->fh) {
            throw new Exception("cannot open file '{$filePath->getAbsolute()}' for writing");
        }
    }

    public function __destruct()
    {
        fclose($this->fh);
    }
}