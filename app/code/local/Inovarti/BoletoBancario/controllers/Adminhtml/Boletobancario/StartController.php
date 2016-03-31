<?php

/**
 *
 * @category   Inovarti
 * @package    Inovarti_OrderNumber
 * @author     Suporte <suporte@inovarti.com.br>
 */
class Inovarti_BoletoBancario_Adminhtml_Boletobancario_StartController extends Mage_Adminhtml_Controller_Action {

    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('sales/payment_boletobancario');
    }

    public function updateAction() {

        $new_number = Mage::getStoreConfig('payment/boletobancario/boleto_bancario_numero');

        $entityType = Mage::getModel('eav/entity_type')->loadByCode('boletobancario');
        $store = Mage::getModel('eav/entity_store')->loadByEntityStore($entityType->getEntityTypeId(),0);

        if ($store && $store->getId()) {
            if ($store->getIncrementLastId() < $new_number) {

                $old = $store->getIncrementLastId();
                $store->setIncrementLastId($new_number);
                $store->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    "Atualizado: " . $entityType->getEntityTypeCode() .
                    " de " . $old .
                    " para " . $new_number);
            } else {
                Mage::getSingleton('adminhtml/session')->addError(
                    "ignorado: " . $entityType->getEntityTypeCode() .
                    " porque " . $store->getIncrementLastId() .
                    " é maior do que ou igual a " . $new_number .
                    " (e você não pode alterar)");
            }
        } else {

            $store->setEntityTypeId($entityType->getEntityTypeId());
            $store->setStoreId(0);
            $store->setIncrementPrefix(0);
            $store->setIncrementLastId($new_number);
            $store->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(
                "Inserido novo valor de: " . $entityType->getEntityTypeCode() .
                " para " . $new_number);
        }

        $this->_redirectReferer();
    }

}
