<?php
/**
 * @category    Inovarti
 * @package     Inovarti_BoletoBancario
 * @copyright   Copyright (c) 2015 Inovarti. (http://www.inovarti.com.br)
 */
class Inovarti_BoletoBancario_Block_Info extends Mage_Payment_Block_Info {

	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('boletobancario/info.phtml');
	}


	public function getBoletoUrl($incrementId,$storeId)
	{
		return Mage::helper('boletobancario')->getBoletoUrl($incrementId,$storeId);
	}
	
}