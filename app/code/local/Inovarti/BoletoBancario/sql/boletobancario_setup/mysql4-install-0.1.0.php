<?php
/**
 * @category    Inovarti
 * @package     Inovarti_BoletoBancario
 * @copyright   Copyright (c) 2015 Inovarti. (http://www.inovarti.com.br)
 */
$installer = new Mage_Eav_Model_Entity_Setup('core_setup');

$installer->startSetup();

/**
 * Install eav entity types to the eav/entity_type table
 */
$installer->addEntityType('boletobancario', array(
	'entity_model'          => 'boletobancario/standard',
	'table'                 => 'sales/order',
	'increment_model'       => 'boletobancario/entity_increment_numeric',
	'increment_per_store'   => 0,
	'increment_pad_length'  => 15
));

$installer->endSetup();