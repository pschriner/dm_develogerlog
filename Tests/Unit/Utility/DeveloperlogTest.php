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
use TYPO3\CMS\Core\Configuration\ConfigurationManager;
use DieMedialen\DmDeveloperlog\Utility\Developerlog;

/**
 * Tests for Developerlog
 *
 */
class DeveloperlogTest extends \Nimut\TestingFramework\TestCase\UnitTestCase
{
    /**
     * Create LocalConfiguration.php or export Configuration to $GLOBALS['TYPO3_CONF_VARS']
     */
    public static function setUpBeforeClass()
    {
        try {
            GeneralUtility::makeInstance(ConfigurationManager::class)->createLocalConfigurationFromFactoryConfiguration();
        } catch (\RuntimeException $rte) {
            if ($rte->getCode() !== 1364836026) { // pretty hacky: 1364836026 means LocalConfiguration.php was already there
                throw $rte;
            }
        }
        if (class_exists('TYPO3\CMS\\Core\\Configuration\\ExtensionConfiguration')) { // v9+            
            GeneralUtility::makeInstance('TYPO3\CMS\\Core\\Configuration\\ExtensionConfiguration')->synchronizeExtConfTemplateWithLocalConfigurationOfAllExtensions();
        } else {
            GeneralUtility::makeInstance(ConfigurationManager::class)->exportConfiguration();
        }
    }

    /**
     * @test
     */
    public function canInstanceDevlog()
    {
        $instance = new Developerlog();
        $this->assertNotNull($instance);
    }

    /**
     * @test
     */
    public function basicFunctionality()
    {
        $mock = $this->getAccessibleMock(Developerlog::class, ['createLogEntry']);
        $this->assertNull($mock->devLog(['severity' => -4]));
        $this->assertNull($mock->devLog(['extKey' => 'TEST']));
        $this->assertNull($mock->devLog(['severity' => 3]));
    }
}
