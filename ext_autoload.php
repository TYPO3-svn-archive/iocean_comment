<?php
// DO NOT CHANGE THIS FILE! It is automatically generated by extdeveval::buildAutoloadRegistry.
// This file was generated on 2012-01-24 08:14

$extensionPath = t3lib_extMgm::extPath('iocean_comment');
$extensionClassesPath = t3lib_extMgm::extPath('iocean_comment') . 'Classes/';
return array(
	'tx_ioceancomment_controller_commentcontroller' => $extensionClassesPath . 'Controller/CommentController.php',
	'tx_ioceancomment_domain_model_comment' => $extensionClassesPath . 'Domain/Model/Comment.php',
	'tx_ioceancomment_domain_repository_commentrepository' => $extensionClassesPath . 'Domain/Repository/CommentRepository.php',
	'tx_ioceancomment_pi1' => $extensionPath . 'pi1/class.tx_ioceancomment_pi1.php',
	'tx_ioceancomment_pi1_wizicon' => $extensionPath . 'pi1/class.tx_ioceancomment_pi1_wizicon.php',
);
?>