<?php
namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;

class OutputImage extends AbstractHelper
{
    public function __invoke($urlName)
    {
    	$urlArr = parse_url($urlName);
		if(isset($urlArr['host'])) {
			return $url;
		} else {
			$siteFolder = \Class_Server::getSiteFolder();
			return \Class_Server::getImageUrl().'/'.$siteFolder.'/'.$urlName;
		}
    }
}
