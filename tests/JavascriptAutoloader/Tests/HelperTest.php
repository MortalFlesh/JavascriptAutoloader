<?php

namespace MF\JavascriptAutoloader\Tests;

use MF\JavascriptAutoloader\Helper;

class HelperTest extends \PHPUnit_Framework_TestCase
{
    /** @var Helper */
    private $helper;

    public function setUp()
    {
        $this->helper = new Helper();
    }

    public function testShouldAddDirSeparatorAtTheEnd()
    {
        $this->markTestIncomplete();
    }

    public function testShouldRemoveDirSeparatorFromTheBeginning()
    {
        $this->markTestIncomplete();
    }

    /**
     * @param string $string
     * @param string $suffix
     * @param bool $expectedResult
     *
     * @dataProvider endsWithProvider
     */
    public function testShouldReturnBoolValueOnEndsWith($string, $suffix, $expectedResult)
    {
        $result = $this->helper->endsWith($string, $suffix);
        $this->assertEquals($expectedResult, $result);
    }

    public function endsWithProvider()
    {
        return array(
            'withSuffix' => array(
                'string' => 'testSuffix',
                'suffix' => 'Suffix',
                'expectedResult' => true,
            ),
            'withoutSuffix' => array(
                'string' => 'testWithout',
                'suffix' => 'Suffix',
                'expectedResult' => false,
            ),
            'emptyString' => array(
                'string' => '',
                'suffix' => 'Suffix',
                'expectedResult' => false,
            ),
            'emptySuffix' => array(
                'string' => 'string',
                'suffix' => '',
                'expectedResult' => true,
            ),
        );
    }
}
