<?php
/**
 * @category    Inovarti
 * @package     Inovarti_BoletoBancario
 * @copyright   Copyright (c) 2015 Inovarti. (http://www.inovarti.com.br)
 */
class Inovarti_BoletoBancario_Block_Form extends Mage_Payment_Block_Form {

	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('boletobancario/form.phtml');
	}

}