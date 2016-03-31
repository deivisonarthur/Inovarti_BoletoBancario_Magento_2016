<?php
/**
 * @category    Inovarti
 * @package     Inovarti_BoletoBancario
 * @copyright   Copyright (c) 2015 Inovarti. (http://www.inovarti.com.br)
 */
$installer = new Mage_Sales_Model_Resource_Setup('core_setup');

$installer->startSetup();

$installer->addAttribute('order', 'boleto_bancario_numero', array('type' => Varien_Db_Ddl_Table::TYPE_TEXT,'length' => 50,'grid' => true));
$installer->addAttribute('order', 'boleto_bancario_banco', array('type' => Varien_Db_Ddl_Table::TYPE_TEXT,'length' => 50,'grid' => true));

$installer->endSetup();