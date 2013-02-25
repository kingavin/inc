<?php
namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Form\Form;
use Zend\Form\Fieldset;

class TabForm extends AbstractHelper
{
    public function __invoke(Form $form, $tabSettingsOptional = array())
    {
        $form->prepare();
        
        $output = '';
        $output .= $this->view->form()->openTag($form);
        $tabSettings = $form->getTabSettings();
        if(!is_null($tabSettings)) {
        	$tabSettings = array_merge($tabSettings, $tabSettingsOptional);
        	$output .= '<ul class="tab-handle">';
	        foreach($tabSettings as $setting) {
	        	$output .= '<li class="handle">'.$setting['handleLabel'].'</li>';
	        }
	        $output .= '</ul>';
	        $output .= '<ul class="tab-content">';
        	foreach($tabSettings as $setting) {
        		$output .= '<li class="content-item">';
	        	if(is_array($setting['content'])) {
	        		$output .= '<dl class="admin-zendform">';
	        		foreach($setting['content'] as $elKey) {
	        			$el = $form->get($elKey);
// 	        			echo get_class($el).'<br />';
	        			$output .= $this->renderRow($el);
	        		}
	        		$output .= '</dl>';
	        	} else {
	        		$output .=$setting['content'];
	        	}
	        	$output .= '</li>';
	        }
	        $output .= '<li class="handle-overlap"></li>';
	        $output .= '</ul>';
        }
        $output .= $this->view->form()->closeTag($form);
        return $output;
    }
    
    public function renderRow($element)
    {
    	if ($element instanceof Fieldset) {
    		return $this->view->bootstrapCollection($element);
    	} else {
    		return $this->view->bootstrapRow($element);
    	}
    }
}
