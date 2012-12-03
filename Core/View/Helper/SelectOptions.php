<?php
namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;

class SelectOptions extends AbstractHelper
{
	public function __invoke($optionArr, $extraArr = array(), $type = 'prepend')
	{
		$output = '';
		
		if(count($extraArr) > 0) {
			foreach($extraArr as $key => $val) {
				$output.= '<option value="'.$key.'">'.$val.'</option>';
			}
		}
		foreach($optionArr as $key => $val) {
			$output.= '<option value="'.$key.'">'.$val.'</option>';
		}
		return $output;
	}
}
