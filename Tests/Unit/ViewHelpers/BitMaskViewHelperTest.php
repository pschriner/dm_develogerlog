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

/**
 * Tests for BitMaskViewHelper
 *
 */
class BitMaskViewHelperTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    /**
     * @test
     */
    public function canInstanceViewHelper()
    {
        $instance = new BitMaskViewHelper();
    }
    
    /**
     * @test
     */
    public function renderCallWithNoArgumentsExpectsBitmask()
    {
        $closure = function () {
            return '';
        };
        $renderingContext = new \TYPO3\CMS\Fluid\Core\Rendering\RenderingContext();
        $map = BitMaskViewHelper::renderStatic(
            ['operator' => '&', 'mask' => NULL, 'value' => PHP_INT_MAX],
            $closure, $renderingContext
        );
        $this->assertEquals(log(PHP_INT_MAX, 2.0), count($map));
        
        $map = BitMaskViewHelper::renderStatic(
            ['operator' => '&', 'mask' => NULL, 'value' => 5],
            $closure, $renderingContext
        );
        $this->assertEquals([0 => 1, 1 => 4], $map);
        
        $map = BitMaskViewHelper::renderStatic(
            ['operator' => '&', 'mask' => [1,2,4,8], 'value' => 5],
            $closure, $renderingContext
        );
        $this->assertEquals([0 => 1, 1 => 4], $map);
        
        $map = BitMaskViewHelper::renderStatic(
            ['operator' => '|', 'mask' => [1 => 0, 2 => 0, 4 => 1, 8 => 0], 'value' => 5],
            $closure, $renderingContext
        );
        $this->assertEquals([0 => 0, 1 => 1], $map);
    }
}