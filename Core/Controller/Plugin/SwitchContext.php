<?php
namespace Core\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\Redirect;

class SwitchContext extends Redirect
{
	public function __invoke($controllerName = "index", $actionName = "index")
	{
		$event = $this->getEvent();
		$request = $event->getRequest();
		
		if($request->isXmlHttpRequest()) {
			$response = $this->getResponse();
			$response->setContent("");
			$response->getHeaders()->addHeaderLine('Content-Type', 'text/html');
			$response->getHeaders()->addHeaderLine('result', 'success');
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