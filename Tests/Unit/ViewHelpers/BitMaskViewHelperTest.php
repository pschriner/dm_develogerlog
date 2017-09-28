<?php
namespace DieMedialen\DmDeveloperlog\Tests\Unit\ViewHelpers;

/**
 * This file is part of the TYPO3 CMS project.
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
use DieMedialen\DmDeveloperlog\ViewHelpers\BitMaskViewHelper;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContext;

/**
 * Tests for BitMaskViewHelper
 *
 */
class BitMaskViewHelperTest extends \Nimut\TestingFramework\TestCase\ViewHelperBaseTestcase
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
        $instance = new BitMaskViewHelper();
        $this->assertNotNull($instance);
    }

    /**
     * @test
     */
    public function renderCallWitMissingParameters()
    {
        $map = BitMaskViewHelper::renderStatic(
            ['mask' => null, 'value' => PHP_INT_MAX],
            $this->_closure,
            $this->_renderingContext
        );
        $this->assertEquals(log(PHP_INT_MAX, 2.0), count($map));

        $map = BitMaskViewHelper::renderStatic(
            ['mask' => null, 'value' => 5],
            $this->_closure,
            $this->_renderingContext
        );
        $this->assertEquals([1, 4], $map);

        $map = BitMaskViewHelper::renderStatic(
            ['mask' => null, 'value' => null],
            $this->_closure,
            $this->_renderingContext
        );
        $this->assertEquals([], $map);
    }

    /**
     * @test
     */
    public function renderCallWithIrregularValues()
    {
        $map = BitMaskViewHelper::renderStatic(
            ['mask' => -5, 'value' => 5],
            $this->_closure,
            $this->_renderingContext
        );
        $this->assertEquals([], $map);

        $map = BitMaskViewHelper::renderStatic(
            ['mask' => 5, 'value' => -5],
            $this->_closure,
            $this->_renderingContext
        );
        $this->assertEquals([], $map);
    }

    /**
     * @test
     */
    public function regularRenderCalls()
    {
        $map = BitMaskViewHelper::renderStatic(
            ['mask' => [1, 8, 16], 'value' => 13],
            $this->_closure,
            $this->_renderingContext
        );
        $this->assertEquals([1, 8], $map);

        $map = BitMaskViewHelper::renderStatic(
            ['mask' => null, 'value' => 1213],
            $this->_closure,
            $this->_renderingContext
        );
        $this->assertEquals([1, 4, 8, 16, 32, 128, 1024], $map);

        $map = BitMaskViewHelper::renderStatic(
            ['mask' => null, 'value' => 25],
            $this->_closure,
            $this->_renderingContext
        );
        $this->assertEquals([1, 8, 16], $map);
    }
}
