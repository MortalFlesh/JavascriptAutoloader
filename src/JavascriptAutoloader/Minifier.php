<?php

namespace MF\JavascriptAutoloader;

use JShrink\Minifier as JShrinkMinifier;

class Minifier
{
    /** @var string */
    private $rootDir;

    /** @param string $rootDir */
    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    /**
     * @param string $scriptContents
     * @return string
     */
    public function minify($scriptContents)
    {
		return JShrinkMinifier::minify($scriptContents);
    }
}
