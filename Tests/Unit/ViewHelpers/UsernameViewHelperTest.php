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
use DieMedialen\DmDeveloperlog\ViewHelpers\TYPO3Fluid\UsernameViewHelper;

/**
 * Tests for UsernameViewHelper
 *
 */
class UsernameViewHelperTest extends \Nimut\TestingFramework\TestCase\ViewHelperBaseTestcase
{
    /**
     * @test
     */
    public function createInstance()
    {
        $instance = new UsernameViewHelper();
        $this->assertNotNull($instance);
    }
}
