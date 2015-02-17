<?php

namespace MF\JavascriptAutoloader;

use DirectoryIterator;

class JavascriptAutoloader {

	const EXTENSION = '.js';

	/** @var Helper */
	private $helper;

	/** @var Compiler */
	private $compiler;

	/** @var Minifier */
	private $minifier;

	/** @var Render */
	private $render;

	private $rootDir;

	/** @var DirInfo[] */
	private $directories = array();

	/** @var array */
	private $scripts = array();

	/** @var bool */
	private $cacheAllowed = true;

	/**
	 * @param string $rootDir Project root dir (full path from root)
	 * @param string $baseUrl Project base URL
	 */
	public function __construct($rootDir, $baseUrl) {
		$this->helper = new Helper();

		$this->rootDir = $this->helper->addDirSeparatorAtEnd($rootDir);
		$this->render = new Render($baseUrl);
	}

	/** @return JavascriptAutoloader */
	public function denyCache() {
		$this->cacheAllowed = false;
		return $this;
	}

	/**
	 * @param string $cacheDirPath
	 * @return JavascriptAutoloader
	 */
	public function compileToOneFile($cacheDirPath) {
		return $this->setCompileToOneFile(new Compiler($this->rootDir, $cacheDirPath));
	}

	/**
	 * @param Compiler $Compiler
	 * @return JavascriptAutoloader
	 */
	public function setCompileToOneFile(Compiler $Compiler) {
		$this->compiler = $Compiler;
		return $this;
	}

	/** @return JavascriptAutoloader */
	public function minifyOutput() {
		return $this->setMinifyOutput(new Minifier($this->rootDir));
	}

	/**
	 * @param Minifier $Minify
	 * @return JavascriptAutoloader
	 */
	public function setMinifyOutput(Minifier $Minify) {
		$this->minifier = $Minify;
		return $this;
	}

	/**
	 * @param string $directory path from root
	 * @param bool $recursively
	 * @return JavascriptAutoloader
	 */
	public function addDirectory($directory, $recursively = false) {
		$dir = $this->rootDir . $this->helper->removeDirSeparatorFromBeginning($directory);
		$this->directories[] = new DirInfo($dir, $recursively);
		return $this;
	}

	/**
	 * @param bool $inReturn
	 * @return null|string
	 */
	public function autoload($inReturn = false) {
		$this->autoloadDirectories();

		if (!$this->cacheAllowed) {
			$this->render->denyCache();
		}

		if ($inReturn) {
			ob_start();
		}
		if (isset($this->compiler)) {
			$compiledScript = $this->getCompiledScript();
			$this->render->renderScript($compiledScript);
		} else {
			$this->render->renderScripts($this->scripts);
		}
		if ($inReturn) {
			return ob_get_clean();
		}
	}

	private function autoloadDirectories() {
		foreach($this->directories as $JADirInfo) {
			$this->autoloadDirectory($JADirInfo);
		}
	}

	/** @param DirInfo $dirInfo */
	private function autoloadDirectory(DirInfo $dirInfo) {
		foreach(new DirectoryIterator($dirInfo->getDirName()) as $fileInfo) {
			if ($fileInfo->isDot() || ($fileInfo->isDir() && !$dirInfo->isRecursive())) {
				continue;
			} elseif ($fileInfo->isDir() && $dirInfo->isRecursive()) {
				$this->autoloadDirectory(new DirInfo($fileInfo->getPathname(), true));
			}

			$scriptPathName = $dirInfo->getDirName() . DIRECTORY_SEPARATOR . $fileInfo->getFilename();
			$scriptFileName = str_replace(array($this->rootDir, '\\'), array('', DIRECTORY_SEPARATOR), $scriptPathName);

			$this->autoloadScript($scriptFileName);
		}
	}

	/** @param string $scriptFileName */
	private function autoloadScript($scriptFileName) {
		if ($this->helper->endsWith($scriptFileName, self::EXTENSION)) {
			$this->scripts[] = $scriptFileName;
		}
	}

	/** @return string */
	private function getCompiledScript() {
		if (isset($this->minifier)) {
			$this->compiler->setMinifier($this->minifier);
		}
		if (!$this->cacheAllowed) {
			$this->compiler->denyCache();
		}

		return $this->compiler
			->setScripts($this->scripts)
			->compileToOneFile()
			->getCompiledScriptPath();
	}
}