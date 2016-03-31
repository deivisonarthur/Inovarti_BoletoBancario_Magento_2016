<?php
/**
 * @category    Inovarti
 * @package     Inovarti_BoletoBancario
 * @copyright   Copyright (c) 2015 Inovarti. (http://www.inovarti.com.br)
 */

include_once 'OpenBoleto/BoletoFactory.php';
include_once 'OpenBoleto/Agente.php';
include_once 'OpenBoleto/BoletoAbstract.php';
include_once 'OpenBoleto/Exception.php';
include_once 'OpenBoleto/Banco/BancoDoBrasil.php';
include_once 'OpenBoleto/Banco/Bradesco.php';
include_once 'OpenBoleto/Banco/Brb.php';
include_once 'OpenBoleto/Banco/Caixa.php';
include_once 'OpenBoleto/Banco/CaixaSICOB.php';
include_once 'OpenBoleto/Banco/Itau.php';
include_once 'OpenBoleto/Banco/Santander.php';
include_once 'OpenBoleto/Banco/Unicred.php';


class Inovarti_BoletoBancario_Model_Standard extends Mage_Payment_Model_Method_Abstract {

    protected $_code  = 'boletobancario';
    protected $_formBlockType = 'boletobancario/form';
    protected $_infoBlockType = 'boletobancario/info';

    /**
     * @param Mage_Sales_Model_Order $order
     * @return string
     * @throws Exception
     */
    public function getRealOrderId(Mage_Sales_Model_Order $order) {

        $realOrderId = $order->getBoletoBancarioNumero();

        if (!$realOrderId){
            /** @var $realOrderId Mage_Eav_Model_Config */
            $realOrderId = Mage::getSingleton('eav/config')
                ->getEntityType('boletobancario')
                ->fetchNewIncrementId($order->getStoreId());

            $order->setBoletoBancarioNumero($realOrderId);
            $order->setBoletoBancarioBanco($this->getConfigData('banco'),$order->getStoreId());
            $order->save();
        }

        return $realOrderId;
    }

    public function getDaysToExpire($order) {
        $day_to_expire  = ($this->getConfigData('days_to_expire',$order->getStoreId())>=3) ? $this->getConfigData('days_to_expire',$order->getStoreId()) : 2;
        $dataPedido     = $order->getCreatedAtDate()->toString('yyyy-MM-dd');
        if (Mage::helper('boletobancario')->useFeriados()){
            $model = Mage::getModel('feriados/feriados');
            $diasUteis = $model->somarData($day_to_expire, true, date('d/m/Y', strtotime($dataPedido)));
        }else{
            $diasUteis = date('d/m/Y', strtotime("+".$day_to_expire." days",strtotime($dataPedido)));
        }
        $diasUteis = strtotime(str_replace('/','-',$diasUteis));
        return date("Y-m-d",$diasUteis);
    }

