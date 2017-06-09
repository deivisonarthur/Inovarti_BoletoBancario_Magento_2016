<?php
/**
 * @category    Inovarti
 * @package     Inovarti_BoletoBancario
 * @copyright   Copyright (c) 2015 Inovarti. (http://www.inovarti.com.br)
 */

class Inovarti_BoletoBancario_Model_Observer {

    const XML_PATH_BOLETOBANCARIO_ORDER_EXPIRED_EMAIL_TEMPLATE      = 'payment/boletobancario/order_expired_email_template';
    const XML_PATH_BOLETOBANCARIO_ORDER_RECOVERY_EMAIL_TEMPLATE     = 'payment/boletobancario/order_recovery_email_template';

    public function addSalesOrderGridColumns(Varien_Event_Observer $observer) {
        $helper = Mage::helper('boletobancario');
        if(!$helper->isEnabled()) return false;

        /** @var $block Mage_Adminhtml_Block_Widget_Grid */
        $block = $observer->getBlock();
        if (!isset($block)) {
            return $this;
        }
        if ($block->getType() == 'adminhtml/sales_order_grid') {

            $statuses = Mage::getSingleton('boletobancario/source_banco')->toOptionArray();

            $block->addColumnAfter('boleto_bancario_numero', array(
                'header' => Mage::helper('sales')->__('Numero do Pedido(Boleto)'),
                'index' => 'boleto_bancario_numero',
                'filter_index' => 'main_table.boleto_bancario_numero',
                'type' => 'text',
                'width' => '70px',
            ), 'real_order_id');
            /*
            $block->addColumnAfter('boleto_bancario_banco', array(
                'header' => Mage::helper('sales')->__('Banco'),
                'index' => 'boleto_bancario_banco',
                //'filter_index' => 'sales_flat_order.boleto_bancario_banco',
                'type' => 'options',
                'width' => '70px',
                'options' => $statuses,
            ), 'created_at');
            */
            $block->sortColumnsByOrder();
        }
    }

    public function verificaBoletoVencidos(){

        $helper = Mage::helper('boletobancario');
        if(!$helper->isEnabled()) return false;

        $orderCollection = Mage::getModel('sales/order')->getCollection();
        $orderCollection->addAttributeToFilter('status', array('in' => array('pending')));
        $orderCollection->getSelect()->joinLeft(array('payment_table' => $orderCollection->getTable('sales/order_payment')), "main_table.entity_id = payment_table.parent_id", array("method"), null);
        $orderCollection->addAttributeToFilter('payment_table.method', array('in' => array('boletobancario')));

        foreach ($orderCollection as $order) {

            $dataVencimento     = $order->getPayment()->getMethodInstance()->getDaysToExpire($order);
            $dataAtual          = $helper->getDiasUteis(date('Y-m-d', Mage::getModel('core/date')->timestamp(time())));
            $dataCancelamento   = $helper->getDiasUteis($dataVencimento,2);
            $dataExpiracao      = date('Y-m-d', strtotime("-1 days",strtotime($dataVencimento)));

            if ($dataVencimento > $dataCancelamento) {
                $this->sendMailRecovery($order);
            }else if ($dataExpiracao == $dataAtual){
                $this->sendMailExpired($order);
            }

        }
    }

    public function sendMailRecovery(Mage_Sales_Model_Order  $order) {
        // Get a list of the events
        $helper = Mage::helper('boletobancario');

        if(!$helper->canSendEmailRecovery()) return false;

        $paymentBlock = Mage::helper('payment')->getInfoBlock($order->getPayment())->setIsSecureMode(true);
        $paymentBlock->getMethod()->setStore($order->getStoreId());
        $paymentBlockHtml = $paymentBlock->toHtml();

        if ($order->canCancel()) {
            $vars =  array(
                'order'=>$order,
                'hash'=>Mage::getModel('core/encryption')->encrypt($order->getId().';'.$order->getBillingAddress()->getCustomerId()),
                'payment_html' => $paymentBlockHtml,
            );

            $helper->_sendEmail($order->getCustomerEmail(), $order, self::XML_PATH_BOLETOBANCARIO_ORDER_RECOVERY_EMAIL_TEMPLATE, $vars);

            $order->cancel();
            $order->save();
        }else{
            $vars =  array(
                'order'=>$order,
                'hash'=>$helper->encode($order->getId().';'.$order->getBillingAddress()->getCustomerId()),
                'payment_html' => $paymentBlockHtml,
            );

            $helper->_sendEmail($order->getCustomerEmail(), $order, self::XML_PATH_BOLETOBANCARIO_ORDER_RECOVERY_EMAIL_TEMPLATE, $vars);
        }
    }

    public function sendMailExpired(Mage_Sales_Model_Order  $order) {
        // Get a list of the events
        $helper = Mage::helper('boletobancario');

        if(!$helper->canSendEmail() && !$order->canCancel()) return false;

        $paymentBlock = Mage::helper('payment')->getInfoBlock($order->getPayment())->setIsSecureMode(true);
        $paymentBlock->getMethod()->setStore($order->getStoreId());
        $paymentBlockHtml = $paymentBlock->toHtml();

        $vars =  array(
            'order'=>$order,
            'hash'=>$helper->encode($order->getId().';'.$order->getBillingAddress()->getCustomerId()),
            'payment_html' => $paymentBlockHtml,
        );
        $helper->_sendEmail($order->getCustomerEmail(), $order, self::XML_PATH_BOLETOBANCARIO_ORDER_EXPIRED_EMAIL_TEMPLATE, $vars);

    }

}