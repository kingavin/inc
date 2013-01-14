<?php
namespace Core\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class FormatData extends AbstractPlugin
{
	public function __invoke($cursor)
	{
		$data = array();
		foreach($cursor as $item) {
			if(isset($item['_id'])) {
				$item['id'] = $item['_id']->{'$id'};
				unset($item['_id']);
			}
			$data[] = $item;
		}
		return $data;
	}
}