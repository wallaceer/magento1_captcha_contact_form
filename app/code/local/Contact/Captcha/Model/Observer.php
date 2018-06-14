<?php

/**
 * Magento 1 Capthca Contact Form
 * Class Contact_Captcha_Model_Observer
 * @author wallaceer
 * @email wallaceer@yahoo.com
 *
 */


class Contact_Captcha_Model_Observer extends Mage_Captcha_Model_Observer
{

    protected static $formId = 'contacts';

    /**
     * Check if captcha code is correct
     * @param unknown $observer
     * @return Contact_Captcha_Model_Observer
     */
    public function checkContacts($observer){
        //$formId = 'contacts';
        $captchaModel = Mage::helper('captcha')->getCaptcha(self::$formId);
        if ($captchaModel->isRequired()) {
            $controller = $observer->getControllerAction();
            $inputData = $this->_getCaptchaString($controller->getRequest(), self::$formId);
            if (!$captchaModel->isCorrect($inputData)) {
                Mage::getSingleton('customer/session')->addError(Mage::helper('captcha')->__('Incorrect CAPTCHA.'));
                $controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
                $url =  Mage::getUrl('contacts');
                $controller->getResponse()->setRedirect($url);
            }
        }
        return $this;
    }
    
    
    
    /**
     * Get Captcha String
     *
     * @param Varien_Object $request
     * @param string $formId
     * @return string
     */
    protected function _getCaptchaString($request, $formId)
    {
        $captchaParams = $request->getPost(Mage_Captcha_Helper_Data::INPUT_NAME_FIELD_VALUE);
        return $captchaParams[$formId];
    }
    
    
}