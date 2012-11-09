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
 * A blog
 *
 * @version $Id:$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Tx_IoceanComment_Domain_Model_Comment extends Tx_Extbase_DomainObject_AbstractEntity {
	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Extbase_Domain_Model_FrontendUser>
	 */
	protected $feUser;
	
	/**
	 * @var string
	 * @validate NotEmpty
	 */
	protected $tableRef = '';
	
	/**
	 * @var int 
	 * @validate NotEmpty
	 */
	protected $idContent = 0;
	
	/**
	 * @var string
	 * @validate NotEmpty
	 */
	protected $comment = '';
	
	/**
	 * @var DateTime
	 */
	protected $tstamp;
	/**
	 * @var DateTime
	 */
	protected $crdate;
	
	/**
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name = '';
	
	/**
	 * @var string
	 * @validate EmailAddress
	 */
	protected $email = '';
	
	/**
	 * 
	 * The event's acces group.
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Extbase_Domain_Model_FrontendUserGroup>
	 * @lazy
	 */
	protected $feGroup = '';
	
	/**
	 * Constructs a new Event
	 *
	 * @api
	 */
	public function __construct() {
		$this->feGroup = new Tx_Extbase_Persistence_ObjectStorage();
		$this->feUser = new Tx_Extbase_Persistence_ObjectStorage(); 
	}
		

	/**
	 * Returns the user. Keep in mind that the property is called "usergroup"
	 * although it can hold several usergroups.
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage An object storage containing the usergroup
	 * @api
	 */
	public function getFeUser(){
		return $this->feUser;
	}

	/**
	 * Sets the user. Keep in mind that the property is called "usergroup"
	 * although it can hold several usergroups.
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_IoceanFelogin_Domain_Model_FrontendUser> $usergroup An object storage containing the usergroups to add
	 * @return void
	 * @api
	 */
	public function setFeUser(Tx_IoceanFelogin_Domain_Model_FrontendUser $var){
		$this->feUser = $var;
	}
	/**
	 * Returns the usergroups. Keep in mind that the property is called "usergroup"
	 * although it can hold several usergroups.
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage An object storage containing the usergroup
	 * @api
	 */
	public function getFeGroup(){
		return $this->feGroup;
	}
	
	/**
	 * Sets the usergroups. Keep in mind that the property is called "usergroup"
	 * although it can hold several usergroups.
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Extbase_Domain_Model_FrontendUserGroup> $usergroup An object storage containing the usergroups to add
	 * @return void
	 * @api
	 */
	public function setFeGroup(Tx_Extbase_Persistence_ObjectStorage $var){
		$this->feGroup = $var;
	}
	
	public function getTableRef(){
		return $this->tableRef;
	}

	public function setTableRef($var){
		$this->tableRef = $var;
	}
	
	public function getIdContent(){
		return $this->idContent;
	}

	public function setIdContent($var){
		$this->idContent = $var;
	}
	
	public function getComment(){
		return $this->comment;
	}
	
	public function getCommentJSON(){
		return json_encode($this->comment);
	}

	public function setComment($var){
		$this->comment = $var;
	}
	
	public function getTstamp(){
		return $this->tstamp;
	}

	public function setTstamp($var){
		$this->tstamp = $var;
	}
	
	public function getCrdate(){
		return $this->crdate;
	}

	public function setCrdate($var){
		$this->crdate = $var;
	}
	public function getName(){
		return $this->name;
	}

	public function setName($var){
		$this->name = $var;
	}
	public function getEmail(){
		return $this->email;
	}

	public function setEmail($var){
		$this->email = $var;
	}
	
	public function getUidComment(){
		return "tx_ioceancomment_domain_model_comment".$this->uid;
	}
	/*
	public function getValidation(){
		return $this->validation;
	}

	public function setValidation($var){
		$this->validation = $var;
	}*/
}
?>