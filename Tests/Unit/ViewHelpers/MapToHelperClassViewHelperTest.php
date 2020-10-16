<?php
namespace DieMedialen\DmDeveloperlog\Tests\Unit\ViewHelpers;

/**
 * This file is part of the dm_developerlog project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use DieMedialen\DmDeveloperlog\ViewHelpers\TYPO3Fluid\MapToHelperClassViewHelper;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContext;

/**
 * Tests for MapToHelperClassViewHelper
 */
class MapToHelperClassViewHelperTest extends \Nimut\TestingFramework\TestCase\ViewHelperBaseTestcase
{
    private $_closure;
    private $_renderingContext;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->_closure = function () {
            return '';
        };
        $this->_renderingContext = $this->getMockBuilder(RenderingContext::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * @test
     */
    public function createInstance()
    {
        $instance = new MapToHelperClassViewHelper();
        $this->assertNotNull($instance);
    }

    /**
     * @test
     */
    public function renderCallWithMissingParameters()
    {
        $className = MapToHelperClassViewHelper::renderStatic(
            [],
            $this->_closure,
            $this->_renderingContext
        );
        $this->assertEquals('info', $className);

        $className = MapToHelperClassViewHelper::renderStatic(
            ['severity' => -2],
            $this->_closure,
            $this->_renderingContext
        );
        $this->assertEquals('info', $className);
    }

    /**
     * @test
     */
    public function renderCallWithRegularParameters()
    {
        $className = MapToHelperClassViewHelper::renderStatic(
            ['severity' => -1],
            $this->_closure,
            $this->_renderingContext
        );
        $this->assertEquals('success', $className);

        $className = MapToHelperClassViewHelper::renderStatic(
            ['severity' => 3],
            $this->_closure,
            $this->_renderingContext
        );
        $this->assertEquals('danger', $className);
    }

    /**
     * @test
     */
    public function renderCallDoesntCrashOnInvalidChildClosure()
    {
        $closure = function () {
            throw new \Exception('Dummy Exception');
        };
        $className = MapToHelperClassViewHelper::renderStatic(
            [],
            $this->_closure,
            $this->_renderingContext
        );
        $this->assertEquals('info', $className);
    }
}
