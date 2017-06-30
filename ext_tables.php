<?php
defined('TYPO3_MODE') or die();

if (TYPO3_MODE === 'BE') {
    if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_branch) >= 7006000) {
        $boot = function ($extension) {
            $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Imaging\\IconRegistry');
            $iconRegistry->registerIcon('module-dmdeveloperlog', \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class, array('name' => 'ambulance'));
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'DieMedialen.dm_developerlog',
                'system',
                'dm_developerlog',
                'after:BelogLog',
                ['Devlog' => 'index,flush'],
                [
                    'access' => 'admin',
                    'icon'   => \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_branch) > 8000000 ? '' : 'EXT:' . $extension . '/ext_icon.png',
                    'iconIdentifier' => 'module-dmdeveloperlog',
                    'labels' => 'LLL:EXT:' . $extension .'/Resources/Private/Language/locallang_mod.xlf',
                    'cssFiles' => ['EXT:'. $extension .'/Resources/Public/Css/Backend.css']
                ]
            );
        };
        $boot($_EXTKEY);
        unset($boot);
    } else { // 6.2
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'DieMedialen.' . $_EXTKEY,
            'system',	 // Make module a submodule of 'web'
            'dm_developerlog',	// Submodule key
            'after:BelogLog',						// Position
            ['Devlog62' => 'index,flush'],
            [
                'access' => 'admin',
                'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.png',
                'labels' => 'LLL:EXT:dm_developerlog/Resources/Private/Language/locallang_mod.xlf',
                'cssFiles' => ['EXT:dm_developerlog/Resources/Public/Css/Backend.css']
            ]
        );
    }
}
