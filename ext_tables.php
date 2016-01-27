<?php
defined('TYPO3_MODE') or die();

$boot = function () {
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
            'iconIdentifier' => 'module-dmdeveloperlog',
            'labels' => 'LLL:EXT:dm_developerlog/Resources/Private/Language/locallang_mod.xlf',
        ]
    );
};
$boot();
unset($boot);
