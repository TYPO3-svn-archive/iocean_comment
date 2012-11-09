<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_ioceancomment_domain_model_comment'] = array (
	'ctrl' => $TCA['tx_ioceancomment_domain_model_comment']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,fe_group,fe_user,table_ref,id_content,comment'
	),
	'feInterface' => $TCA['tx_ioceancomment_domain_model_comment']['feInterface'],
	'columns' => array (
		'crdate' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:iocean_comment/Resources/Private/Language/locallang_db.xml:tx_ioceancomment_domain_model_comment.crdate',
			'config'  => array (
				'type'    => 'input',
				'eval' => 'datetime',
			)
		),
		'tstamp' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:iocean_comment/Resources/Private/Language/locallang_db.xml:tx_ioceancomment_domain_model_comment.tstamp',
			'config'  => array (
				'type'    => 'input',
				'eval' => 'datetime',
			)
		),	
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'fe_group' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		'fe_user' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:iocean_comment/Resources/Private/Language/locallang_db.xml:tx_ioceancomment_domain_model_comment.fe_user',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'fe_users',	
				'foreign_table_where' => 'ORDER BY fe_users.username',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'table_ref' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:iocean_comment/Resources/Private/Language/locallang_db.xml:tx_ioceancomment_domain_model_comment.table_ref',		
			'config' => array (
				'type' => 'input',
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'id_content' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:iocean_comment/Resources/Private/Language/locallang_db.xml:tx_ioceancomment_domain_model_comment.id_content',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'comment' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:iocean_comment/Resources/Private/Language/locallang_db.xml:tx_ioceancomment_domain_model_comment.comment',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'wizards' => array(
					'_PADDING' => 2,
					'RTE' => array(
						'notNewRecords' => 1,
						'RTEonly'       => 1,
						'type'          => 'script',
						'title'         => 'Full screen Rich Text Editing|Formatteret redigering i hele vinduet',
						'icon'          => 'wizard_rte2.gif',
						'script'        => 'wizard_rte.php',
					),
				),
			)
		),
		'name' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:iocean_comment/Resources/Private/Language/locallang_db.xml:tx_ioceancomment_domain_model_comment.name',		
			'config' => array (
				'type' => 'input',
				'size' => '30',	
			)
		),
		'email' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:iocean_comment/Resources/Private/Language/locallang_db.xml:tx_ioceancomment_domain_model_comment.email',		
			'config' => array (
				'type' => 'input',
				'size' => '30',	
			)
		),
		'moderate' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:iocean_comment/Resources/Private/Language/locallang_db.xml:tx_ioceancomment_domain_model_comment.moderate',		
			'config' => array (
				'type' => 'check',
			)
		),
	),
	'types' => array (
		'1' => array('showitem' => 'hidden;;1;;1-1-1, fe_user;;2, comment;;;richtext[]:rte_transform[mode=ts]')
	),
	'palettes' => array (
		'1' => array('showitem' => 'fe_group'),
		'2' => array('showitem' => 'table_ref, id_content')
	)
);
?>