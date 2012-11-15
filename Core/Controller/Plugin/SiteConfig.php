<?php
namespace Core\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class SiteConfig extends AbstractPlugin
{
	public function __invoke($key)
	{
		$controller = $this->getController();
		$sm = $controller->getServiceLocator();
		$siteConfig = $sm->get('Fucms\SiteConfig');
		return $siteConfig->$key;
	}
}