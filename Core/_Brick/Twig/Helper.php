<?php
namespace Core\Brick\Twig;

class Helper
{
	public static $router;

	public static function setRouter($router)
	{
		self::$router = $router;
	}
	
	public static function url($docArr, $routeType)
	{
		$routeName = 'application/'.$routeType; 
		
		if(isset($docArr['alias']) && !empty($docArr['alias'])) {
			$resourceAlias = $docArr['alias'];
			return '/'.$resourceAlias;
		} else {
			$resourceId = $docArr['id'];
			return self::$router->assemble(array('id' => $resourceId, 'page' => 1), array('name' => $routeName));
		}
	}
	
	static function outputImage($url, $type = 'main')
	{
		$urlArr = parse_url($url);
		if(isset($urlArr['host'])) {
			return $url;
		} else {
			$siteFolder = Class_Server::getSiteFolder();
			return Class_Server::getImageUrl().'/'.$siteFolder.'/'.$url;
		}
	}
}