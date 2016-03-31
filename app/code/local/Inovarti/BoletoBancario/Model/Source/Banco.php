<?php
/**
 * @category    Inovarti
 * @package     Inovarti_BoletoBancario
 * @copyright   Copyright (c) 2015 Inovarti. (http://www.inovarti.com.br)
 */
class Inovarti_BoletoBancario_Model_Source_Banco  {

    const BB            = 1;
    const SANTANDER     = 33;
    const BRB           = 70;
    const UNICRED       = 90;
    const CAIXA         = 104;
    const BRADESCO      = 237;
    const ITAU          = 341;

    protected $_length = array(
        self::SANTANDER     => 13,
        self::BRB           => 13,
        self::UNICRED       => 10,
        self::CAIXA         => 8,
        self::BRADESCO      => 11,
        self::ITAU          => 8,
    );


    public function toOptionArray()
    {

        return array(
            self::BB            => 'BancoDoBrasil',
            self::SANTANDER     => 'Santander',
            self::BRB           => 'Brb',
            self::UNICRED       => 'Unicred',
            self::CAIXA         => 'Caixa',
            self::BRADESCO      => 'Bradesco',
            self::ITAU          => 'Itau'
        );
    }

    public function getLengthByCode($code, $storeId){

        if (isset($this->_length[$code])){
            return $this->_length[$code];
        }

        if ($code == self::BB){
            $convenio = Mage::getStoreConfig('payment/boletobancario/convenio', $storeId);
            $carteira = Mage::getStoreConfig('payment/boletobancario/carteira', $storeId);
            switch (strlen($convenio)) {
                case 4:
                    return 7;
                    break;
                case 6:
                    if ($carteira == 21) {
                        return 17;
                    } else {
                        return 5;
                    }
                    break;
                case 7:
                    return 10;
                    break;

            }
        }
    }


}