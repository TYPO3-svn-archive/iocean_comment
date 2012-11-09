<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 Jochen Rau <jochen.rau@typoplanet.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * The blog controller for the Gallery package
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_IoceanComment_Controller_CommentController extends Tx_Extbase_MVC_Controller_ActionController {
	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	public function initializeAction() {
		
		
		/*
		$this->initUseCaptcha();
		$this->initUidComment();
		
		//valeur par défaut
		if(!$this->settings['pageSize']){
			$this->settings['pageSize'] = 5;
		}
		switch($this->settings['table']){
			case "pages":
				$this->settings['uid'] = $GLOBALS['TSFE']->id;
				break;
			case "tt_content":
				$this->settings['uid'] = $this->configurationManager->getContentObject()->data['uid'];
				break;
			default:
				if($this->settings['prefixeVarUid'] && $this->settings['postVarUid']){
					$tab = t3lib_div::_GPmerged($this->settings['prefixeVarUid']);
					if($tab[$this->settings['postVarUid']]){
						$this->settings['uid'] = $tab[$this->settings['postVarUid']];
					}
				}
				
		}
		if($this->request->hasArgument("success")){
			$this->settings["success"] = $this->request->getArgument("success");
			
		}
		
		*/
		
		
	}
	/**
	 * Displays a form for creating a new blog
	 *
	 * @param Tx_IoceanComment_Domain_Model_Cible $cible
	 * @return void
	 * @dontvalidate $cible
	 */
	public function indexAction(Tx_IoceanComment_Domain_Model_Cible $cible) {
		
		if(!$cible->getTableRef() || !$cible->getIdContent()){
			//mettre paramétrage par défaut
			$this->initCible($cible);
		} 
			
		
		
		if($cible->getTableRef() && $cible->getIdContent()) {
			//récupérer tous les commentaires
			$allComment = $this->commentRepository->findByTableAndUid($this->settings['table'], $this->settings['uid']);
			$countAllComment = $allComment->count();
			//récupérer la requète pour la limiter
			$queryComment = $allComment->getQuery();
			//limiter à la taille de la page
			$queryComment->setLimit($this->settings['pageSize']);
			//définir le départ de la limite
			if($this->settings['start']){
				$queryComment->setOffset($this->settings['start']);
			}
			$comments = $queryComment->execute();
			
			$this->view->assign("countAllComment", $countAllComment);
			$this->view->assign("comments", $comments);
		} else {
			t3lib_utility_debug::debug($this->settings);
			return "";
		}
		
		
	}
	
	public function listeAction() {
		if($this->settings['uid'] && $this->settings['table']) {
			$success = "true";
			$allComment = $this->commentRepository->findByTableAndUid($this->settings['table'], $this->settings['uid']);
			$totalCount = $allComment->count();	
			$allComment = $allComment->getQuery()->setLimit($this->settings['limit'])->setOffset($this->settings['start'])->execute();
			//t3lib_utility_Debug::debug($allComment->count(),"Count");
			$this->view->assign("allComment", $allComment);
			$this->view->assign("totalCount", $totalCount);
		} else {
			$success = "false";
		}
		$this->view->assign("success", $success);
	}
	
	public function initializeFormulaireAction(){
		if($this->request->hasArgument("add")){
			$this->settings['add'] = $this->request->getArgument("add");
		}
	}
	
	/**
	 * Displays a form for creating a new blog
	 *
	 * @param Tx_IoceanComment_Domain_Model_Comment $comment A fresh blog object taken as a basis for the rendering
	 * @return void
	 * @dontvalidate $comment
	 */
	public function formulaireAction(Tx_IoceanComment_Domain_Model_Comment $comment = NULL){
		
		if($comment === NULL){
			$comment = new Tx_IoceanComment_Domain_Model_Comment();
			$comment->setName("Anonyme");
			$comment->setIdContent($this->settings['uid']);
			$comment->setTableRef($this->settings['table']);
		}
		//initialiser le captcha
		if($this->settings['useCaptcha']) {
			if(!$this->testCaptcha()) {
				$this->view->assign("captchaError", TRUE);
			}
			if (is_object($this->freeCap)) {
				$markerCaptcha = $this->freeCap->makeCaptcha();
				$this->view->assignMultiple(array(
					"captchaImage" => $markerCaptcha["###SR_FREECAP_IMAGE###"],
					"captchaNotice" => $markerCaptcha["###SR_FREECAP_NOTICE###"],
					"captchaCantRead" => $markerCaptcha["###SR_FREECAP_CANT_READ###"],
				));
			} 
		}
		$this->view->assign("comment", $comment);
	}
	
	
	/**
	 * Creates a new blog
	 *
	 * @param Tx_IoceanComment_Domain_Model_Comment $comment nouveau commentaire à ajouter
	 * @return void
	 */
	public function addAction(Tx_IoceanComment_Domain_Model_Comment $comment){
		if($this->testCaptcha()){
			$this->commentRepository->add($comment);
			//pour la mise à jour mettre le persitall
			//$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
			//$persistenceManager->persistAll();
			$this->redirect("index");
		} else {
			$this->forward("formulaire");
		}
	}
	
	private function testCaptcha(){
		if($this->settings['useCaptcha']) {
			if($this->request->hasArgument("captcha")){
				$this->settings['captchaReponse'] = $this->request->getArgument("captcha");
				if (t3lib_extMgm::isLoaded('sr_freecap') ) {
					if (is_object($this->freeCap) && !$this->freeCap->checkWord($this->settings['captchaReponse'])) {
						return false;
					} 
				}
			} 
		} 
		return true;
	}
	
	private function initUseCaptcha(){
		//initialise captcha
		if (t3lib_extMgm::isLoaded('sr_freecap') ) {
			require_once(t3lib_extMgm::extPath('sr_freecap').'pi2/class.tx_srfreecap_pi2.php');
			$this->freeCap = t3lib_div::makeInstance('tx_srfreecap_pi2');
		} else {
			$this->settings['useCaptcha'] = 0;
		}
		//t3lib_utility_Debug::debug($this->settings,"settings deb");
		if($this->settings['useCaptcha'] > 0){
			if($GLOBALS['TSFE']->fe_user->user && $this->settings['groupCaptcha'] === -1) {
				$this->settings['useCaptcha'] = true;
			} else if($GLOBALS['TSFE']->fe_user->user && $this->settings['groupCaptcha'] > 0) {
				//t3lib_utility_Debug::debug($GLOBALS['TSFE']->fe_user->user,"user");
				$groupUser = explode(",",$GLOBALS['TSFE']->fe_user->user['usergroup']);
				$groupsConnect = explode(",",$this->settings['groupCaptcha']);	
				//t3lib_utility_Debug::debug(array_intersect($groupUser, $groupsConnect),"user");
				if(array_intersect($groupUser, $groupsConnect) && $this->settings['useCaptcha'] == 1){
					//t3lib_utility_Debug::debug(1,"user");
					$this->settings['useCaptcha'] = true;
				} else if(!array_intersect($groupUser, $groupsConnect) && $this->settings['useCaptcha'] == 2) {
					//t3lib_utility_Debug::debug(2,"user");
					$this->settings['useCaptcha'] = true;
				} else {
					//t3lib_utility_Debug::debug(3,"user");
					$this->settings['useCaptcha'] = false;
				}
			} else {
				$this->settings['useCaptcha'] = false;
			}
		} else {
			if($this->settings['useCaptcha'] === -1) {
				$this->settings['useCaptcha'] = true;
			} else {
				$this->settings['useCaptcha'] = false;
			}
		}
	}
	
	private function initCible(Tx_IoceanComment_Domain_Model_Cible $cible){
		
		if($this->settings['table']){
			$cible->setTableRef($this->settings['table']);
			if($this->settings['uid']){
				$cible->setIdContent($this->settings['uid']);
			} else {
				//par rapport à la table
				switch($this->settings['table']){
					case "pages":
						$cible->setIdContent($GLOBALS['TSFE']->id);
						break;
					case "tt_content":
						$cible->setIdContent($this->configurationManager->getContentObject()->data['uid']);
						break;
					default:
						if($this->settings['prefixeVarUid'] && $this->settings['postVarUid']){
							$tab = t3lib_div::_GPmerged($this->settings['prefixeVarUid']);
							if($tab[$this->settings['postVarUid']]){
								$cible->setIdContent($tab[$this->settings['postVarUid']]);
							}
						} else {
							//ajouter une erreur
							
						}	
				}
			}
		} else {
			//ajouter une erreur
		}
		
	}
	private function initUidComment(){
		//permet de vérifier si on est dans le bon plugin 
		//empèche l'insertion en javascript de l'objet (peut être)
		$this->settings['uidComment'] = $this->configurationManager->getContentObject()->data['uid'];
		if($this->settings['table'] == "pages"){
			$this->settings['uidComment'] = "pages".$GLOBALS['TSFE']->id;
		}
		if($this->settings['table'] == "tx_ioceancomment_domain_model_comment"){
			
		} else {
			if($this->actionMethodName != "indexAction"){	
				if($this->request->hasArgument("uidComment")){
					if($this->request->getArgument("uidComment") != $this->settings['uidComment']) {
						$this->forward("index",NULL,NULL,array());
					}
				} else {
					$this->forward("index",NULL,NULL,array());
				}
			}
		}
	}
	
	private function dispatch(){
		
		
		
		//permettre de changer de vue uniquement si c'est pour cette vue
		switch($this->settings['table']){
			case "pages":
				$this->settings['uid'] = $GLOBALS['TSFE']->id;
				break;
			case "tt_content":
				$this->settings['uid'] = $this->configurationManager->getContentObject()->data['uid'];
				break;
			default:
				if($this->settings['prefixeVarUid'] && $this->settings['postVarUid']){
					$tab = t3lib_div::_GPmerged($this->settings['prefixeVarUid']);
					if($tab[$this->settings['postVarUid']]){
						$this->settings['uid'] = $tab[$this->settings['postVarUid']];
					}
				}
				
		}
		t3lib_utility_debug::debug($this->actionMethodName,"actionMethodName");
		if($this->actionMethodName != "indexAction"){
			if($this->request->hasArgument("uidComment")){
				if($this->request->getArgument("uidComment") != $this->settings['uidComment']) {
					$this->actionMethodName = "indexAction";
					$this->processRequest();
				}
			}
		}
		t3lib_utility_debug::debug($this->actionMethodName,"actionMethodName");
		
	}
	/**
	 * Renvoie l'utilisateur connecté sous la forme de l'objet
	 * @return Tx_IoceanPresence_Domain_Model_Presence utilisateur
	 */
	private function getFrontendSessionUserStorage(){
		return $this->userRepository->findByUid($this->getFrontendSessionUserUid());
		
	}

	/**
	 * Renvoie l'id de l'utilisateur connecté
	 * @return int utilisateur
	 */
	private function getFrontendSessionUserUid(){
		return $GLOBALS['TSFE']->fe_user->user['uid'];
	}
	/**
	 * Dependency injection of the Fe_users Repository
 	 *
	 * @param Tx_Extbase_Domain_Repository_FrontendUserRepository $feusersRepository
 	 * @return void
	 */
	
	public function injectUserRepository(Tx_Extbase_Domain_Repository_FrontendUserRepository $feusersRepository){
		$this->userRepository = $feusersRepository;
	}
	
	/**
	 * Dependency injection of the Comment Repository
 	 *
	 * @param Tx_IoceanComment_Domain_Repository_CommentRepository $commentRepository
 	 * @return void
	 */
	
	public function injectCommentRepository(Tx_IoceanComment_Domain_Repository_CommentRepository $commentRepository){
		$this->commentRepository = $commentRepository;
	}
	
}

?>
