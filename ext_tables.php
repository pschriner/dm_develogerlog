<?php
defined('TYPO3_MODE') or die();

$boot = function ($extension) {
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon('module-dmdeveloperlog', \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class, ['name' => 'ambulance']);
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'DieMedialen.dm_developerlog',
        'system',
        'dm_developerlog',
        'after:BelogLog',
        ['Devlog' => 'index,flush'],
        [
            'access' => 'admin',
            'icon' => '',
            'iconIdentifier' => 'module-dmdeveloperlog',
            'labels' => 'LLL:EXT:' . $extension . '/Resources/Private/Language/locallang_mod.xlf',
            'cssFiles' => ['EXT:' . $extension . '/Resources/Public/Css/Backend.css'],
        ]
    );
};
$boot('dm_developerlog');
unset($boot);
