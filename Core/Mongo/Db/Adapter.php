<?php
namespace Core\Mongo\Db;

use Mongo;
use Zend\Debug\Debug;

class Adapter
{
	protected $_dbName = null;
	protected $_dbHost = null;
	
	protected $_mongo = null;
	protected $_db = null;
	
	public function __construct($config)
	{
//		echo 'adapter inited!!';
//		Debug::dump($config);
		
		$this->_dbHost = $config['host'];
		$this->_dbName = 'cms_1';
	}	
	
	public function getMongo()
	{
		$this->_connect();
		return $this->_mongo;
	}
	
	public function getDb()
	{
		$this->_connect();
		return $this->_db;
	}
	
	public function getDbName()
	{
		return $this->_dbName;
	}
	
	public function getCollection($collectionName)
	{
		$this->_connect();
		return $this->_db->$collectionName;
	}
	
	public function isConnected()
    {
        return ((bool) ($this->_db instanceof Mongo));
    }
    
	protected function _connect()
    {
        if ($this->_db) {
            return;
        }
        
        $m = new Mongo($this->_dbHost, array('persist' => 'x'));
        $this->_mongo = $m;
        $this->_db = $m->selectDb($this->_dbName);
        \App_Mongo_Db_Collection::setDefaultAdapter($this);
        return;
    }
}