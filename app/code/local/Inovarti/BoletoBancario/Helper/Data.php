<?php
/**
 * @category    Inovarti
 * @package     Inovarti_BoletoBancario
 * @copyright   Copyright (c) 2015 Inovarti. (http://www.inovarti.com.br)
 */
class Inovarti_BoletoBancario_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * Url do Boleto
     */
    public function getBoletoUrl($incrementId,$storeId)
    {
        return Mage::getUrl('boletobancario/standard/view', array(
            'hash' => $this->encode($incrementId),
            '_secure'=>true,
            '_type' => 'direct_link',
            '_nosid' => true,
            '_store' => $storeId,
        ));
    }
    /**
     * criptografa os dados
     */
    public function encode($incrementId)
    {
        return $this->urlEncode(Mage::helper('core')->encrypt(base64_encode($incrementId)));
    }
    /**
     * descriptografa os dados
     */
    public function decode($encoded)
    {
        return $this->urlDecode(Mage::helper('core')->decrypt(base64_decode($encoded)));
    }
    /**
     * Verifica se esta habilitado
     */
    public function isEnabled($store = null)
    {
        $active = Mage::getStoreConfig('payment/boletobancario/active', $store);
        return $active;
    }
    /**
     * Verifica se modulo de feriados esta ativo
     */
    public function useFeriados() {
        if ($this->isModuleEnabled('Inovarti_Feriados')) {
            return true;
        }
        return false;
    }
    /**
     * Verifica se pode enviar email de pedido que vai expirar
     */
    public function canSendEmail() {
        $canSendEmail = Mage::getStoreConfig('payment/boletobancario/send_email');
        return $canSendEmail;
    }
    /**
     * Verifica se pode enviar email de pedido que vai expirar
     */
    public function canSendEmailRecovery() {
        $canSendEmailRecovery = Mage::getStoreConfig('payment/boletobancario/order_auto_cancel');
        return $canSendEmailRecovery;
    }
    /**
     * Verifica dias uteis passando data;
     */
    public function getDiasUteis($dataPedido,$day=0) {
        if ($this->useFeriados()){
            $model = Mage::getModel('feriados/feriados');
            $diasUteis = $model->somarData($day, true, date('d/m/Y', strtotime($dataPedido)));
        }else{
            $diasUteis = date('d/m/Y', strtotime("+".$day." days",strtotime($dataPedido)));
        }
        $diasUteis = strtotime(str_replace('/','-',$diasUteis));
        return date("Y-m-d",$diasUteis);
    }
    /**
     * Envia o email
     */
    public function _sendEmail($to, $order, $templateConfigPath, $vars = array()) {

        if (!$to || !$templateConfigPath) return;

        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $mailTemplate = Mage::getModel('core/email_template');
        /* @var $mailTemplate Mage_Core_Model_Email_Template */

        $template   = Mage::getStoreConfig($templateConfigPath, $order->getStore()->getId());
        $name       = Mage::getStoreConfig('trans_email/ident_general/name',$order->getStore()->getId());

        $mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$order->getStore()->getId()));

        //$vars =  array(
        //    'order'=>$order,
        //    'hash'=>Mage::getModel('core/encryption')->encrypt($order->getId().';'.$order->getBillingAddress()->getCustomerId())
        //);

        $mailTemplate->sendTransactional($template,Mage::getStoreConfig(Mage_Sales_Model_Order::XML_PATH_EMAIL_IDENTITY,$order->getStore()->getId()),$to,$name,$vars);

        if (!$mailTemplate->getSentSuccess()) {
            throw new Exception('Não pode enviar o email');
        }

        $translate->setTranslateInline(true);

        return $this;
    }

}