<?php
class Tx_IoceanComment_Domain_Validator_CommentValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {
	/**
	 * Checks whether the given blog is valid
	 *
	 * @param Tx_IoceanComment_Domain_Model_Comment $comment The blog
	 * @return boolean TRUE if blog could be validated, otherwise FALSE
	 */
	public function isValid($comment) {
		
		
		return true;
	}
}
?>