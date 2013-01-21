<?php
namespace Core\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class EnvConfig extends AbstractPlugin
{
	public function __invoke()
	{
		$controller = $this->getController();
		$sm = $controller->getServiceLocator();
		return $sm->get('ConfigObject\EnvironmentConfig');
	}
}