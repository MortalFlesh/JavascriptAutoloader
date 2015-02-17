<?php

namespace MF\JavascriptAutoloader;

class Helper {

	const ENCODING = 'utf-8';

	/**
	 * @param string $dir
	 * @param string $separator
	 * @return string
	 */
	public function addDirSeparatorAtEnd($dir, $separator = DIRECTORY_SEPARATOR) {
		if (!$this->endsWith($dir, $separator)) {
			return $dir . $separator;
		}
		return $dir;
	}

	/**
	 * @param string $dir
	 * @return string
	 */
	public function removeDirSeparatorFromBeginning($dir) {
		if (mb_substr($dir, 0, 1, self::ENCODING) === DIRECTORY_SEPARATOR) {
			return mb_substr($dir, 1, mb_strlen($dir, self::ENCODING), self::ENCODING);
		}
		return $dir;
	}

	/**
	 * @param string $string
	 * @param string $suffix
	 * @return bool
	 */
	public function endsWith($string, $suffix) {
		$suffixLength = mb_strlen($suffix, self::ENCODING);
		return (mb_substr($string, -$suffixLength, $suffixLength, self::ENCODING) === $suffix);
	}
}
