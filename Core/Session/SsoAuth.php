<?php
namespace Core\Session;

use SimpleXMLElement;
use Core\Session\SsoUser;

class SsoAuth
{
	const CMS = 'cms';
	const PM = 'pm';
	const SERVICE_ACCOUNT = 'service-account';
	const SERVICE_FILE = 'service-file';
	const SERVICE_FORM = 'service-form';
	const SERVICE_FORUM = 'service-forum';
	
	protected $_assu;
	protected $_serviceType;
	protected $_apiKey;
	
	public function __construct(SsoUser $assu)
	{
		$this->_assu = $assu;
		$this->_serviceType = $assu->getServiceType();
		$this->_apiKey = $assu->getServiceKey();
	}
	
	public function auth()
	{
		$csu = $this->_assu;
		if(!$csu->isLogin()) {
			if(strpos($_SERVER["REQUEST_URI"], 'http://') !== false) {
				$retUrl = $_SERVER["REQUEST_URI"];
			} else {
				$retUrl = 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			}
			
			if($csu->hasSSOToken()) {
				$st = $csu->getSSOToken();
				$response = $this->_auth($st);
				$responseCode = $response[0];
				$xmlBody = $response[1];
				switch($responseCode) {
					case '200':
						$xml = new SimpleXMLElement($xmlBody);
						$csu->login($xml);
						break;
					case '403':
						//token not exist or expired, try to request with a new token
						$ssoToken = $csu->getSSOToken();
						$ssoLoginUrl = $this->_getLoginUrl($this->_serviceType, $retUrl, $ssoToken);
						header("Location: ".$ssoLoginUrl);
						exit(0);
						break;
					default:
						echo "error while getting identity from sso server!";
						exit(1);
						break;
				}
			} else {
				$ssoToken = $csu->getSSOToken();
				$ssoLoginUrl = $this->_getLoginUrl($this->_serviceType, $retUrl, $ssoToken);
				header("Location: ".$ssoLoginUrl);
				exit(0);
			}
		} else if(!$csu->hasPrivilege()) {
			$homeLocation = $csu->getHomeLocation();
			header("Location: ".$homeLocation);
			exit(0);
		}
	}
	
	protected function _auth($st)
	{
		$curl = curl_init('http://sso.enorange.cn/sso/info/format/xml');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, array('token' => $st));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		$body = curl_exec($curl);
		$ret = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if (curl_errno($curl) != 0) {
			throw new Exception("SSO failure: HTTP request to server failed. " . curl_error($curl));
		}
		
		return array($ret, $body);
	}
	
	public function _getLoginUrl($consumer, $returnUrl, $token)
	{
		$apiKey = $this->_apiKey;
		$timeStamp = time();
		$sig = md5($consumer.$returnUrl.$timeStamp.$token.$apiKey);
		
		$c = urlencode($consumer);
		$r = urlencode($returnUrl);
		$t = urlencode($token);
		
		return 'http://sso.enorange.cn/sso/login?consumer='.$c.'&ret='.$r.'&timeStamp='.$timeStamp.'&token='.$t.'&sig='.$sig;
	}
}