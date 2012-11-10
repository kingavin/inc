<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Form
 * @subpackage View
 * @copyright  Copyright (c) 2005-2012 Zucchi Limited (http://zucchi.co.uk)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

namespace Core\View\Helper;

use Zend\Form\Element;
use Zend\Form\ElementInterface;
use Zend\Form\Element\Collection as CollectionElement;
use Zend\Form\Element\Button;
use Zend\Form\FieldsetInterface;
use Zend\Form\View\Helper\AbstractHelper;
use Core\View\Helper\BootstrapRow;


/**
 * @category   Zend
 * @package    Zend_Form
 * @subpackage View
 * @copyright  Copyright (c) 2005-2012 Zucchi Limited (http://zucchi.co.uk)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class BootstrapCollection extends AbstractHelper
{
    /**
     * the style of form to generate
     * @var string
     */
    protected $formStyle = 'vertical';

    /**
     * @var BootstrapRow
     */
    protected $rowHelper;
    
    public function render(ElementInterface $element)
    {
        $markup = '';
        $attribs = '';

        $markup .= $this->getElementMarkup($element);
        
        /*
        $markup = sprintf(
            '<d>%s</dl>',
            $markup
        );
        */
		//if($style == 'tab') {
        //$markup = sprintf('<li class="content-item">%s</li>', $markup);
		//}
        return $markup;
    }

    /**
     * Invoke helper as function
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @param  boolean $wrap
     * @return string|FormCollection
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * Get Markup for element
     *
     * @param \Zend\Form\ElementInterface $element
     * @param string $formStyle
     * @return string
     */
    public function getElementMarkup(ElementInterface $element)
    {
    	
        $markup = '';
        $rowHelper = $this->getRowHelper();

        foreach($element->getIterator() as $elementOrFieldset) {
            if ($elementOrFieldset instanceof FieldsetInterface) {
                $markup .= $this->render($elementOrFieldset);
            } elseif ($elementOrFieldset instanceof ElementInterface) {
                $markup .= $rowHelper($elementOrFieldset);
            }
        }
        return $markup;
    }
    
	/**
     * Retrieve the BootstrapRow helper
     *
     * @return FormRow
     */
    protected function getRowHelper()
    {
        if ($this->rowHelper) {
            $this->rowHelper->setFormStyle($this->formStyle);
            return $this->rowHelper;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->rowHelper = $this->view->plugin('bootstrap_row');
        }
/*
        if (!$this->rowHelper instanceof BootstrapRow) {
            $this->rowHelper = new BootstrapRow();
        }
*/      
        return $this->rowHelper;
    }
}
