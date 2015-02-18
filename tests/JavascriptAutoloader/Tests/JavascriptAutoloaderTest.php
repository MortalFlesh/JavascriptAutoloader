<?php

namespace MF\JavascriptAutoloader\Tests;

use MF\JavascriptAutoloader\Helper;
use MF\JavascriptAutoloader\JavascriptAutoloader;
use MF\JavascriptAutoloader\Render;

class JavascriptAutoloaderTest extends \PHPUnit_Framework_TestCase
{
    /** @var JavascriptAutoloader */
    private $javascriptAutoloader;

    private $scriptsDir = 'scripts';

    public function setUp()
    {
        $rootDir = __DIR__ . '/../../../';
        $baseUrl = '/';

        $helper = new Helper();

        $renderMock = $this->getMockBuilder(Render::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();

        $this->javascriptAutoloader = new JavascriptAutoloader($rootDir, $baseUrl, $helper, $renderMock);
    }

    public function testShouldAutoloadInReturn()
    {
        $this->markTestIncomplete();

        $return = $this->javascriptAutoloader
            ->addDirectory($this->scriptsDir)
            ->autoload();

        $this->assertEquals('X', $return);
    }
}
