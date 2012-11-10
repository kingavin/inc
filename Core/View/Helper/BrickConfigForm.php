<?php
namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Form\Form;
use Zend\Form\FieldsetInterface;
use Zend\Form\ElementInterface;

class BrickConfigForm extends AbstractHelper
{
    public function __invoke(Form $form)
    {
    	$form->prepare();
        $elementHtmlArr = $this->sortElementRender($form);
        
        $output = '';
        $output .= $this->view->form()->openTag($form);
        $output .= '<fieldset class="basic"><legend>基本参数</legend>';
        $output .= '<dl class="admin-zendform">';
    	$output .= $elementHtmlArr['basic'];
        $output .= '</dl></fieldset>';
        foreach($elementHtmlArr['paramArr'] as $paramHtml) {
        	$output .= '<fieldset class="param"><legend>模块参数</legend>';
	        $output .= '<dl class="admin-zendform">';
	    	$output .= $paramHtml;
	        $output .= '</dl></fieldset>';
        }
        $output .= $this->view->form()->closeTag($form);
        return $output;
    }
    
    public function sortElementRender($form)
    {
    	$elementHtmlArr = array();
    	$basicHtml = "";
    	$paramHtmlArr = array();
    	foreach($form->getIterator() as $element) {
    		if ($element instanceof FieldsetInterface) {
                $paramHtmlArr[] = $this->view->bootstrapCollection($element);
            } elseif ($element instanceof ElementInterface) {
                $basicHtml .= $this->view->bootstrapRow($element);
            }
    	}
    	$elementHtmlArr['basic'] = $basicHtml;
    	$elementHtmlArr['paramArr'] = $paramHtmlArr;
    	return $elementHtmlArr;
    }
}
