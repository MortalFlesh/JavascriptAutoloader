<?php

namespace MF\JavascriptAutoloader;

class Minifier {

	/** @var string */
	private $rootDir;

	/** @param string $rootDir */
	public function __construct($rootDir) {
		$this->rootDir = $rootDir;
	}

	/**
	 * @param string $scriptContents
	 * @return string
	 */
	public function minify($scriptContents) {
		return JSMin::minify($scriptContents);
	}
}
