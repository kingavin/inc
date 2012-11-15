<?php
namespace Core\Mongo\Db;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Core\Mongo\Db\Adapter;

class AdapterServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    	$siteConfig = $serviceLocator->get('Fucms\SiteConfig'); 
    	
        $config = $serviceLocator->get('Configuration');
        if($config['mongo_db']['dbName'] == 'cms') {
        	$config['mongo_db']['dbName'] = 'cms_'.$siteConfig->globalSiteId;
        }
        $adapter = new Adapter($config['mongo_db']);
        
        return $adapter;
    }
}
