<?php
namespace Core;

use Zend\InputFilter\InputFilterAwareInterface, Zend\InputFilter\InputFilterInterface;
use Doctrine\Common\Persistence\PersistentObject;

class AbstractDocument extends PersistentObject implements InputFilterAwareInterface
{
	public function isNew()
	{
		return empty($this->id);
	}
	
	/**
	 * @todo these two functinos are to be replaced by getArrayCopy & arrayExchange
	 * @param unknown $dataArray
	 * @return \Core\AbstractDocument
	 */
	public function setFromArray($dataArray)
	{
		foreach($dataArray as $key => $val) {
			$this->$key = $val;
			
		}
		return $this;
	}
	
	public function toArray()
	{
		return get_object_vars($this);
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}
	
	public function getInputFilter()
	{
		throw new \Exception("Not used");
	}
}