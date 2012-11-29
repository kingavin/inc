<?php
namespace Core\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\Redirect;

class SwitchContext extends Redirect
{
	public function __invoke($controllerName = "index", $actionName = "index", $param = null, $redirect = false)
	{
		$event = $this->getEvent();
		$request = $event->getRequest();
		
		if($request->isXmlHttpRequest()) {
			$response = $this->getResponse();
			if($redirect) {
				$controller = $this->getController();
				$urlPlugin = $controller->plugin('url');
				$params = array('controller' => $controllerName.'.ajax', 'action' => $actionName);
				if(!is_scalar($param)) {
					$params = array_merge($params, $param);
				}
				$url = $urlPlugin->fromRoute(null, $params);
				$response->getHeaders()->addHeaderLine('Content-Type', 'text/html');
				$response->getHeaders()->addHeaderLine('result', 'redirect');
				$response->getHeaders()->addHeaderLine('url', $url);
			} else {
				$response->setContent("");
				$response->getHeaders()->addHeaderLine('Content-Type', 'text/html');
				$response->getHeaders()->addHeaderLine('result', 'success');
			}
			return $response;
		} else {
			if(is_array($controllerName)) {
				return $this->toRoute(null, $controllerName);
			} else {
				return $this->toRoute(null, array('controller' => $controllerName, 'action' => $actionName));
			}
		}
	}
}