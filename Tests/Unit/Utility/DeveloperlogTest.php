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
use TYPO3\CMS\Core\Utility\GeneralUtility;
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
        $this->setDummyExtensionConfiguration();
        $instance = new Developerlog();
        $this->assertNotNull($instance);
    }

    /**
     * @test
     */
    public function basicFunctionality()
    {
        $this->setDummyExtensionConfiguration();
        $mock = $this->getAccessibleMock(Developerlog::class, ['createLogEntry']);
        $this->assertNull($mock->devLog(['severity' => -4]));
        $this->assertNull($mock->devLog(['extKey' => 'TEST']));
        $this->assertNull($mock->devLog(['severity' => 3]));
    }

    protected function setDummyExtensionConfiguration()
    {
        if (class_exists('TYPO3\CMS\\Core\\Configuration\\ExtensionConfiguration')) { // v9+
            GeneralUtility::makeInstance('TYPO3\CMS\\Core\\Configuration\\ConfigurationManager')->createLocalConfigurationFromFactoryConfiguration();
            GeneralUtility::makeInstance('TYPO3\CMS\\Core\\Configuration\\ExtensionConfiguration')->synchronizeExtConfTemplateWithLocalConfigurationOfAllExtensions();
        } else {
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['dm_developerlog'] = serialize(['excludeKeys' => 'TEST']);
        }
    }
}
