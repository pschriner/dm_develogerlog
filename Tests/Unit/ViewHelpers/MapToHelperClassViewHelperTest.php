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
use DieMedialen\DmDeveloperlog\ViewHelpers\MapToHelperClassViewHelper;

/**
 * Tests for MapToHelperClassViewHelper
 *
 */
class MapToHelperClassViewHelperTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    static $closure;
    static $renderingContext;

    public static function setUpBeforeClass()
    {
        self::$closure = function () {
            return '42';
        };
        self::$renderingContext = new \TYPO3\CMS\Fluid\Core\Rendering\RenderingContext();
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
            self::$closure, self::$renderingContext
        );
        $this->assertEquals('info', $className);

        $className = MapToHelperClassViewHelper::renderStatic(
            ['severity' => -2],
            self::$closure, self::$renderingContext
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
            self::$closure, self::$renderingContext
        );
        $this->assertEquals('success', $className);

        $className = MapToHelperClassViewHelper::renderStatic(
            ['severity' => 3],
            self::$closure, self::$renderingContext
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
            $closure, self::$renderingContext
        );
        $this->assertEquals('info', $className);
    }
}