<?php
/**
 * @category    Inovarti
 * @package     Inovarti_Htmltopdf
 * @copyright   Copyright (c) 2015 Inovarti. (http://www.inovarti.com.br)
 */
class Inovarti_Wkhtmltopdf_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_EXEC_PATH        = 'wkhtmltopdf/general/exec_path';

    public function getPdf($html)
    {
        $tmpDirectory   = Mage::getBaseDir('tmp') . DS . 'wkhtmltopdf';
        $uniqName       = uniqid() . '-' . sha1($html);
        $htmlFilename   = $tmpDirectory . DS . $uniqName . '.html';
        $pdfFilename    = $tmpDirectory . DS . $uniqName . '.pdf';

        $ioAdapter = new Varien_Io_File();

        // Create temporary directory for wkhtmltopdf
        $ioAdapter->checkAndCreateFolder($tmpDirectory);
        $ioAdapter->open(array('path' => $tmpDirectory));

        // Write HTML file
        $ioAdapter->write($htmlFilename, $html);

        // Create PDF
        $cmd = $this->getExecPath() . ' ' . $htmlFilename . ' ' . $pdfFilename . ' 2>&1';
        exec($cmd, $output);

        if (is_array($output)) {
            $output = implode("\n", $output);
        }
        Mage::log($output, null, 'wkhtmltopdf.log');

        if (!file_exists($pdfFilename)) {
            throw new Exception($this->__('Error converting HTML to PDF'));
        }

        return (string) $ioAdapter->read($pdfFilename);
    }

    public function getExecPath()
    {
        return Mage::getStoreConfig(self::XML_PATH_EXEC_PATH);
    }
}
