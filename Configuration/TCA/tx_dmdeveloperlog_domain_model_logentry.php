<?php
defined('TYPO3_MODE') or die();

return array(
    'ctrl' => [
        'title' => 'LLL:EXT:dm_developerlog/Resources/Private/Language/locallang_db.xml:logentry',
        'crdate' => 'crdate',
        'dividers2tabs' => true,
        'default_sortby' => 'ORDER BY crdate DESC',
        'label' => 'message'
    ],
    'columns' => [
        'be_user' => [
            'label' => 'LLL:EXT:dm_developerlog/Resources/Private/Language/locallang_db.xml:be_user',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'fe_user' => [
            'label' => 'LLL:EXT:dm_developerlog/Resources/Private/Language/locallang_db.xml:fe_user',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'pid' => [
            'label' => 'LLL:EXT:dm_developerlog/Resources/Private/Language/locallang_db.xml:pid',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'crdate' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:dm_developerlog/Resources/Private/Language/locallang_db.xml:crdate',
            'config' => [
                'type' => 'input',
                'size' => 12,
                'max' => 20,
                'eval' => 'datetime',
            ]
        ],
         'request_id' => [
            'label' => 'LLL:EXT:dm_developerlog/Resources/Private/Language/locallang_db.xml:request_id',
            'config' => [
                'type' => 'input',
                'size' => 10,
            ]
        ],
         'request_type' => [
            'label' => 'LLL:EXT:dm_developerlog/Resources/Private/Language/locallang_db.xml:request_type',
            'config' => [
                'type' => 'input',
                'size' => 10,
            ]
        ],
        'extkey' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:dm_developerlog/Resources/Private/Language/locallang_db.xml:extkey',
            'config' => [
                'type' => 'input',
                'size' => 50,
            ]
        ],
        'location' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:dm_developerlog/Resources/Private/Language/locallang_db.xml:location',
            'config' => [
                'type' => 'input',
                'size' => 50,
            ]
        ],
        'line' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:dm_developerlog/Resources/Private/Language/locallang_db.xml:line',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'numeric'
            ]
        ],
        'system' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:dm_developerlog/Resources/Private/Language/locallang_db.xml:system',
            'config' => [
                'type' => 'check',
            ]
        ],
        'message' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:dm_developerlog/Resources/Private/Language/locallang_db.xml:message',
            'config' => [
                'type' => 'text',
            ]
        ],
        'data_var' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:dm_developerlog/Resources/Private/Language/locallang_db.xml:data_var',
            'config' => [
                'type' => 'text',
                'cols' => 50,
                'rows' => 40,
            ]
        ],
        'severity' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:dm_developerlog/Resources/Private/Language/locallang_db.xml:severity',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Ok', -1],
                    ['Information', 0],
                    ['Warning', 1],
                    ['Fatal Error', 2]                    
                ],
                'renderType' => 'selectSingle',
            ]
        ],
    ],
    'types' => [
		'0' => ['showitem' => '--palette--;;basic, --palette--;;source, message, data_var, --palette--;;request']
	],
    'palettes' => [
        'basic' => ['showitem' => 'crdate, severity'],
        'request' => ['showitem' => 'system, --linebreak--, request_id, request_type'],
        'source' => ['showitem' => 'extkey, --linebreak--, location, line']
    ],
);