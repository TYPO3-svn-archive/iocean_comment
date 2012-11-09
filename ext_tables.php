<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

/**
 * Insertion Table
 */
t3lib_extMgm::allowTableOnStandardPages('tx_ioceancomment_domain_model_comment');

$TCA['tx_ioceancomment_domain_model_comment'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:iocean_comment/Resources/Private/Language/locallang_db.xml:tx_ioceancomment_comment',		
		'label'     => 'fe_user',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY tstamp',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'/Configuration/TCA/Comment.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'/Resources/Public/Icons/icon_comment.gif',
	),
);

/**
 * Insertion Plugin Extbase
 */

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,// The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
	'Pi1',				// A unique name of the plugin in UpperCamelCase
	'IOcean Comment'	// A title shown in the backend dropdown field
);
$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform.xml');
/**
 * Insertion Wizicon Extbase
 */



/**
 * Default TypoScript
 */
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/IoceanComment', 'IoceanComment');

/**
 * Partie tt_content
 */
$tempColumns = Array (
	"tx_ioceancomment_active" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:iocean_comment/Resources/Private/Language/locallang_db.xml:tt_content.tx_ioceancomment_active",		
		"config" => Array (
			"type" => "check",
		)
	),
);
t3lib_div::loadTCA("tt_content");
t3lib_extMgm::addTCAcolumns("tt_content",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("tt_content","tx_ioceancomment_active");
/**
 * Partie pages
 */
$tempColumnsPage = Array (
	"tx_ioceancomment_active" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:iocean_comment/Resources/Private/Language/locallang_db.xml:pages.tx_ioceancomment_active",		
		"config" => Array (
			"type" => "check",
		)
	),
);

t3lib_div::loadTCA("pages");
t3lib_extMgm::addTCAcolumns("pages",$tempColumnsPage,1);
t3lib_extMgm::addToAllTCAtypes("pages","tx_ioceancomment_active");
?>