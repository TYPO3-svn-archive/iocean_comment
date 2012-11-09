<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,																	// The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
	'Pi1',																		// A unique name of the plugin in UpperCamelCase
	array (																		// An array holding the controller-action-combinations that are accessible
		'Comment' => 'index,liste,formulaire,add,update',		// The first controller and its first action will be the default
	),
	array(																		// An array of non-cachable controller-action-combinations (they must already be enabled)
		'Comment' => 'formulaire,add,update',
	)
);

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_ioceancomment_pi1.php', '_pi1', 'list_type', 0);
?>