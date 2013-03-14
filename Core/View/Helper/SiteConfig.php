<?php
namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SiteConfig extends AbstractHelper implements ServiceLocatorAwareInterface
{
	public $helperPluginManager;
	
	public function setServiceLocator(ServiceLocatorInterface $serviceManager)
	{
		$this->helperPluginManager = $serviceManager;
	}
	
	public function getServiceLocator()
	{
		return $this->helperPluginManager;
	}
	
    public function __invoke($configKey)
    {
    	$serviceManager = $this->helperPluginManager->getServiceLocator();
    	$siteConfig = $serviceManager->get('ConfigObject\EnvironmentConfig');
    	return $siteConfig->$configKey;
    }
}
