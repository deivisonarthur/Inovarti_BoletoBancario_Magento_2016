<?php
/**
 * @category    Inovarti
 * @package     Inovarti_BoletoBancario
 * @copyright   Copyright (c) 2015 Inovarti. (http://www.inovarti.com.br)
 */


/**
 * Enter description here...
 *
 * Properties:
 * - prefix
 * - pad_length
 * - pad_char
 * - last_id
 */
class Inovarti_BoletoBancario_Model_Entity_Increment_Numeric extends Mage_Eav_Model_Entity_Increment_Abstract
{
    public function getNextId()
    {
        $last = (int)$this->getLastId();
        $next = $last+1;

        return $this->format($next);
    }


    public function format($id)
    {
        $result = str_pad((string)$id, $this->getPadLength(), $this->getPadChar(), STR_PAD_LEFT);
        return $result;
    }

    public function getPadLength()
    {
        $storeId    = $this->getStoreId();
        $banco      = Mage::getStoreConfig('payment/boletobancario/banco',$storeId);

        $padLength =  Mage::getModel('boletobancario/source_banco')->getLengthByCode($banco,$storeId);
        if (empty($padLength)) {
            $padLength = 8;
        }
        return $padLength;
    }
}
