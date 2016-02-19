<?php
defined('TYPO3_MODE') or die();

return array(
    'ctrl' => [
        'title' => 'Logentry',
        'crdate' => 'crdate',
        'dividers2tabs' => true,
        'default_sortby' => 'ORDER BY crdate DESC',
        'label' => 'message'
    ],
    'columns' => [
        'be_user' => [
            'label' => 'be_user',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'fe_user' => [
            'label' => 'fe_user',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'pid' => [
            'label' => 'pid',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'crdate' => [
            'exclude' => 0,
            'label' => 'Crdate',
            'config' => [
                'type' => 'input',
                'size' => 12,
                'max' => 20,
                'eval' => 'datetime',
                'readOnly' => 1
            ]
        ],
         'request_id' => [
            'label' => 'Request ID',
            'config' => [
                'type' => 'input',
                'size' => 255,
                'readOnly' => 1,
            ]
        ],
         'request_type' => [
            'label' => 'Request Type',
            'config' => [
                'type' => 'input',
                'size' => 255,
                'readOnly' => 1,
            ]
        ],
        'extkey' => [
            'exclude' => 0,
            'label' => 'Extension (reported)',
            'config' => [
                'type' => 'input',
                'size' => 255,
                'readOnly' => 1,
            ]
        ],
        'location' => [
            'exclude' => 0,
            'label' => 'Location',
            'config' => [
                'type' => 'input',
                'size' => 255,
                'readOnly' => 1,
            ]
        ],
        'line' => [
            'exclude' => 0,
            'label' => 'Line',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'readOnly' => 1,
                'eval' => 'numeric'
            ]
        ],
        'system' => [
            'exclude' => 0,
            'label' => 'System',
            'config' => [
                'type' => 'check',
                'readOnly' => 1
            ]
        ],
        'message' => [
            'exclude' => 0,
            'label' => 'Message',
            'config' => [
                'type' => 'text',
                'readOnly' => 1
            ]
        ],
        'data_var' => [
            'exclude' => 0,
            'label' => 'Data',
            'config' => [
                'type' => 'text',
                'cols' => 50,
                'rows' => 40,
                'readOnly' => 1
            ]
        ],
        'severity' => [
            'exclude' => 0,
            'label' => 'Severity',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Ok', -1],
                    ['Information', 0],
                    ['Warning', 1],
                    ['Fatal Error', 2]                    
                ],
                'readOnly' => 1,
            ]
        ],
    ],
    'types' => [
		'0' => ['showitem' => ';;basic, message, ;;source, data_var']
	],
    'palettes' => [
        'basic' => ['showitem' => 'crdate, severity'],
        'source' => ['showitem' => 'extkey, --linebreak--, location, line']
    ],
);