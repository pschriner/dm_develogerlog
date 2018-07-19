<?php
namespace DieMedialen\DmDeveloperlog\Tests\Unit\Utility;

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
use DieMedialen\DmDeveloperlog\Utility\Developerlog;

/**
 * Tests for Developerlog
 *
 */
class DeveloperlogTest extends \Nimut\TestingFramework\TestCase\UnitTestCase
{
    /**
     * @test
     */
    public function canInstanceDevlog()
    {
        $instance = new Developerlog();
    }

    /**
     * @test
     */
    public function basicFunctionality()
    {
        $old = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['dm_developerlog'];
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['dm_developerlog'] = serialize(['excludeKeys' => 'TEST']);
        $mock = $this->getAccessibleMock(Developerlog::class, ['createLogEntry']);
        $this->assertNull($mock->devLog(['severity' => -4]));
        $this->assertNull($mock->devLog(['extKey' => 'TEST']));

        $mock->expects($this->once())->method('createLogEntry')->will($this->returnValue(42));
        $this->assertNull($mock->devLog(['severity' => 3]));
    }
}
