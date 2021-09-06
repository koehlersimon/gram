<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:gram/Resources/Private/Language/locallang_db.xlf:tx_gram_domain_model_like',
        'label' => 'uid',
        'label_alt' => 'owner,parent_type,crdate',
        'label_alt_force' => '1',
        'default_sortby' => 'ORDER BY crdate DESC',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => '',
        'iconfile' => 'EXT:gram/Resources/Public/Icons/Extension.svg'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, crdate, parent_type, parent, owner',
    ],
    'types' => [
        '1' => ['showitem' => 'l10n_parent, l10n_diffsource, crdate, parent_type, parent, owner, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, fe_group;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:fe_group_formlabel'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_gram_domain_model_like',
                'foreign_table_where' => 'AND tx_gram_domain_model_like.pid=###CURRENT_PID### AND tx_gram_domain_model_like.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'parent_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gram/Resources/Private/Language/locallang_db.xlf:tx_gram_domain_model_like.parent_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['GRAM Post', 0],
                    ['GRAM Comment', 1],
                ],
            ],
        ],
        'parent' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gram/Resources/Private/Language/locallang_db.xlf:tx_gram_domain_model_like.parent',
            'config' => [
                'type' => 'input',
                'size' => 5,
                'eval' => 'int',
            ],
        ],
        'owner' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gram/Resources/Private/Language/locallang_db.xlf:tx_gram_domain_model_like.owner',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'fe_users',
            ],
        ],
        'crdate' => array(
            'exclude' => 1,
            'label' => 'Create Date',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    //'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),
    ],
];
