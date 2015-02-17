<?php

namespace MF\JavascriptAutoloader;

class DirInfo {
	private $dirName;
	private $recursively;

	public function __construct($dirName, $recursively) {
		$this->dirName = $dirName;
		$this->recursively = ($recursively === true);
	}

	public function getDirName() {
		return $this->dirName;
	}

	public function isRecursive() {
		return $this->recursively;
	}
}
