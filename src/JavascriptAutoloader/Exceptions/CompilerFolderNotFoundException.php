<?php

namespace MF\JavascriptAutoloader\Exceptions;

use Exception;

class CompilerFolderNotFoundException extends JavascriptAutoloaderException
{
    /**
     * @param string $dirName
     * @param Exception $Previous
     */
    public function __construct($dirName, Exception $Previous = null)
    {
        parent::__construct(sprintf('Cache folder (%s) not found!', $dirName), 0, $Previous);
    }
}
