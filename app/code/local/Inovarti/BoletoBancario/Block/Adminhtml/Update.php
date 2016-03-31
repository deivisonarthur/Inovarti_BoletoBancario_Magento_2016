<?php

/**
 *
 * @category   Inovarti
 * @package    Inovarti_OrderNumber
 * @author     Suporte <suporte@inovarti.com.br>
 */
class Inovarti_BoletoBancario_Block_Adminhtml_Update extends Mage_Adminhtml_Block_System_Config_Form_Field {

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
        $this->setElement($element);
        return $this->_getAddRowButtonHtml($this->__('Run Update'));
    }

    protected function _getAddRowButtonHtml($title) {

        $buttonBlock = $this->getElement()->getForm()->getParent()->getLayout()->createBlock('adminhtml/widget_button');
        $url = Mage::helper('adminhtml')->getUrl("adminhtml/boletobancario_start/update");

        return $this->getLayout()->createBlock('adminhtml/widget_button')
                        ->setType('button')
                        ->setLabel($this->__($title))
                        ->setOnClick("window.location.href='" . $url . "'")
                        ->toHtml();
    }

}
