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
class Tx_IoceanComment_Domain_Model_Cible extends Tx_Extbase_DomainObject_AbstractEntity {
	
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
	 * 
	 * Construct Cible Object
	 * @param string $tableRef
	 * @param int $idContent
	 */
	public function __construct() {
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
}
?>