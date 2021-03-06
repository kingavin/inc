<?php
namespace Core\Brick\Flex;

use Core\Brick\Flex\TwigView;

abstract class AbstractBrick
{
    protected $_brick = null;
    protected $_controller = null;
    protected $_params = null;
    protected $_scriptName = 'view.phtml';
    protected $_disableRender = false;
    protected $_gearLinks = array();
    
    protected $_effectFiles = null;
    
    protected $_useTwig = false;
    
    public function __construct($brick, $controller)
    {
    	$this->_brick = $brick;
    	$this->_controller = $controller;
        $this->_params = (object)$brick->params;
        
        $this->_init();
    }
    
    public function _init(){}
    
    public function dbFactory()
    {
    	return $this->_controller->dbFactory();
    }
    
	public function configParam($form)
    {
    	return $form;
    }
    
    public function getExtName()
    {
    	return $this->_brick->extName;
    }
    
	public function getBrickId()
    {
    	return $this->_brick->brickId;
    }
    
    public function getBrickName()
    {
    	return $this->_brick->brickName;
    }
    
    public function getPosition()
    {
    	return $this->_brick->position;
    }
    
    public function getSpriteName()
    {
    	return $this->_brick->spriteName;
    }
    
    public function getEffectFiles()
    {
    	return $this->_effectFiles;
    }
    
	public function getParam($key, $defaultValue = NULL)
    {
    	$params = $this->_params;
    	if(isset($params->$key)) {
    		$temp = $params->$key;
    		return $temp;
    	}
    	return $defaultValue;
    }
    
    public function setParam($key, $value)
    {
    	$this->_params->$key = $value;
    	return true;
    }
    
    public function setParams($src, $type = 'array')
    {
    	if(!empty($src)) {
	    	if($type == 'json') {
	    		$src = Zend_Json_Decoder::decode($src);
	    	}
	    	foreach($src as $key => $value) {
	    		if(!empty($value)) {
	    			$this->_params->$key = $value;
	    		}
	    	}
    	}
    }
    
    public function setScriptFile($filename)
    {
    	$this->_scriptName = $filename;
    }
    
    public function path()
    {
    	$extName = strtolower($this->_brick->extName);
        $path = str_replace('_', '/', $extName);
        return '/'.$path;
    }
    
    public function twigPath()
    {
        return '/'.$this->_brick->extName;
    }
    
    public function render($type = null)
    {
    	if($this->_disableRender === true) {
	        return "<div class='no-render'></div>";
    	} else if(is_string($this->_disableRender)) {
    		return "<div class='".$this->_disableRender."' brickId='".$this->_brick->brickId."'>无法找到对应的URL，此模块内容为空</div>";
    	} else {
	    	$this->view = new TwigView();
			$this->view->setScriptPath(BASE_PATH.'/extension/view'.$this->path());
			$this->view->assign($this->_params);
			$this->prepare();
			
			$this->view->setBrickId($this->_brick->getId())
				->setExtName($this->_brick->extName)
				->setClassSuffix($this->_brick->cssSuffix);
			
			$this->view->brickName = $this->_brick->brickName;
			$this->view->brickId = $this->_brick->brickId;
			$this->view->displayBrickName = $this->_brick->displayBrickName;
			
			try {
				return $this->view->render($this->_brick->tplName);
			} catch(Exception $e) {
				return "critical error within brick id: ".$this->_brick->brickId.'!!<br /><a href="#/admin/brick/edit/brick-id/'.$this->_brick->brickId.'">reset parameters</a>';
			}
    	}
    }
    
    public function configTplOptions($form)
    {
    	$tplArray = array();
    	
    	$systemFolder = CONTAINER_PATH.'/extension'.$this->path();
    	$handle = opendir($systemFolder);
    	while($file = readdir($handle)) {
    		if(strpos($file, '.tpl')) {
    			$tplArray[$file] = $file;
    		}
    	}
    	$userFolder = TEMPLATE_PATH.$this->twigPath();
    	$userTplArray = array();
		if(is_dir($userFolder)) {
			$handle = opendir($userFolder);
	    	while($file = readdir($handle)) {
	    		if(strpos($file, '.tpl')) {
	    			$userTplArray[$file] = $file;
	    		}
	    	}
		}
		if(count($userTplArray) > 0) {
			$tplArray = array('system' => $tplArray, 'user' => $userTplArray);
		}
    	
    	$form->tplName->setMultiOptions($tplArray);
    	return $form;
    }
    
    public function getTplArray()
    {
    	$sysTplArray = array();
    	$userTplArray = array();
    	
    	$systemFolder = BASE_PATH.'/extension/view'.$this->path();
    	$handle = opendir($systemFolder);
    	while($file = readdir($handle)) {
    		if(strpos($file, '.tpl')) {
    			$sysTplArray[$file] = $file;
    		}
    	}
    	/*
    	$userFolder = TEMPLATE_PATH.$this->twigPath();
    	if(is_dir($userFolder)) {
			$handle = opendir($userFolder);
	    	while($file = readdir($handle)) {
	    		if(strpos($file, '.tpl')) {
	    			$userTplArray[$file] = $file;
	    		}
	    	}
		}
		*/
		$tplArray = array(
			array('label' => 'system', 'options' => $sysTplArray,),
			array('label' => 'user', 'options' => $userTplArray)
		);
    	return $tplArray;
    }
    
    public function getCacheId()
    {
    	return null;
    }
}