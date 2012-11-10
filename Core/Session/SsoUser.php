<?php
namespace Core\Session;

use Zend\Session\Container;

abstract class SsoUser
{
	protected $_ssoUser = null;
	protected $_sessionContainerName = 'sso/defaultuser';
	
	public function __construct()
	{
		$this->_ssoUser = new Container($this->_sessionContainerName);
	}
	
	public function hasSSOToken()
	{
		return $this->hasSessionValue('st');
	}
	
	public function getSSOToken()
	{
		if($this->hasSSOToken()) {
			return $this->getSessionValue('st');
		} else {
			$token = md5(time().rand(0, 10000));
			$this->setSessionValue('st', $token);
			return $token;
		}
	}
	
	public function setSessionValue($key, $value)
	{
		$this->_ssoUser->offsetSet($key, $value);
	}
	
	public function getSessionValue($key)
	{
		return $this->_ssoUser->offsetGet($key);
	}
	
	public function hasSessionValue($key)
	{
		return $this->_ssoUser->offsetExists($key);
	}
	
	public function isLogin()
	{
		if($this->getSessionValue('isLogin')) {
			return true;
		}
		return false;
	}
	
	public function setUserData($key, $val = null)
	{
		if(is_array($key)) {
			$this->setSessionValue('userData', $key);
		}
	}
	
	public function getUserData($key = null)
	{
		if($this->isLogin()) {
			if($key == null) {
				$userData = $this->getSessionValue('userData');
				return $userData;
			} else {
				$userData = $this->getSessionValue('userData');
				return $userData[$key];
			}
		}
		
		return null;
	}

	public function __toString()
	{
		$it = $this->_ssoUser->getIterator();
		
		foreach($it as $key => $val) {
			echo $key.' => '.$val.'<br />';
		}
		die('why??');
		return $this->_ssoUser->getStorage();
	}
	
	abstract public function getServiceKey();
	
	abstract public function getServiceType();
	
	abstract public function hasPrivilege();
	
	abstract public function login($data);
	
	abstract public function logout();
}