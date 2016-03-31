<?php
/**
 * @category    Inovarti
 * @package     Inovarti_BoletoBancario
 * @copyright   Copyright (c) 2015 Inovarti. (http://www.inovarti.com.br)
 */

class Inovarti_BoletoBancario_StandardController extends Mage_Core_Controller_Front_Action {

	public function viewAction() {

		$id 		= $this->getRequest()->getParam('hash');
		$recovery	= $this->getRequest()->getParam('recovery');
		$hash 		=  Mage::helper('boletobancario')->decode($id);
		$hash       = explode(';', $hash);
		$orderId        = $hash[0];
		$customerId     = $hash[1];

		$order = Mage::getModel('sales/order')->load($orderId);
		if (!$order->getId()) {
			$this->_forward('noRoute');
			return false;
		}

		/** Trata Boleto Vencido ou Cancelado */
		$dataVencimento 	= $order->getPayment()->getMethodInstance()->getDaysToExpire($order);
		$dataAtual 			= Mage::helper('boletobancario')->getDiasUteis(date('Y-m-d', Mage::getModel('core/date')->timestamp(time())));
		$dataCancelamento 	= Mage::helper('boletobancario')->getDiasUteis($dataAtual,2);

		//if ($dataAtual > $dataCancelamento  && $order->getStatus() == "canceled") {
		if ($order->getStatus() == "canceled") {

			/** sessao para logar o cliente */
			$session = Mage::getSingleton('customer/session');
			if(!$session->isLoggedIn()) {
				$customer = Mage::getModel('customer/customer')->load($customerId);

				if(is_null($customer)) $this->_redirect("/");

				/** logando cliente */
				$session->setCustomer($customer);
			}

			/** @var  $cart Mage_Checkout_Model_Cart */
			$cart = Mage::getSingleton('checkout/cart');
			$items = $order->getItemsCollection();
			foreach ($items as $item) {
				try {
					$cart->addOrderItem($item);
				} catch (Mage_Core_Exception $e){
					if (Mage::getSingleton('checkout/session')->getUseNotice(true)) {
						Mage::getSingleton('checkout/session')->addNotice($e->getMessage());
					}
					else {
						Mage::getSingleton('checkout/session')->addError($e->getMessage());
					}
					$this->_redirect('*/*/history');
				} catch (Exception $e) {
					Mage::getSingleton('checkout/session')->addException($e,
						Mage::helper('checkout')->__('Cannot add the item to shopping cart.')
					);
					$this->_redirect('checkout/cart');
				}
			}
			$cart->save();

			if ($recovery){
				Mage::getSingleton('checkout/session')->addNotice(Mage::helper('boletobancario')->__('Seu Pedido Expirou! Não foi possível identificar seu pagamento até a data de vencimento da fatura <strong>(%s)</strong>. Incluimos automaticamente em seu carrinho.', date('d/m/Y', strtotime($dataVencimento) )));
				$this->_redirect('checkout/cart');
				return true;
			}

			Mage::getSingleton('checkout/session')->addError(Mage::helper('boletobancario')->__('Seu Pedido Expirou! Não foi possível identificar seu pagamento até a data de vencimento da fatura <strong>(%s)</strong>. Solicitamos que refaça o pedido ou entre em contato com a nossa Central de Atendimento %s.', date('d/m/Y', strtotime($dataVencimento) ), Mage::getStoreConfig('general/store_information/phone')));
			$this->_redirect('checkout/cart');
			return true;
		}

		$pdf = Mage::helper('wkhtmltopdf')->getPdf($order->getPayment()->getMethodInstance()->getBoleto());

		$filename = 'boletobancario_'.$order->getIncrementId(). '.pdf';
		$this->getResponse()
			->setHeader('Content-Type', 'application/pdf')
			->setHeader('Content-Disposition', 'inline; filename="'. $filename .'"')
			->setHeader('Content-Transfer-Encoding', 'binary')
			->setHeader('Accept-Ranges', 'bytes')
			->sendHeaders();

		$this->getResponse()->setBody($pdf);

	}
}