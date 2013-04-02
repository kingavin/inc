<?php
namespace Core\Mongo\Db;

use MongoClient;

class Adapter
{
	protected $_dbName = null;
	protected $_dbHost = null;
	
	protected $_mongoClient = null;
	protected $_db = null;
	
	public function __construct($mongoClient, $dbName)
	{
		$this->_mongoClient = $mongoClient;
		$this->_dbName = $dbName;
	}
	
	public function getMongo()
	{
		$this->_connect();
		return $this->_mongoClient;
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
        
        $this->_db = $this->_mongoClient->selectDb($this->_dbName);
        \App_Mongo_Db_Collection::setDefaultAdapter($this);
        return;
    }
}