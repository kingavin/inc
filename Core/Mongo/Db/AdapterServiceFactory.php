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
        
        $adapter = new Adapter($config['mongo_db']);
        
        return $adapter;
    }
}