    /**
     * @return array
     */
    public function prepareData(){
        $payment = $this->getInfoInstance();
        /** @var Mage_Sales_Model_Order $order */
        $order          = $payment->getOrder();
        $storeId        = $order->getStoreId();
        $realOrderId    = $this->getRealOrderId($order);

        $logo_src = Mage::getStoreConfig('design/header/logo_src_small', $storeId);

        /** Dados da Empresa*/
        $empresaNomeLoja            = $this->upper(Mage::getStoreConfig('general/store_information/name', $storeId));
        $empresaNome                = $this->upper($this->getConfigData('cedente',$storeId));
        $empresaDocumento           = preg_replace("/[^0-9]/", "", $this->getConfigData('taxvat',$storeId));
        $empresaEndereco            = $this->upper(Mage::getStoreConfig('shipping/origin/street_line1', $storeId).' '.Mage::getStoreConfig('shipping/origin/street_line2', $storeId)); //'CLS 403 Lj 23';
        $empresaCep                 = Mage::getStoreConfig('shipping/origin/postcode', $storeId);
        $empresaCidade              = $this->upper(Mage::getStoreConfig('shipping/origin/city', $storeId));
        $empresaUF                  = Mage::getStoreConfig('shipping/origin/region_id', $storeId);
        $empresaConvenio            = $this->getConfigData('convenio',$storeId);
        $empresaCarteira            = $this->getConfigData('carteira',$storeId);
        $empresaAgencia             = $this->getConfigData('agencia',$storeId);
        $empresaAgenciaDv           = $this->getConfigData('agencia_dv',$storeId);
        $empresaConta               = $this->getConfigData('conta',$storeId);
        $empresaContaDv             = $this->getConfigData('conta_dv',$storeId);
        $empresaIos                 = $this->getConfigData('ios',$storeId);

        $empresaInstructions = explode("\n", $this->getConfigData('instructions',$storeId));
        $instruction[] = '- Pagamento do pedido efetuado na loja '. $empresaNomeLoja .'.';
        $instruction[] = '- Nº do pedido: #'.$realOrderId.'.';
        for ($i = 0; $i < 2; $i++) {
            $instruction[] = isset($empresaInstructions[$i]) ? $empresaInstructions[$i] : '';
        }

        if (is_numeric($empresaUF)) {
            $empresaUF = Mage::getModel('directory/region')->load($empresaUF)->getCode();
        }

        /** Mascara CNPJ/CPF */
        if (strlen($empresaDocumento) > 11){
            $empresaDocumento = $this->mask($empresaDocumento,'##.###.###/####-##');
        }else{
            $empresaDocumento = $this->mask($empresaDocumento,'###.###.###-##');
        }

        /** Dados do Cliente*/
        $address            = $order->getBillingAddress();
        $clienteNome        = $this->upper($order->getCustomerName());
        $clienteDocumento   = preg_replace("/[^0-9]/", "", $order->getCustomerTaxvat());
        $clienteEndereco    = $this->upper($address->getStreet1().' '.$address->getStreet2().' '.$address->getStreet3().' '.$address->getStreet4());
        $clienteCep         = $address->getPostcode();
        $clienteCidade      = $this->upper($address->getCity());
        $clienteUF          = $address->getRegionCode();

        if (strlen($clienteDocumento) > 11){
            $clienteDocumento = $this->mask($clienteDocumento,'##.###.###/####-##');
        }else{
            $clienteDocumento = $this->mask($clienteDocumento,'###.###.###-##');
        }

        /** Dados do Pedido*/
        $data_vencimento = $this->getDaysToExpire($order);
        $cedente = new \OpenBoleto\Agente($empresaNome, $empresaDocumento, $empresaEndereco, $empresaCep, $empresaCidade, $empresaUF);
        $sacado = new \OpenBoleto\Agente($clienteNome, $clienteDocumento, $clienteEndereco, $clienteCep, $clienteCidade, $clienteUF);


        $data = array(
            // Parâmetros obrigatórios
            'numeroDocumento' => $realOrderId,
            'dataVencimento' => new DateTime($data_vencimento),
            'valor' =>  $order->getGrandTotal(),
            'sequencial' => $realOrderId,
            'sacado' => $sacado,
            'cedente' => $cedente,
            'agencia' => $empresaAgencia,
            'carteira' => $empresaCarteira,
            'conta' => $empresaConta,
            'convenio' => $empresaConvenio,
            'dataProcessamento' => new DateTime(),
            'dataDocumento' =>new DateTime($order->getCreatedAtDate()->toString('yyyy-MM-dd')),
            'logoPath' => Mage::getDesign()->getSkinUrl('images/logo_email.gif'), // Logo da sua empresa
            'contaDv' => $empresaContaDv,
            'agenciaDv' => $empresaAgenciaDv,
            'ios' => $empresaIos,
            'descricaoDemonstrativo' => array( // Até 5
                '- Prazo de liberação é de até 48hs após o pagamento.',
                '- Não receber após vencimento.',
                '- Não receber pagamento em cheque.',
            ),
            'instrucoes' => $instruction,
        );

        return $data;
    }

    /**
     * @return string
     * @throws \OpenBoleto\Exception
     */
    public function getBoleto(){

        $factory = new \OpenBoleto\BoletoFactory();

        $banco      = $this->getConfigData('banco');
        $caixaSICOB = $this->getConfigData('sicob');

        if ($banco==Inovarti_BoletoBancario_Model_Source_Banco::CAIXA && $caixaSICOB){
            $banco = 'caixaSICOB';
            $boleto = $factory->loadByBankName($banco,$this->prepareData());
        }else{
            $boleto = $factory->loadByBankId($banco,$this->prepareData());
        }

        return $boleto->getOutput();

    }

    /**
     * @return Inovarti_BoletoBancario_Helper_Data
     */
    protected function _getHelper() {
        return Mage::helper('boletobancario');
    }

    public function mask($val, $mask) {

        //telefone
        if ($mask=='(##) #####-####'){
            if (strlen($val)>10){
                $mask='(##) #####-####';
            }else{
                $mask='(##) ####-####';
            }
        }

        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k]))
                    $maskared .= $val[$k++];
            }
            else {
                if (isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }

    protected function upper($str)
    {
        return mb_convert_case($str, MB_CASE_UPPER, 'UTF-8');
    }

    protected function lower($str)
    {
        return mb_convert_case($str, MB_CASE_LOWER, 'UTF-8');
    }
}