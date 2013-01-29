<?php
namespace Core\Validator;

use Zend\Validator\AbstractValidator;

class InDb extends AbstractValidator
{
	const DOCUMENT_EXIST = 'documentExist';
	
	protected $messageTemplates = array(
		self::DOCUMENT_EXIST => "'%value%' is already used, please choose another value to use"
	);
	
	protected $options = array();
	
	public function isValid($value)
	{
		$this->setValue($value);
		
		$dm			= $this->options['dm'];
		$repository	= $this->options['repository'];
		$field		= $this->options['field'];
		$funcName	= 'findOneBy'.$field;
		$excludeId	= $this->options['excludeId'];
		
		$userDoc = $dm->getRepository($repository)->{$funcName}($value);
		if(is_null($userDoc)) {
			return true;
		} else if($userDoc->getId() == $excludeId) {
			return true;
		}
		$this->error(self::DOCUMENT_EXIST);
		return false;
	}
}