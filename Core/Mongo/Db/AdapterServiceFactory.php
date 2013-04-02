<?php
namespace Core\Mongo\Db;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Core\Mongo\Db\Adapter;

class AdapterServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        if($config['mongo_db']['dbName'] == 'cms') {
        	$siteConfig = $serviceLocator->get('ConfigObject\EnvironmentConfig');
        	$config['mongo_db']['dbName'] = 'cms_'.$siteConfig->globalSiteId;
        }
        $mongoClient = $serviceLocator->get('MongoClient');
        $adapter = new Adapter($mongoClient, $config['mongo_db']['dbName']);
        
        return $adapter;
    }
}
