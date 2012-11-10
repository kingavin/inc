<?php
namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Form\Form;
use Zend\Form\Fieldset;

class SingleForm extends AbstractHelper
{
    public function __invoke(Form $form)
    {
        $form->prepare();
        
        $output = '';
        $output .= $this->view->form()->openTag($form);
        $output .= '<dl class="admin-zendform">';
    	$output .= $this->view->bootstrapCollection($form, 'single');
        $output .= '</dl>';
        $output .= $this->view->form()->closeTag($form);
        return $output;
    }
    
    public function renderRow($element)
    {
    	$style = 'vertical';
    	 
    	if ($element instanceof Fieldset) {
    		return $this->view->bootstrapCollection($element, $style);
    	} else {
    		return $this->view->bootstrapRow($element, $style);
    	}
    }
}
