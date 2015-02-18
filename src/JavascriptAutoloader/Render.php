<?php

namespace MF\JavascriptAutoloader;

class Render
{
    const CLASS_NAME = __CLASS__;

    /** @var string */
    private $baseUrl;

    /** @var bool */
    private $cacheAllowed = true;

    /**
     * @param string $baseUrl
     * @param Helper $helper
     */
    public function __construct($baseUrl, Helper $helper)
    {
        $this->baseUrl = $helper->addDirSeparatorAtEnd($baseUrl, '/');
    }

    public function denyCache()
    {
        $this->cacheAllowed = false;
    }

    /** @param array $scripts */
    public function renderScripts(array $scripts)
    {
        foreach ($scripts as $scriptFileName) {
            $this->renderScript($scriptFileName);
        }
    }

    /** @param string $scriptFileName */
    public function renderScript($scriptFileName)
    {
        $scriptUrl = $this->baseUrl . $scriptFileName;

        if (!$this->cacheAllowed) {
            $scriptUrl .= '?t=' . time();
        }
        ?><script type="text/javascript" src="<?= $scriptUrl ?>"></script><?php

    }
}
