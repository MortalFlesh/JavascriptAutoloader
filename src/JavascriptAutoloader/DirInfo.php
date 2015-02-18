<?php

namespace MF\JavascriptAutoloader;

class DirInfo
{
    const CLASS_NAME = __CLASS__;

    /** @var string */
    private $dirName;

    /** @var bool */
    private $recursively;

    /**
     * @param string $dirName
     * @param bool $recursively
     */
    public function __construct($dirName, $recursively)
    {
        $this->dirName = $dirName;
        $this->recursively = ($recursively === true);
    }

    /** @return string */
    public function getDirName()
    {
        return $this->dirName;
    }

    /** @return bool */
    public function isRecursive()
    {
        return $this->recursively;
    }
}
