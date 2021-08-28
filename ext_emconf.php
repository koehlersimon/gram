<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Gram',
    'description' => 'Social Network with TYPO3',
    'category' => 'Content',
    'author' => 'Simon Köhler',
    'author_email' => 'info@simon-koehler.com',
    'author_company' => 'simon-koehler.com',
    'shy' => '',
    'priority' => '',
    'module' => '',
    'state' => 'beta',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'lockType' => '',
    'version' => '0.0.2',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.3.99'
        ],
        'conflicts' => [

        ],
        'suggests' => [

        ],
    ],
    'autoload' => [
        'psr-4' => [
            'SIMONKOEHLER\\Gram\\' => 'Classes'
        ]
    ],
];
