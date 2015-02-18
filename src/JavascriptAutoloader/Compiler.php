<?php

namespace MF\JavascriptAutoloader;

use MF\JavascriptAutoloader\Exceptions\CompilerCacheDirNotFoundException;

class Compiler
{
    const SCRIPT_NAME = 'script';
    const MINIFIED_SUFFIX = '-min';
    const SCRIPTS_DELIMETER = ';';

    /** @var Minifier */
    private $Minifier;

    private $rootDir, $cacheFolderPath;
    private $scripts = array();
    private $compiledScriptName = '';
    private $cacheAllowed = true;

    /**
     * @param string $rootDir
     * @param string $cacheFolderPath
     */
    public function __construct($rootDir, $cacheFolderPath)
    {
        $this->rootDir = $rootDir;
        $cacheFolderPath = str_replace(array($this->rootDir, '\\'), array('', '/'), $cacheFolderPath);

        $helper = new Helper();
        $this->cacheFolderPath = $helper->addDirSeparatorAtEnd($cacheFolderPath, '/');

        if (empty($this->cacheFolderPath) || !file_exists($this->rootDir . $this->cacheFolderPath)) {
            throw new CompilerCacheDirNotFoundException($this->cacheFolderPath);
        }
    }

    /**
     * @param array $scripts
     * @return Compiler
     */
    public function setScripts(array $scripts)
    {
        $this->scripts = $scripts;
        return $this;
    }

    public function denyCache()
    {
        $this->cacheAllowed = false;
    }

    /**
     * @param Minifier $Minifier
     * @return Compiler
     */
    public function setMinifier(Minifier $Minifier)
    {
        $this->Minifier = $Minifier;
        return $this;
    }

    /** @return Compiler */
    public function compileToOneFile()
    {
        $this->generateScriptName();

        if (!$this->cacheAllowed || !$this->compiledFileExists()) {
            $this->compileScripts();
        }

        return $this;
    }

    /** @return Compiler */
    private function generateScriptName()
    {
        $this->compiledScriptName = self::SCRIPT_NAME;

        if (isset($this->Minifier)) {
            $this->compiledScriptName .= self::MINIFIED_SUFFIX;
        }
        return $this;
    }

    /** @return bool */
    private function compiledFileExists()
    {
        $scripFile = $this->getScriptFullPath();
        return file_exists($scripFile);
    }

    /** @return string */
    private function getScriptFullPath()
    {
        return $this->rootDir . $this->getCompiledScriptPath();
    }

    /** @return string */
    public function getCompiledScriptPath()
    {
        return $this->cacheFolderPath . $this->compiledScriptName . JavascriptAutoloader::EXTENSION;
    }

    /** @return Compiler */
    private function compileScripts()
    {
        $scriptContents = '';
        foreach ($this->scripts as $script) {
            $scriptContents .= file_get_contents($this->rootDir . $script) . self::SCRIPTS_DELIMETER;
        }

        if (isset($this->Minifier)) {
            $scriptContents = $this->Minifier->minify($scriptContents);
        }

        $scriptFile = $this->getScriptFullPath();
        file_put_contents($scriptFile, $scriptContents);

        return $this;
    }
}
