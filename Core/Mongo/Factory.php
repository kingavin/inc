<?php
namespace Core\Mongo;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

Class Factory implements ServiceLocatorAwareInterface
{
	protected $_sm = null;
	
	public function _m($modelName)
	{
		if(empty($modelName)) {	
			throw new Exception('could not find model list class');
		}
		$className = 'Class_Mongo_'.$modelName.'_Co';
	    $args = func_get_args();
		array_shift($args);
		
		$mongoCollectionClass = new $className;
		
		$adapter = $this->getServiceLocator()->get('Core\Mongo\Db\Adapter');
		
		$mongoCollectionClass->setAdapter($adapter);
		
//		if(count($args) > 0) {
//		    $reflection = new ReflectionClass($className);
//		    return $reflection->newInstanceArgs($args);
//		} else {
		    return $mongoCollectionClass;
//		}
	}
	
	public function _d($modelName)
	{
		if(empty($modelName)) {	
			throw new Exception('could not find model list class');
		}
		$className = 'Class_Mongo_'.$modelName.'_Co';
	    $args = func_get_args();
		array_shift($args);
		
		$mongoCollectionClass = new $className;
		
		$adapter = $this->getServiceLocator()->get('Core\Mongo\Db\Adapter');
		
		$mongoCollectionClass->setAdapter($adapter);
		
//		if(count($args) > 0) {
//		    $reflection = new ReflectionClass($className);
//		    return $reflection->newInstanceArgs($args);
//		} else {
		    return $mongoCollectionClass;
	}
	
	public function _am($modelName)
	{
		if(empty($modelName)) {	
			throw new Exception('could not find model list class');
		}
		$className = 'App_Mongo_'.$modelName.'_Co';
	    $args = func_get_args();
		array_shift($args);
		
		$mongoCollectionClass = new $className;
		
		$adapter = $this->getServiceLocator()->get('Core\Mongo\Db\Adapter');
		
		$mongoCollectionClass->setAdapter($adapter);
		
		return $mongoCollectionClass;
	}
	
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->_sm = $serviceLocator;
	}
	
	public function getServiceLocator()
	{
		return $this->_sm;
	}
}