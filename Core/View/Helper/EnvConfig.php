<?php
namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;

class EnvConfig extends AbstractHelper implements ServiceManagerAwareInterface
{
	public $helperPluginManager;
	
	public function setServiceManager(ServiceManager $serviceManager)
	{
		$this->helperPluginManager = $serviceManager;
	}
	
    public function __invoke($configKey)
    {
    	$serviceManager = $this->helperPluginManager->getServiceLocator();
    	$siteConfig = $serviceManager->get('ConfigObject\EnvironmentConfig');
    	return $siteConfig->$configKey;
    }
}
