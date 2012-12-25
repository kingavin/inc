<?php
namespace Core;

use Doctrine\Common\Persistence\PersistentObject;

class AbstractDocument extends PersistentObject
{
	public function setFromArray($dataArray)
	{
		foreach($dataArray as $key => $val) {
			$this->$key = $val;
			
		}
		return $this;
	}
}